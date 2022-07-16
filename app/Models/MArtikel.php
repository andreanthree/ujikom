<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MArtikel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tb_artikel";
    protected $primary_key = "id";
    protected $guarded = [''];

    public function penulis()
    {
        return $this->belongsTo(MWriter::class, 'id_penulis', 'id_penulis');
    }
    public function listkomentar()
    {
        return $this->hasMany(MArtikelKomentar::class, 'id_artikel', 'id');
    }

}
