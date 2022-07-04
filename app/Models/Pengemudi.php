<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Pengemudi extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengemudi';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    // protected $primaryKey = 'flight_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    // public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    // protected $keyType = 'string';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    // protected $attributes = [
    //     'delayed' => false,
    // ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 
        'alamat', 
        'tanggal_lahir', 
        'jenis_kelamin', 
        'nomor_telepon', 
        'foto', 
        'bahasa', 
        'sim', 
        'surat_bebas_napza', 
        'surat_kesehatan_jiwa', 
        'surat_kesehatan_jasmani', 
        'skck', 
        'tersedia', 
        'email', 
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    // protected $casts = [
    //     'is_admin' => 'boolean',
    // ];

    /**
     * Get the pengemudi's bahasa.
     *
     * @param  string  $value
     * @return array
     */
    public function getBahasaAttribute($value)
    {
        if ($value === null) {
            return [];
        }

        return explode(',', $value);
    }
}
