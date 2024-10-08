<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class KategoriModel extends Model
{
    protected $table = 'm_kategoris';
    protected $primaryKey ='kategori_id';
    protected $fillable = ['kategori_id','kategori_kode','kategori_nama',''];
    public function barang(): BelongsTo{
        return $this->belongsTo(barangmodel::class);
    }
}