<?php

namespace UrlLogin\Models;

use UrlLogin\Traits\HasPublicId;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @property int $id
 * @property string $public_id
 * @property string $token
 * @property string $ip
 * @property string $user_agent
 * @property DateTime|Carbon|null $expires_at
 * @property DateTime|Carbon|null $consumed_at
 * @property Authenticatable tokenable
 * @method Builder withConsumed()
 */
class UrlLoginToken extends Model
{
    use HasPublicId;

    protected $dates = [
        'expires_at',
        'consumed_at',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('unconsumed', function (Builder $builder) {
            $builder->whereNull('consumed_at');
        });
    }

    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeWithConsumed(Builder $query): Builder
    {
        return $query->withoutGlobalScope('unconsumed');
    }

    /**
     * @throws ModelNotFoundException
     */
    protected static function retrieve(string $publicId, string $token): self
    {
        return self::where('public_id', $publicId)
            ->where('token', Hash::make($token))
            ->where(function (Builder $query) {
                $query->whereNull('expires_at')
                    ->orWhereDate('expires_at', '<', now());
            })
            ->firstOrFail();
    }

    public function consume(Request $request): bool
    {
        $this->ip = $request->ip();
        $this->user_agent = $request->userAgent();
        $this->consumed_at = now();

        return $this->save();
    }
}
