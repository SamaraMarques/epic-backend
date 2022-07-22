<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enterprise extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The enterprises that belong to user
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /**
     * The sectors that belong to enterprise
     */
    public function sectors()
    {
        return $this->hasMany('App\Models\Sector');
    }

    /**
     * The analyses that belong to enterprise
     */
    public function analyses()
    {
        return $this->hasMany('App\Models\Analysis');
    }

    /**
     * The enterprise answers that belong to enterprise
     */
    public function enterpriseAnswers()
    {
        return $this->hasMany('App\Models\EnterpriseAnswer');
    }
}
