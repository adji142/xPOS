<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TableOrderHeader;
use Carbon\Carbon;

class ProcessBookingToActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:process-booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate scheduled bookings when start time is reached.';

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
        $this->info("Processing bookings starting at or before: " . $now->toDateTimeString());

        // Find Draft (D) records with Status 0 where JamMulai <= NOW
        $bookings = TableOrderHeader::where('DocumentStatus', 'D')
                        ->where('Status', 0)
                        ->where('JamMulai', '<=', $now)
                        ->get();

        $count = 0;
        foreach ($bookings as $booking) {
            // Check if there are any active ('O') or unpaid ('-1') orders for the same table
            $blockingOrdersCount = DB::table('tableorderheader')
                ->where('RecordOwnerID', $booking->RecordOwnerID)
                ->where('tableid', $booking->tableid)
                ->where(function ($query) {
                    $query->where('DocumentStatus', 'O')
                          ->orWhere('Status', -1);
                })
                ->count();

            if ($blockingOrdersCount > 0) {
                $this->info("Skipped activating Order: " . $booking->NoTransaksi . " due to existing active or unpaid orders on Table ID: " . $booking->tableid);
                continue;
            }

            DB::beginTransaction();
            try {
                DB::table('tableorderheader')
                    ->where('NoTransaksi', $booking->NoTransaksi)
                    ->where('RecordOwnerID', $booking->RecordOwnerID)
                    ->update(['Status' => 1, 'DocumentStatus' => 'O']);

                // Update Table Status to Occupied (1)
                DB::table('titiklampu')
                    ->where('id', $booking->tableid)
                    ->where('RecordOwnerID', $booking->RecordOwnerID)
                    ->update(['Status' => 1]);

                DB::commit();
                $this->info("Activated Order: " . $booking->NoTransaksi . " for Table ID: " . $booking->tableid);
                $count++;
            } catch (\Exception $e) {
                DB::rollback();
                $this->error("Failed to activate Order " . $booking->NoTransaksi . ": " . $e->getMessage());
                Log::error("ProcessBookingToActive Error: " . $e->getMessage());
            }
        }

        $this->info("Successfully processed $count bookings.");

        // --- NEW LOGIC: Process Expired Orders ---
        $this->info("Checking for expired active orders...");
        $expiredOrders = TableOrderHeader::where('DocumentStatus', 'O')
                            ->whereNotNull('JamSelesai')
                            ->where('JamSelesai', '<=', $now)
                            ->get();

        $expiredCount = 0;
        foreach ($expiredOrders as $order) {
            try {
                // Check payment status from fakturpenjualanheader
                // An order is considered paid if there's a closed (C) invoice where TotalPembayaran >= TotalPembelian
                $isPaid = DB::table('fakturpenjualandetail')
                    ->join('fakturpenjualanheader', function($join) {
                        $join->on('fakturpenjualanheader.NoTransaksi', '=', 'fakturpenjualandetail.NoTransaksi')
                             ->on('fakturpenjualanheader.RecordOwnerID', '=', 'fakturpenjualandetail.RecordOwnerID');
                    })
                    ->where('fakturpenjualandetail.BaseReff', $order->NoTransaksi)
                    ->where('fakturpenjualandetail.RecordOwnerID', $order->RecordOwnerID)
                    ->where('fakturpenjualanheader.Status', 'C')
                    ->whereRaw('fakturpenjualanheader.TotalPembayaran >= fakturpenjualanheader.TotalPembelian')
                    ->exists();

                if ($isPaid || $order->JenisPaket === 'PAKETMEMBER') {
                    // Paid or PAKETMEMBER: Close the order
                    DB::table('tableorderheader')
                        ->where('NoTransaksi', $order->NoTransaksi)
                        ->where('RecordOwnerID', $order->RecordOwnerID)
                        ->update([
                            'Status' => 0,
                            'DocumentStatus' => 'C'
                        ]);
                    
                    $this->info("Closed expired " . ($order->JenisPaket === 'PAKETMEMBER' ? "PAKETMEMBER session: " : "paid Order: ") . $order->NoTransaksi);
                } else {
                    // Unpaid: Set status to -1 (Warning/Unpaid State)
                    DB::table('tableorderheader')
                        ->where('NoTransaksi', $order->NoTransaksi)
                        ->where('RecordOwnerID', $order->RecordOwnerID)
                        ->update([
                            'Status' => -1
                        ]);
                    $this->info("Marked expired unpaid Order as -1: " . $order->NoTransaksi);
                }

                $expiredCount++;
            } catch (\Exception $e) {
                $this->error("Failed to process expired Order " . $order->NoTransaksi . ": " . $e->getMessage());
                Log::error("ProcessBookingToActive Expired Logic Error: " . $e->getMessage());
            }
        }

        $this->info("Successfully processed $expiredCount expired orders.");
        return 0;
    }
}
