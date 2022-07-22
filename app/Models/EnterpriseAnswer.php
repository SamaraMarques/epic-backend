<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnterpriseAnswer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'analysis_id',
        'enterprise_id',
        'answers',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The analysis that this enterprise answer belongs to
     */
    public function analysis()
    {
        return $this->belongsTo('App\Models\Analysis');
    }

    /**
     * The enterprise that this enterprise answer belongs to
     */
    public function enterprise()
    {
        return $this->belongsTo('App\Models\Enterprise');
    }
}
