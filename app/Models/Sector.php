<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'enterprise_id',
        'name',
    ];

    /**
     * The enterprise that has the sectors
     */
    public function enterprise()
    {
        return $this->belongsTo('App\Models\Enterprise');
    }

    /**
     * The sectors answers that belong to sector
     */
    public function sectorsAnswers()
    {
        return $this->hasMany('App\Models\SectorAnswer');
    }
}
