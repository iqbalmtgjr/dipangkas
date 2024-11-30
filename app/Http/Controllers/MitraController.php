<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Mitra::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('logo', function ($data) {
                    if ($data->gambar) {
                        return '<img src="' . asset('/mitra/logo/' . $data->gambar) . '" width="100" height="100">';
                    } else {
                        return 'No Image';
                    }
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<span class="badge badge-success">Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->rawColumns(['logo', 'status'])
                ->make(true);
        }
        return view('mitra.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mitra' => 'required',
            'alamat_mitra' => 'required',
            'logo_mitra' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $filename = null;
        if ($request->hasFile('logo_mitra')) {
            $file = $request->file('logo_mitra');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('../../public_html/mitra/logo/'), $filename);
        }

        Mitra::create([
            'nama' => $request->nama_mitra,
            'alamat' => $request->alamat_mitra,
            'gambar' => $filename,
        ]);

        toastr()->success('Berhasil menambah mitra.');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_mitra' => 'required',
            'alamat_mitra' => 'required',
            'logo_mitra' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $filename = null;
        if ($request->hasFile('logo_mitra')) {
            $data = Mitra::find($request->id);
            if ($data->logo_mitra != null) {
                @unlink(public_path('../../public_html/mitra/logo/' . $data->logo_mitra));
            }
            $file = $request->file('logo_mitra');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('../../public_html/mitra/logo/'), $filename);
        }

        $data = Mitra::find($request->id);
        $data->update([
            'nama' => $request->nama_mitra,
            'alamat' => $request->alamat_mitra,
            'gambar' => $filename,
        ]);

        toastr()->success('Berhasil edit mitra.');
        return redirect()->back();
    }

    public function validasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'validasi' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = Mitra::find($request->id);
        $data->update([
            'status' => $request->validasi,
        ]);

        toastr()->success('Berhasil validasi mitra.');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        if ($mitra->logo_mitra != null) {
            @unlink(public_path('../../public_html/mitra/logo/' . $mitra->logo_mitra));
        }
        $mitra->delete();

        toastr()->success('Mitra berhasil dihapus.');
        return redirect()->back();
    }

    public function getdata($id)
    {
        $data = Mitra::find($id);
        return $data;
    }
}
