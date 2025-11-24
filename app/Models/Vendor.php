<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function members() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'vendor_users')
            ->using(VendorUser::class);

    }
}
