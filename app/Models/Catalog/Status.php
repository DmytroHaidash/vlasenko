<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = [
        'title'
    ];

    public function accountings(): HasMany
    {
        return $this->hasMany(Accounting::class);
    }
}
