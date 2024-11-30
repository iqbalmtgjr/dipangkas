<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Mitra;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nama_mitra' => ['required', 'string', 'max:255'],
            'logo_mitra' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'alamat_mitra' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:13'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        $filename = null;
        if (isset($data['logo_mitra'])) {
            $logo = $data['logo_mitra'];
            $filename = Str::random(10) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('mitra/logo/'), $filename);
        }
        $mitra = Mitra::create([
            'nama' => $data['nama_mitra'],
            'alamat' => $data['alamat_mitra'],
            'gambar' => $filename,
        ]);

        $user = User::create([
            'mitra_id' => $mitra->id,
            'role' => 'admin_mitra',
            'name' => $data['nama_lengkap'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'password' => Hash::make($data['password']),
        ]);

        toastr()->success('Akun berhasil didaftar.');
        return $user;
    }
}
