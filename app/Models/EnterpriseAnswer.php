<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterpriseAnswer extends Model
{
    use HasFactory;

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
