<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;
    protected $table = 'motor';
    protected $fillable = ['nama', 'plat_nomer', 'gambar', 'harga', 'deskripsi'];
}
