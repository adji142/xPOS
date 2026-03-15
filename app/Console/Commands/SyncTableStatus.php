<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\TableOrderHeader;
use App\Models\TitikLampu;

class SyncTableStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:sync-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync titiklampu status with tableorderheader status.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info("SyncTableStatus: Command started.");
        $this->info("Checking for occupied tables without active orders...");

        // Get all tables that are currently marked as occupied (Status = 1)
        $occupiedTables = TitikLampu::where('Status', 1)->get();

        $count = 0;
        foreach ($occupiedTables as $table) {
            // Check if there's any active order (Status = 1) for this table
            $activeOrderExists = TableOrderHeader::where('tableid', $table->id)
                                    ->where('Status', 1)
                                    ->where('RecordOwnerID', $table->RecordOwnerID)
                                    ->exists();

            if (!$activeOrderExists) {
                DB::beginTransaction();
                try {
                    // Update table status to 0 (Available)
                    $table->Status = 0;
                    $table->save();

                    DB::commit();
                    $this->info("Table ID " . $table->id . " set to Available (no active order found).");
                    $count++;
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->error("Failed to update status for table ID " . $table->id . ": " . $e->getMessage());
                    Log::error("SyncTableStatus Error: " . $e->getMessage());
                }
            }

            // Cek anomali order

            $anomalies = TableOrderHeader::where('tableid', $table->id)
                            ->where('Status', 1)
                            ->where('RecordOwnerID', $table->RecordOwnerID)
                            ->whereIn('DocumentStatus', ['D', 'C'])
                            ->exists();

            if ($anomalies) {
                DB::beginTransaction();
                try {
                    // Update table status to 0 (Available)
                    DB::table('tableorderheader')
                    ->whereIn('DocumentStatus', ['D', 'C'])
                    ->where('Status','=', '1')
                    ->where('RecordOwnerID','=',$table->RecordOwnerID)
                    ->where('JamSelesai', '<=', Carbon::now()) 
                    ->update(
                        [
                            'DocumentStatus'=>'C',
                            'Status'=>'0'
                        ]
                    );
                    DB::commit();
                    $this->info("Table ID " . $table->id . " set to Available (no active order found).");
                    $count++;
                } catch (\Exception $e) {
                    DB::rollback();
                    $this->error("Failed to update status for table ID " . $table->id . ": " . $e->getMessage());
                    Log::error("SyncTableStatus Error: " . $e->getMessage());
                }
            }
                            
        }



        $this->info("Synced $count tables.");
        Log::info("SyncTableStatus: Command finished. Synced $count tables.");
        return 0;
    }
}
