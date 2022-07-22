<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Analysis extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'enterprise_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The analyses that belong to enterprise
     */
    public function enterprise()
    {
        return $this->belongsTo('App\Models\Enterprise');
    }

    /**
     * The sectors answers that belong to analysis
     */
    public function sectorsAnswers()
    {
        return $this->hasMany('App\Models\SectorAnswer');
    }

    /**
     * The enterprise answers that belong to analysis
     */
    public function enterpriseAnswers()
    {
        return $this->hasOne('App\Models\EnterpriseAnswer');
    }
}
