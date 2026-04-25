<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Log;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function View(Request $request)
    {
        $keyword = $request->input('keyword');

        $vouchers = Voucher::when($keyword, function ($q) use ($keyword) {
                $q->where('code', 'like', '%' . $keyword . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $title = 'Hapus Voucher!';
        $text  = "Apakah Anda yakin ingin menghapus voucher ini?";
        confirmDelete($title, $text);

        return view('Admin.Voucher', ['vouchers' => $vouchers]);
    }

    public function ViewJson(Request $request)
    {
        $data = ['success' => false, 'message' => '', 'data' => []];
        try {
            $data['data']    = Voucher::orderBy('created_at', 'desc')->get();
            $data['success'] = true;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function Form($id = null)
    {
        $voucher = ($id && $id !== '-') ? Voucher::find($id) : null;
        return view('Admin.Voucher-Input', ['voucher' => $voucher]);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'code'          => 'required|string|unique:vouchers,code',
                'type'          => 'required|in:percentage,fixed',
                'value'         => 'required|numeric|min:0',
                'max_discount'  => 'nullable|numeric|min:0',
                'usage_limit'   => 'nullable|integer|min:1',
                'expires_at'    => 'nullable|date',
                'is_active'     => 'nullable|boolean',
            ]);

            $model              = new Voucher();
            $model->code        = strtoupper(trim($request->input('code')));
            $model->type        = $request->input('type');
            $model->value       = $request->input('value');
            $model->max_discount= $request->input('max_discount');
            $model->usage_limit = $request->input('usage_limit');
            $model->used_count  = 0;
            $model->expires_at  = $request->input('expires_at') ? Carbon::parse($request->input('expires_at'))->endOfDay() : null;
            $model->is_active   = $request->input('is_active', 1);

            if ($model->save()) {
                alert()->success('Berhasil', 'Voucher berhasil disimpan.');
                return redirect('voucher');
            }

            throw new \Exception('Gagal menyimpan voucher.');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit(Request $request)
    {
        try {
            $this->validate($request, [
                'id'            => 'required|integer',
                'code'          => 'required|string|unique:vouchers,code,' . $request->input('id'),
                'type'          => 'required|in:percentage,fixed',
                'value'         => 'required|numeric|min:0',
                'max_discount'  => 'nullable|numeric|min:0',
                'usage_limit'   => 'nullable|integer|min:1',
                'expires_at'    => 'nullable|date',
                'is_active'     => 'nullable|boolean',
            ]);

            $expiresAt = $request->input('expires_at')
                ? Carbon::parse($request->input('expires_at'))->endOfDay()
                : null;

            DB::table('vouchers')
                ->where('id', $request->input('id'))
                ->update([
                    'code'         => strtoupper(trim($request->input('code'))),
                    'type'         => $request->input('type'),
                    'value'        => $request->input('value'),
                    'max_discount' => $request->input('max_discount'),
                    'usage_limit'  => $request->input('usage_limit'),
                    'expires_at'   => $expiresAt,
                    'is_active'    => $request->input('is_active', 1),
                    'updated_at'   => Carbon::now(),
                ]);

            alert()->success('Berhasil', 'Voucher berhasil diperbarui.');
            return redirect('voucher');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function deletedata(Request $request, $id)
    {
        try {
            $deleted = DB::table('vouchers')->where('id', $id)->delete();

            if ($deleted) {
                alert()->success('Berhasil', 'Voucher berhasil dihapus.');
            } else {
                alert()->error('Error', 'Voucher tidak ditemukan.');
            }

            return redirect('voucher');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function checkVoucher(Request $request)
    {
        $data = ['valid' => false, 'message' => '', 'discount_amount' => 0, 'final_price' => 0];

        try {
            $voucher = Voucher::where('code', strtoupper(trim($request->input('code'))))
                ->where('is_active', 1)
                ->first();

            if (!$voucher) {
                $data['message'] = 'Kode voucher tidak ditemukan atau tidak aktif.';
                return response()->json($data);
            }

            if ($voucher->expires_at && Carbon::parse($voucher->expires_at)->isPast()) {
                $data['message'] = 'Voucher sudah kedaluwarsa.';
                return response()->json($data);
            }

            if ($voucher->usage_limit !== null && $voucher->used_count >= $voucher->usage_limit) {
                $data['message'] = 'Voucher telah mencapai batas penggunaan.';
                return response()->json($data);
            }

            $subtotal = (float) $request->input('subtotal', 0);

            if ($voucher->type === 'percentage') {
                $discount = $subtotal * ($voucher->value / 100);
                if ($voucher->max_discount) {
                    $discount = min($discount, (float) $voucher->max_discount);
                }
            } else {
                $discount = (float) $voucher->value;
            }

            $discount   = min($discount, $subtotal);
            $finalPrice = $subtotal - $discount;

            $data['valid']           = true;
            $data['discount_amount'] = $discount;
            $data['final_price']     = $finalPrice;
            $data['voucher_type']    = $voucher->type;
            $data['voucher_value']   = $voucher->value;
            $data['message']         = 'Voucher berhasil diterapkan!';
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = 'Terjadi kesalahan saat memvalidasi voucher.';
        }

        return response()->json($data);
    }

    public function toggleActive(Request $request, $id)
    {
        $data = ['success' => false, 'message' => ''];
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->is_active = !$voucher->is_active;
            $voucher->save();
            $data['success']   = true;
            $data['is_active'] = $voucher->is_active;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }
}
