<?php

namespace App\Services;

use App\Models\SettingAccount;
use App\Models\Rekening;
use App\Models\AutoPosting;
use Illuminate\Support\Facades\Auth;

class AccountingService
{
    private $header = [];
    private $details = [];
    private $isCancelation = false;
    private $recordOwnerID;

    /**
     * Inisialisasi Header Jurnal
     * 
     * @param string $kodeTransaksi
     * @param string $tglTransaksi
     * @param string $noReff
     * @param string $statusTransaksi
     * @param bool $isCancelation
     * @return $this
     */
    public function initialize($kodeTransaksi, $tglTransaksi, $noReff, $statusTransaksi, $isCancelation = false)
    {
        $this->recordOwnerID = Auth::user()->RecordOwnerID;
        $this->isCancelation = $isCancelation;

        $this->header = [
            'NoTransaksi' => "",
            'KodeTransaksi' => $kodeTransaksi,
            'TglTransaksi' => $tglTransaksi,
            'NoReff' => $noReff,
            'StatusTransaksi' => $statusTransaksi,
            'RecordOwnerID' => $this->recordOwnerID,
        ];

        $this->details = [];

        return $this;
    }

    /**
     * Mendapatkan posisi Normal Debet/Kredit yang sudah disesuaikan dengan kondisi Cancelation (Batal)
     * $normalDK = 1 (Debet), 2 (Kredit)
     */
    private function getAdjustedDK($normalDK)
    {
        if ($this->isCancelation) {
            return ($normalDK == 1) ? 2 : 1;
        }
        return $normalDK;
    }

    /**
     * Tambah baris detail dari sebuah setting global account
     * 
     * @param string $settingName Kode Setting (Misal: "PjAcctPiutang")
     * @param int $normalDK Posisi Normal: 1 untuk Debet, 2 untuk Kredit
     * @param float|double $jumlah
     * @param string $keterangan
     * @return array [success => bool, message => string]
     */
    public function addDetailFromSetting($settingName, $normalDK, $jumlah, $keterangan = "")
    {
        if ($jumlah == 0) return ['success' => true, 'message' => ''];

        $setting = new SettingAccount();
        $kodeRekening = $setting->GetSetting($settingName);

        if (empty($kodeRekening)) {
            return [
                'success' => false, 
                'message' => "Kode Rekening untuk setting $settingName tidak ditemukan. Silahkan Setting Akun di menu Master->Finance->Setting Account."
            ];
        }

        $validate = Rekening::where('RecordOwnerID', $this->recordOwnerID)
                            ->where('KodeRekening', $kodeRekening)->first();

        if (!$validate) {
            return [
                'success' => false, 
                'message' => "Akun Rekening Akutansi untuk setting $settingName ($kodeRekening) Tidak Valid / Tidak Ada. Silahkan Setting Akun di menu Master->Finance->Setting Account."
            ];
        }

        $this->pushDetail($kodeRekening, $normalDK, $jumlah, $keterangan);
        return ['success' => true, 'message' => ''];
    }

    /**
     * Tambah baris detail khusus dari Akun Persediaan Inventory / ItemMaster
     */
    public function addDetailForInventory($kodeItem, $normalDK, $jumlah, $keterangan = "")
    {
        if ($jumlah == 0) return ['success' => true, 'message' => ''];

        $setting = new SettingAccount();
        $kodeRekening = $setting->GetInventoryAccount($kodeItem);

        if (empty($kodeRekening)) {
            return [
                'success' => false, 
                'message' => "Akun Rekening Akutansi Inventory untuk item $kodeItem tidak ditemukan. Silahkan Setting Akun."
            ];
        }

        $validate = Rekening::where('RecordOwnerID', $this->recordOwnerID)
                            ->where('KodeRekening', $kodeRekening)->first();

        if (!$validate) {
            return [
                'success' => false, 
                'message' => "Akun Rekening Akutansi Inventory untuk item $kodeItem ($kodeRekening) Tidak Valid / Tidak Ada. Silahkan Setting Akun."
            ];
        }

        $this->pushDetail($kodeRekening, $normalDK, $jumlah, $keterangan);
        return ['success' => true, 'message' => ''];
    }

    /**
     * Tambah baris detail dengan Kode Rekening langsung 
     */
    public function addDetailWithAccount($kodeRekening, $normalDK, $jumlah, $keterangan = "")
    {
        if ($jumlah == 0) return ['success' => true, 'message' => ''];

        if (empty($kodeRekening)) {
            return [
                'success' => false,
                'message' => "Kode Rekening kosong saat memproses detail (Misal: Akun Pembayaran belum di-setting)."
            ];
        }
        
        $this->pushDetail($kodeRekening, $normalDK, $jumlah, $keterangan);
        return ['success' => true, 'message' => ''];
    }

    private function pushDetail($kodeRekening, $normalDK, $jumlah, $keterangan)
    {
        $this->details[] = [
            'KodeTransaksi' => $this->header['KodeTransaksi'], 
            'KodeRekening' => $kodeRekening,
            'KodeRekeningBukuBesar' => "",
            'DK' => $this->getAdjustedDK($normalDK), 
            'KodeMataUang' => "",
            'Valas' => 0,
            'NilaiTukar' => 0,
            'Jumlah' => $jumlah, 
            'Keterangan' => $keterangan, 
            'HeaderKas' => "",
            'RecordOwnerID' => $this->recordOwnerID
        ];
    }

    /**
     * Proses ke dalam class AutoPosting
     */
    public function save()
    {
        $autoPosting = new AutoPosting();
        $result = $autoPosting->Auto($this->header, $this->details, $this->isCancelation);

        if ($result != "OK") {
            return ['success' => false, 'message' => "Gagal Simpan Jurnal: $result"];
        }

        return ['success' => true, 'message' => 'OK'];
    }
}
