<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invitation extends Model
{
    protected $fillable = [
        'name',
        'email',
        'role',
        'company_id',
        'invited_by',
        'token',
        'accepted_at',
    ];


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}