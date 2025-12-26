<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TableOrderHeader;
use App\Models\TitikLampu;

class UpdateBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update booking status from 0 (Scheduled) to 1 (Active) when start time is reached.';

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
        $now = Carbon::now();
        
        $this->info("Checking for bookings to activate at " . $now);

        // Find orders where Status is 0 (Scheduled), DocumentStatus is O (Open), and JamMulai <= NOW
        $orders = TableOrderHeader::where('Status', '0')
                    ->where('DocumentStatus', 'D')
                    ->where('JamMulai', '<=', $now)
                    ->get();

        $count = 0;
        foreach ($orders as $order) {
            
            DB::beginTransaction();
            try {
                // Update Order Status to 1 (Active)
                // $order->Status = '1';
                // $order->save();
                DB::table('tableorderheader')
                        ->where('NoTransaksi','=', $order->NoTransaksi)
                        ->where('RecordOwnerID','=',$order->RecordOwnerID)
                        ->update(
                            [
                                'Status'=>1,
                                'DocumentStatus'=>'O'
                            ]
                        );

                // Also update TitikLampu status to 1 (Active/Occupied) if it's currently 0 or reserved? 
                // Usually Billing view logic derives status from order, but updating table status is good practice.
                // Assuming TableID maps to TitikLampu ID
                $table = TitikLampu::find($order->tableid);
                if ($table) {
                    // Update table status to 1 (Active)
                    $table->Status = 1; 
                    $table->save();
                }

                DB::commit();
                $this->info("Activated Order: " . $order->NoTransaksi);
                $count++;
            } catch (\Exception $e) {
                DB::rollback();
                $this->error("Failed to activate order " . $order->NoTransaksi . ": " . $e->getMessage());
            }
        }

        $this->info("Activated $count bookings.");
        return 0;
    }
}
