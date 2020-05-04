<?php

namespace Oddvalue\DbRouter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Oddvalue\DbRouter\Exceptions\NoRedirectUrlException;

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

    public function parseUrl(string $url)
    {
        return str_replace(url(''), '', $url);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function routable()
    {
        return $this->morphTo();
    }

    public function canonical()
    {
        return $this->belongsTo(self::class);
    }

    public function redirect()
    {
        return $this->belongsTo(self::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeWhereIsCanonical($query)
    {
        $query->whereNull('canonical_id');
    }

    public function scopeIsRedirect($query)
    {
        $query->where(function ($query) {
            $query->onlyTrashed();
            $query->orWhereNotNull('redirect_id');
        })->withTrashed();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setUrlAttribute(string $value)
    {
        $this->attributes['url'] = $this->parseUrl($value);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getRedirectUrlAttribute()
    {
        if ($this->routable && $this->trashed() && $this->routable->canonicalRoute) {
            return $this->routable->canonicalRoute->url;
        }

        if ($this->redirect) {
            return $this->redirect->url;
        }

        throw NoRedirectUrlException::forRoute($this);
    }
}
