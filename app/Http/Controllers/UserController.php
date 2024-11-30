<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = User::where('mitra_id', auth()->user()->mitra_id)->where('id', '!=', 1)->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('role', function ($data) {
                    if ($data->role == 'admin_mitra') {
                        return 'Owner';
                    } else {
                        return 'Capster';
                    }
                })
                ->make(true);
        }

        return view('user.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'no_hp' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::updateOrCreate([
            'mitra_id' => auth()->user()->mitra_id,
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
        ]);

        toastr()->success('Berhasil menambah data user.');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->error('Ada Kesalahan Saat Penginputan.');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::find($request->id)->update([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        toastr()->success('Berhasil edit data user.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();

        toastr()->success('Berhasil hapus data user.');
        return redirect()->back();
    }

    public function getdata($id)
    {
        $data = User::find($id);
        return $data;
    }
}
