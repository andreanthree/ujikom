<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MWriter extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "tb_penulis";
    protected $primary_key = "id_penulis";
    protected $guarded = [''];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function artikel()
    {
        return $this->hasMany(MArtikel::class, 'id_penulis', 'id_penulis');
    }

}
