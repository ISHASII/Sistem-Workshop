<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    protected $table = 'manpowers';

    protected $fillable = [
        'nrp',
        'nama',
        'jenis_kelamin',
        'status_pegawai',
    ];
}
