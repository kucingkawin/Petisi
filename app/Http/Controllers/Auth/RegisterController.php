<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'alamat' => ['required', 'string', 'min:10'],
            'kode_pos' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'required' => 'Teks dibutuhkan.',
            'string' => 'Harus berupa teks.',
            'max' => 'Maksimal :max huruf.',
            'min' => 'Minimal :min huruf.',
            'unique:users' => 'Email sudah dipakai untuk mendaftar.'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        
        //Mengantisipasi kemungkinan adanya error pada create.
        try
        {
            //Buat user.
            $user = User::create([
                'role_id' => 1,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);
    
            //Buat user detail dengan menggunakan id dari user yang dibuat sebelumnya.
            UserDetail::create([
                'user_id' => $user->id,
                'alamat' => $data['alamat'],
                'kode_pos' => $data['kode_pos']
            ]);

            //Register user sukses, segera commit database.
            DB::commit();

            return $user;
        }
        catch(Exception $e)
        {
            //Jika terjadi error, maka segera batalkan perubahan database
            DB::rollback();

            //Munculkan error.
            throw $e;
        }
    }

    public function redirectTo()
    {
        return route('user.index');
    }
}
