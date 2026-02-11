<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\TableOrderHeader;

class CheckTableOrderSelesai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:check-finished';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check tableorderheader and update status if JamSelesai has passed.';

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
        Log::info("CheckTableOrderSelesai: Command started.");
        $now = Carbon::now();

        try {
            // Find orders that are active (Status 1 or 99) and Open (DocumentStatus O) 
            // but have passed their JamSelesai.
            $affectedRows = DB::table('tableorderheader')
                ->whereIn('Status', [1, 99])
                ->where('DocumentStatus', 'O')
                ->where('JamSelesai', '<', $now)
                ->whereNotNull('JamSelesai')
                ->update([
                    'Status' => 0,
                    'DocumentStatus' => 'C',
                    // Optional: we might want to record when it was automatically closed
                    // 'Keterangan' => DB::raw("CONCAT(COALESCE(Keterangan, ''), ' [Auto-Closed at ' , NOW(), ']')")
                ]);

            if ($affectedRows > 0) {
                $this->info("Successfully updated $affectedRows table orders.");
                Log::info("CheckTableOrderSelesai: Updated $affectedRows orders.");
            } else {
                $this->info("No orders found to update.");
            }

        } catch (\Exception $e) {
            $this->error("Failed to update table orders: " . $e->getMessage());
            Log::error("CheckTableOrderSelesai Error: " . $e->getMessage());
            return 1;
        }

        Log::info("CheckTableOrderSelesai: Command finished.");
        return 0;
    }
}
