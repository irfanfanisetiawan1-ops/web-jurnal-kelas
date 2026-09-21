<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaDispenDibaca extends Model
{
    protected $table = 'siswa_dispen_dibaca';
    protected $fillable = ['user_id', 'id_siswa_dispen'];
}
