<?php

namespace Oddvalue\DbRouter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Oddvalue\DbRouter\Exceptions\NoRedirectUrlException;

/**
 * @property int $id
 * @property string $url
 * @property int|null $canonical_id
 * @property int|null $redirect_id
 * @property string|null $routable_type
 * @property int|null $routable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Route|null $canonical
 * @property-read Route|null $redirect
 * @property-read \Oddvalue\DbRouter\Contracts\Routable|null $routable
 * @property-read string $redirect_url
 */
class Route extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'url',
        'canonical_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function shouldRedirect() : bool
    {
        return $this->redirect || ($this->trashed() && $this->routable);
    }

    public function isCanonical() : bool
    {
        return $this->canonical_id !== null;
    }

    public function parseUrl(string $url): string
    {
        return str_replace(url(''), '', $url);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function routable(): MorphTo
    {
        return $this->morphTo();
    }

    public function canonical(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    public function redirect(): BelongsTo
    {
        return $this->belongsTo(self::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /** @param \Illuminate\Database\Eloquent\Builder<Route> $query */
    public function scopeWhereIsCanonical($query): void
    {
        $query->whereNull('canonical_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder<Route> $query
     * @return \Illuminate\Database\Eloquent\Builder<Route>
     */
    public function scopeIsRedirect($query)
    {
        return $query->where(function ($query) {
            /** @var \Illuminate\Database\Eloquent\Builder<Route> $query */
            $query->onlyTrashed();
            $query->orWhereNotNull('redirect_id');
        })->withTrashed();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setUrlAttribute(string $value): void
    {
        $this->attributes['url'] = $this->parseUrl($value);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getRedirectUrlAttribute(): string
    {
        if ($this->routable && $this->trashed()) {
            /** @var Route|null $canonicalRoute */
            $canonicalRoute = $this->routable->canonicalRoute()->first();
            if ($canonicalRoute) {
                return $canonicalRoute->url;
            }
        }

        if ($this->redirect) {
            return $this->redirect->url;
        }

        throw NoRedirectUrlException::forRoute($this);
    }
}
