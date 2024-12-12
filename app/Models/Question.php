<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'soal_id';

    protected $fillable = [
        'soal_persidangan',
        'soal_kategori',
        'soal_soalan',
        'soal_jawapan',
        'soal_adun',
        'soal_soalan_no'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'soal_adun', 'id');
    }
}
