<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

      $user = UserModel::firstOrCreate(
        [
          'username' => 'manager33',
          'nama' => 'Manager Tiga Tiga',
          'password' => Hash::make('12345'),
          'level_id' => 2
         ],
      );
      $user->save();
      return view('user', ['data' => $user]);

      // $user = UserModel::where('level_id', 2)->count();
      // return view('user', ['data' => $user]);

      // $user = UserModel::where('level_id', 2)->count();
      // dd($user);
      // return view('user', ['data' => $user]);

      // tambah data user dengan Eloquent Model
      
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama'  => 'Manager 3',
        //     'password' => Hash::make('12345'),
            
        //  ];
        // UserModel::create($data); //tambahkan data ke tabel m_user


        //  //coba akses model UserModel
        //  $user = UserModel::all(); //Ambil semua data dari tabel m_user
        //  return view('user', ['data' => $user]);



        // $data = [
        //     'nama'  => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); //update data user
       
    }
}