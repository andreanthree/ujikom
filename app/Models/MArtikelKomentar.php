<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MArtikelKomentar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tb_detail";
    protected $primary_key = "id";
    protected $guarded = [''];

    public function artikel()
    {
        return $this->belongsTo(MArtikel::class, 'id_artikel', 'id');
    }
    public function komentar()
    {
        return $this->hasOne(MKomentar::class, 'id', 'id_komentar');
    }

}
