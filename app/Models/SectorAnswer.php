<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectorAnswer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'analysis_id',
        'sector_id',
        'gin',
        'gci',
        'answers',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * The analysis that this sector answer belongs to
     */
    public function analysis()
    {
        return $this->belongsTo('App\Models\Analysis');
    }

    /**
     * The sector that this sector answer belongs to
     */
    public function sector()
    {
        return $this->belongsTo('App\Models\Sector');
    }
}
