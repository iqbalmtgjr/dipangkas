<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Kategori::where('mitra_id', auth()->user()->mitra_id)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('harga', function ($data) {
                    return 'Rp. ' . number_format($data->harga, 0, ',', '.');
                })
                ->make(true);
        }
        return view('kategori.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'harga' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        Kategori::create([
            'mitra_id' => auth()->user()->mitra_id,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
        ]);

        toastr()->success('Berhasil menambah kategori.');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = Kategori::find($request->id);
        $data->update([
            'kategori' => $request->kategori,
            'harga' => $request->harga,
        ]);

        toastr()->success('Berhasil edit kategori.');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        toastr()->success('Kategori berhasil dihapus.');
        return redirect()->back();
    }

    public function getdata($id)
    {
        $data = Kategori::find($id);
        return $data;
    }
}
