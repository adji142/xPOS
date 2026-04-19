<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek pelanggan yang masa langganannya akan habis dalam 7 hari dan generate tagihan baru.';

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
        $this->info('Memulai pengecekan langganan...');

        $targetDate = \Carbon\Carbon::now()->addDays(7)->format('Y-m-d');
        $companies = \App\Models\Company::where('EndSubs', '<=', $targetDate)
            ->where('isActive', 1)
            ->get();

        if ($companies->isEmpty()) {
            $this->info('Tidak ada pelanggan yang akan habis masa langganannya dalam 7 hari.');
            return 0;
        }

        foreach ($companies as $company) {
            $this->info("Mengecek pelanggan: {$company->NamaPartner} ({$company->KodePartner})");

            // Cek apakah ada tagihan yang belum dibayar
            $existingInvoice = \App\Models\InvoicePenggunaHeader::where('KodePelanggan', $company->KodePartner)
                ->where('Status', '<>', 'D')
                ->whereRaw('TotalTagihan > TotalBayar')
                ->first();

            if ($existingInvoice) {
                $this->warn("Pelanggan {$company->NamaPartner} sudah memiliki tagihan yang belum dibayar: {$existingInvoice->NoTransaksi}. Skip generate.");
                continue;
            }

            // Ambil data paket langganan
            $subscription = \App\Models\SubscriptionHeader::where('NoTransaksi', $company->KodePaketLangganan)->first();
            if (!$subscription) {
                $this->error("Paket langganan {$company->KodePaketLangganan} tidak ditemukan untuk pelanggan {$company->NamaPartner}.");
                continue;
            }

            // Generate NoTransaksi (INV + sequence)
            $prefix = "INV";
            $lastNoTrx = \App\Models\InvoicePenggunaHeader::where(\DB::raw('LEFT(NoTransaksi,3)'), '=', $prefix)->count() + 1;
            $noTransaksi = $prefix . str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);

            // Double check for unique NoTransaksi in case of race conditions or existing data patterns
            while (\App\Models\InvoicePenggunaHeader::where('NoTransaksi', $noTransaksi)->exists()) {
                $lastNoTrx++;
                $noTransaksi = $prefix . str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);
            }

            $totalTagihan = floatval($subscription->Harga);
            if (isset($subscription->Potongan)) {
                $totalTagihan -= floatval($subscription->Potongan);
            }

            // Tentukan periode langganan baru
            $startSubs = \Carbon\Carbon::parse($company->EndSubs)->addDay();
            // Asumsi LamaSubsription dalam hari (misal 30)
            $endSubs = (clone $startSubs)->addDays($subscription->LamaSubsription ?? 30);

            \DB::beginTransaction();
            try {
                // Header
                $invoiceHeader = new \App\Models\InvoicePenggunaHeader();
                $invoiceHeader->NoTransaksi = $noTransaksi;
                $invoiceHeader->TglTransaksi = \Carbon\Carbon::now()->format('Y-m-d');
                $invoiceHeader->TglJatuhTempo = \Carbon\Carbon::parse($company->EndSubs)->format('Y-m-d'); // Jatuh tempo di hari terakhir langganan saat ini
                $invoiceHeader->KodePaketLangganan = $company->KodePaketLangganan;
                $invoiceHeader->Catatan = 'Tagihan Langganan Otomatis: ' . $subscription->NamaSubscription . ' (Periode ' . $startSubs->format('d/m/Y') . ' - ' . $endSubs->format('d/m/Y') . ')';
                $invoiceHeader->KodePelanggan = $company->KodePartner;
                $invoiceHeader->TotalTagihan = $totalTagihan;
                $invoiceHeader->TotalBayar = 0;
                $invoiceHeader->Status = 'O';
                $invoiceHeader->StartSubs = $startSubs->format('Y-m-d');
                $invoiceHeader->EndSubs = $endSubs->format('Y-m-d');
                $invoiceHeader->save();

                // Detail
                $invoiceDetail = new \App\Models\InvoicePenggunaDetail();
                $invoiceDetail->NoTransaksi = $noTransaksi;
                $invoiceDetail->NoUrut = 0;
                $invoiceDetail->Harga = $totalTagihan;
                $invoiceDetail->Catatan = 'Biaya Langganan ' . $subscription->NamaSubscription;
                $invoiceDetail->KodePelanggan = $company->KodePartner;
                $invoiceDetail->save();

                \DB::commit();
                $this->info("Tagihan berhasil digenerate: {$noTransaksi} untuk {$company->NamaPartner}");
            } catch (\Exception $e) {
                \DB::rollback();
                $this->error("Gagal generate tagihan untuk {$company->NamaPartner}: " . $e->getMessage());
            }
        }

        $this->info('Pengecekan selesai.');
        return 0;
    }
}
