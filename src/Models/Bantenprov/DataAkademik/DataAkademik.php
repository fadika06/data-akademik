<?php

namespace Bantenprov\DataAkademik\Models\Bantenprov\DataAkademik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataAkademik extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'data_akademiks';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'user_id',
        'nomor_un',
        'nomor_kk',
        'nama_siswa',
        'bahasa_indonesia',
        'bahasa_inggris',
        'matematika',
        'ipa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

        public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

}
