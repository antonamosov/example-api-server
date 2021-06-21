<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class);
    }

    public function client(): HasOne
    {
        return $this->hasOne(Client::class);
    }
}
