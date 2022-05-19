<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EnterpriseUser extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'enterprise_id',
    ];
}
