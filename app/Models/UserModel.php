<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'm_user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['level_id', 'username', 'nama', 'password', 'created_at', 'updated_at'];
    protected $hidden = ['password'];
    protected $casts = ['password' => 'hashed'];
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
        
    }
    // public function getRole()
    // {
    //     return $this->level->level_kode;
    // }

    // // Nama tabel
    // protected $table = 'm_user'; 
    
    // // Kolom primary key
    // protected $primaryKey = 'user_id'; 
    
    // // Jika kunci utama tidak auto-incrementing, tambahkan:
    // public $incrementing = false;
    
    // // Format primary key (jika bukan integer, misalnya string)
    // protected $keyType = 'string'; // Ganti sesuai tipe data user_id (misalnya integer)
    
    // // Aktifkan timestamps jika menggunakan created_at dan updated_at
    // public $timestamps = true;
    // //Jobsheet 4-Prartikum 1
    // protected $fillable = ['level_id', 'username', 'nama', 'password'];
    //     public function level(): BelongsTo


   
}