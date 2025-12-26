<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Log;
use App\Models\Company;

class SerialNumberController extends Controller
{
    public function View(Request $request)
    {
        $keyword = $request->input('keyword');
        $field = ['SerialNumber', 'KodePartner', 'Keterangan'];

        $data = DB::table('serial_numbers')
            ->select('serial_numbers.*')
            ->selectRaw("CASE WHEN (SELECT COUNT(*) FROM mastercontroller WHERE mastercontroller.SN = serial_numbers.SerialNumber) > 0 THEN 'CLAIMED' ELSE 'RELEASED' END as Status")
            ->where('serial_numbers.RecordOwnerID', Auth::user()->RecordOwnerID);

        if ($keyword) {
            $data->where(function ($query) use ($keyword, $field) {
                for ($i = 0; $i < count($field); $i++) {
                    $query->orwhere('serial_numbers.'.$field[$i], 'like', '%' . $keyword . '%');
                }
            });
        }

        return view("Admin.DaftarSerialNumber", [
            'data' => $data->get(),
        ]);
    }

    public function Form($id = null)
    {
        $serialNumber = null;
        if ($id && $id != '-') {
            $serialNumber = DB::table('serial_numbers')
                ->where('id', $id)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->first();
        }

        $companies = Company::all();

        return view("Admin.SerialNumber-Input", [
            'serialNumber' => $serialNumber,
            'companies' => $companies,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'SerialNumber' => 'required|unique:serial_numbers,SerialNumber',
                'KodePartner' => 'required',
            ]);

            DB::table('serial_numbers')->insert([
                'SerialNumber' => $request->input('SerialNumber'),
                'KodePartner' => $request->input('KodePartner'),
                'Keterangan' => $request->input('Keterangan'),
                'RecordOwnerID' => Auth::user()->RecordOwnerID,
                'CreatedBy' => Auth::user()->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            alert()->success('Success', 'Serial Number berhasil disimpan.');
            return redirect('serialnumber');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $this->validate($request, [
                'id' => 'required',
                'SerialNumber' => 'required|unique:serial_numbers,SerialNumber,' . $request->input('id'),
                'KodePartner' => 'required',
            ]);

            DB::table('serial_numbers')
                ->where('id', $request->input('id'))
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'SerialNumber' => $request->input('SerialNumber'),
                    'KodePartner' => $request->input('KodePartner'),
                    'Keterangan' => $request->input('Keterangan'),
                    'UpdatedBy' => Auth::user()->name,
                    'updated_at' => now(),
                ]);

            alert()->success('Success', 'Serial Number berhasil diperbarui.');
            return redirect('serialnumber');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function deletedata(Request $request)
    {
        try {
            DB::table('serial_numbers')
                ->where('id', $request->id)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->delete();

            alert()->success('Success', 'Serial Number berhasil dihapus.');
        } catch (\Exception $e) {
            alert()->error('Error', 'Gagal menghapus Serial Number.');
        }
        return redirect('serialnumber');
    }

    public function generateJson()
    {
        return response()->json([
            'success' => true,
            'serial_number' => $this->generateRandomString(10)
        ]);
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Check uniqueness
        $exists = DB::table('serial_numbers')->where('SerialNumber', $randomString)->exists();
        if ($exists) {
            return $this->generateRandomString($length);
        }

        return $randomString;
    }
}
