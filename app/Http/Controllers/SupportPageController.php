<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;
use App\Models\SupportPage;

class SupportPageController extends Controller
{
    public function View(Request $request)
    {
        $field = ['KodeInformasi', 'Judul', 'Kategori'];
        $keyword = $request->input('keyword');

        $pages = SupportPage::where(function ($query) use ($keyword, $field) {
            foreach ($field as $f) {
                $query->orWhere($f, 'like', '%' . $keyword . '%');
            }
        })
        ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
        ->get();

        $title = 'Delete Informasi';
        $text = "Apakah Anda yakin ingin menghapus data ini?";
        confirmDelete($title, $text);

        return view("Admin.InformationPage", ['listinformasi' => $pages]);
    }

    public function ViewUser(Request $request)
    {
        $field = ['KodeInformasi', 'Judul', 'Kategori'];
        $keyword = $request->input('keyword');

        $pages = SupportPage::where(function ($query) use ($keyword, $field) {
            foreach ($field as $f) {
                $query->orWhere($f, 'like', '%' . $keyword . '%');
            }
        })
        ->where('Kategori', 'faq')
        ->get();

        $pagestutorial = SupportPage::where(function ($query) use ($keyword, $field) {
            foreach ($field as $f) {
                $query->orWhere($f, 'like', '%' . $keyword . '%');
            }
        })
        ->where('Kategori', 'tutorial')
        ->get();

        return view("Admin.informationUserPage", ['faq' => $pages, 'tutorial' => $pagestutorial]);
    }

    public function ViewUserDetail($id = null)
    {
        $page = SupportPage::where('id', $id)->first();
        return view("Admin.informationUserPageDetail", ['data' => $page]);
    }

    public function ViewJson(Request $request)
    {
        $data = ['success' => false, 'data' => []];
        $pages = SupportPage::where('RecordOwnerID', Auth::user()->RecordOwnerID)->get();
        $data['success'] = true;
        $data['data'] = $pages;
        return response()->json($data);
    }

    public function Form($KodeInformasi = null)
    {
        $page = SupportPage::where('id', $KodeInformasi)->get();
        return view("Admin.InformationPage-Input", ['data' => $page]);
    }

    public function store(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'Judul' => 'required',
                'Kategori' => 'required',
                'Konten' => 'required'
            ]);

            $model = new SupportPage;
            $model->KodeInformasi = "";
            $model->Judul = $request->input('Judul');
            $model->Kategori = $request->input('Kategori');
            $model->Konten = $request->input('Konten');
            $model->ThumbnailBase64 = "";
            $model->IsPublished = $request->boolean('IsPublished');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            if ($model->save()) {
                alert()->success('Success', 'Informasi berhasil disimpan.');
                return redirect('faq');
            } else {
                throw new \Exception('Gagal menyimpan informasi');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit(Request $request)
    {
        Log::debug($request->all());
        try {
            $this->validate($request, [
                'Judul' => 'required',
                'Kategori' => 'required',
                'Konten' => 'required'
            ]);

            $update = DB::table('informasi_pages')
                ->where('id', $request->input('id'))
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'Judul' => $request->input('Judul'),
                    'Kategori' => $request->input('Kategori'),
                    'Konten' => $request->input('Konten'),
                    'ThumbnailBase64' => $request->input('ThumbnailBase64'),
                    'IsPublished' => $request->boolean('IsPublished')
                ]);

            if ($update) {
                alert()->success('Success', 'Data berhasil diperbarui.');
                return redirect('faq');
            } else {
                throw new \Exception('Gagal memperbarui data.');
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function storeJson(Request $request)
    {
        Log::debug($request->all());
        $data = ['success' => false];
        try {
            $model = new SupportPage;
            $model->KodeInformasi = $request->input('KodeInformasi');
            $model->Judul = $request->input('Judul');
            $model->Kategori = $request->input('Kategori');
            $model->Konten = $request->input('Konten');
            $model->ThumbnailBase64 = $request->input('ThumbnailBase64');
            $model->IsPublished = $request->boolean('IsPublished');
            $model->RecordOwnerID = Auth::user()->RecordOwnerID;

            if ($model->save()) {
                $data['success'] = true;
            } else {
                $data['message'] = 'Gagal menyimpan data';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function editJson(Request $request)
    {
        Log::debug($request->all());
        $data = ['success' => false];
        try {
            $update = DB::table('informasi_pages')
                ->where('KodeInformasi', $request->input('KodeInformasi'))
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->update([
                    'Judul' => $request->input('Judul'),
                    'Kategori' => $request->input('Kategori'),
                    'Konten' => $request->input('Konten'),
                    'ThumbnailBase64' => $request->input('ThumbnailBase64'),
                    'IsPublished' => $request->boolean('IsPublished')
                ]);

            if ($update) {
                $data['success'] = true;
            } else {
                $data['message'] = 'Gagal memperbarui data';
            }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            $data['message'] = $e->getMessage();
        }
        return response()->json($data);
    }

    public function deletedata(Request $request)
    {
        try {
            $deleted = DB::table('informasi_pages')
                ->where('KodeInformasi', $request->id)
                ->where('RecordOwnerID', Auth::user()->RecordOwnerID)
                ->delete();

            if ($deleted) {
                alert()->success('Success', 'Data berhasil dihapus.');
            } else {
                alert()->error('Error', 'Gagal menghapus data.');
            }
            return redirect('informasi-page');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            alert()->error('Error', $e->getMessage());
        }
    }
}
