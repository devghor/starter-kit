<?php

namespace App\Models\Settings;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $table = 'companies';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'short_name',
        'code',
        'address',
        'plan',
    ];

    protected static function booted(): void
    {
        static::creating(function (Company $company) {
            $company->id ??= (string) Str::uuid();
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id', 'user_id');
    }
}
