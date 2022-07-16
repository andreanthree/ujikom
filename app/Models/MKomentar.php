<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MKomentar extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tb_komentar";
    protected $primary_key = "id";
    protected $guarded = [''];

    public function artikelkomentar()
    {
        return $this->belongsTo(MArtikelKomentar::class, 'id_komentar', 'id');
    }

}
