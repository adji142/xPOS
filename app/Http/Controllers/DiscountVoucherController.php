<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Log;
use App\Models\DiscountVoucher;

class DiscountVoucherController extends Controller
{
    // View halaman utama Discount Voucher
    public function View(Request $request)
    {
        $field = ['VoucherCode', 'DiscountDescription'];
        $keyword = $request->input('keyword');

        $discountvouchers = DiscountVoucher::where(function ($query) use ($keyword, $field) {
            foreach ($field as $column) {
                $query->orWhere($column, 'like', '%' . $keyword . '%');
            }
        })
        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
        ->get();

        $title = 'Delete Voucher!';
        $text = "Are you sure you want to delete this voucher?";
        confirmDelete($title, $text);

        return view("setting.DiscountVoucher", [
            'discountvouchers' => $discountvouchers
        ]);
    }

    // View versi JSON
    public function ViewJson(Request $request)
    {
        $data = ['success' => false, 'message' => '', 'data' => []];

        try {
            $list = DiscountVoucher::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
            $data['success'] = true;
            $data['data'] = $list;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    // Menampilkan form input/edit
    public function Form($id = null)
    {
        $voucher = DiscountVoucher::where('id', $id)->first();

        return view("setting.DiscountVoucher-Input", [
            'voucher' => $voucher
        ]);
    }

    // Simpan data voucher baru
    public function store(Request $request)
    {
        Log::debug($request->all());

        try {
            $this->validate($request, [
                'VoucherCode' => 'required',
                'DiscountPercent' => 'required|numeric',
                'MaximalDiscount' => 'required|numeric',
                'StartDate' => 'required|date',
                'EndDate' => 'required|date|after_or_equal:StartDate',
                'DiscountQuota' => 'required|numeric',
                'DiscountDescription' => 'nullable|string'
            ]);

            $model = new DiscountVoucher();
            $model->VoucherCode = $request->input('VoucherCode');
            $model->DiscountPercent = $request->input('DiscountPercent');
            $model->MaximalDiscount = $request->input('MaximalDiscount');
            $model->StartDate = $request->input('StartDate');
            $model->EndDate = $request->input('EndDate');
            $model->DiscountQuota = $request->input('DiscountQuota');
            $model->DiscountUsed = 0;
            $model->DiscountDescription = $request->input('DiscountDescription');
            $model->CreatedBy = Auth::user()->name;
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            if ($model->save()) {
                alert()->success('Success', 'Voucher berhasil disimpan.');
                return redirect('discountvoucher');
            } else {
                throw new \Exception('Simpan voucher gagal.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    // Edit data voucher (via form)
    public function edit(Request $request)
    {
        Log::debug($request->all());

        try {
            $this->validate($request, [
                'id' => 'required|integer',
                'VoucherCode' => 'required',
                'DiscountPercent' => 'required|numeric',
                'MaximalDiscount' => 'required|numeric',
                'StartDate' => 'required|date',
                'EndDate' => 'required|date|after_or_equal:StartDate',
                'DiscountQuota' => 'required|numeric',
                'DiscountDescription' => 'nullable|string'
            ]);

            $update = DB::table('discountvoucher')
                ->where('id', $request->input('id'))
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'VoucherCode' => $request->input('VoucherCode'),
                    'DiscountPercent' => $request->input('DiscountPercent'),
                    'MaximalDiscount' => $request->input('MaximalDiscount'),
                    'StartDate' => $request->input('StartDate'),
                    'EndDate' => $request->input('EndDate'),
                    'DiscountQuota' => $request->input('DiscountQuota'),
                    'DiscountDescription' => $request->input('DiscountDescription'),
                    'UpdatedBy' => Auth::user()->name,
                    'updated_at' => Carbon::now()
                ]);

            if ($update) {
                alert()->success('Success', 'Voucher berhasil diperbarui.');
                return redirect('discountvoucher');
            } else {
                throw new \Exception('Edit voucher gagal.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    // Simpan data via JSON (API)
    public function storeJson(Request $request)
    {
        Log::debug($request->all());

        $data = ['success' => false, 'message' => ''];

        try {
            $model = new DiscountVoucher();
            $model->VoucherCode = $request->input('VoucherCode');
            $model->DiscountPercent = $request->input('DiscountPercent');
            $model->MaximalDiscount = $request->input('MaximalDiscount');
            $model->StartDate = $request->input('StartDate');
            $model->EndDate = $request->input('EndDate');
            $model->DiscountQuota = $request->input('DiscountQuota');
            $model->DiscountUsed = 0;
            $model->DiscountDescription = $request->input('DiscountDescription');
            $model->CreatedBy = Auth::user()->name;
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            if ($model->save()) {
                $data['success'] = true;
            } else {
                $data['message'] = 'Simpan voucher gagal.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    // Edit data via JSON (API)
    public function editJson(Request $request)
    {
        Log::debug($request->all());

        $data = ['success' => false, 'message' => ''];

        try {
            $update = DB::table('discountvoucher')
                ->where('id', $request->input('id'))
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'VoucherCode' => $request->input('VoucherCode'),
                    'DiscountPercent' => $request->input('DiscountPercent'),
                    'MaximalDiscount' => $request->input('MaximalDiscount'),
                    'StartDate' => $request->input('StartDate'),
                    'EndDate' => $request->input('EndDate'),
                    'DiscountQuota' => $request->input('DiscountQuota'),
                    'DiscountDescription' => $request->input('DiscountDescription'),
                    'UpdatedBy' => Auth::user()->name,
                    'updated_at' => Carbon::now()
                ]);

            if ($update) {
                $data['success'] = true;
            } else {
                $data['message'] = 'Edit voucher gagal.';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }

        return response()->json($data);
    }

    // Hapus data
    public function deletedata(Request $request)
    {
        try {
            $delete = DB::table('discountvoucher')
                ->where('id', $request->id)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->delete();

            if ($delete) {
                alert()->success('Success', 'Voucher berhasil dihapus.');
            } else {
                alert()->error('Error', 'Hapus voucher gagal.');
            }

            return redirect('discountvoucher');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function checkVoucher(Request $request)
    {
        $voucher = DiscountVoucher::where('VoucherCode', $request->voucher)
                    ->where('RecordOwnerID', $request->RecordOwnerID)
                    ->first();

        if (!$voucher) {
            return response()->json(['valid' => false, 'message' => 'Kode voucher tidak ditemukan.']);
        }

        // Cek tanggal berlaku
        $today = now()->toDateString();
        if ($voucher->StartDate > $today || $voucher->EndDate < $today) {
            return response()->json(['valid' => false, 'message' => 'Voucher sudah tidak berlaku.']);
        }

        // Cek quota
        if ($voucher->DiscountUsed >= $voucher->DiscountQuota) {
            return response()->json(['valid' => false, 'message' => 'Voucher telah mencapai batas penggunaan.']);
        }

        // Hitung diskon
        $subtotal = (float) $request->subtotal;
        $diskonPersen = (float) $voucher->DiscountPercent;
        $maksDiskon = (float) $voucher->MaximalDiscount;

        $calculatedDiscount = $subtotal * $diskonPersen / 100;
        $appliedDiscount = min($calculatedDiscount, $maksDiskon);

        return response()->json([
            'valid' => true,
            'message' => "Voucher berhasil digunakan! Anda mendapat potongan Rp" . number_format($appliedDiscount),
            'applied_discount' => $appliedDiscount
        ]);
    }
}
