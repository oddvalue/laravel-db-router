<?php

namespace Oddvalue\DbRouter\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Oddvalue\DbRouter\Traits\HasRoutes;
use Oddvalue\DbRouter\Contracts\Routeable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Oddvalue\DbRouter\Test\Links\ExampleLink;
use Oddvalue\LinkBuilder\Traits\LinkableTrait;
use Oddvalue\DbRouter\Test\Routes\ExampleRouteGenerator;

class Example extends Model implements Routeable
{
    use HasRoutes;
    use LinkableTrait;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Generate an additional, non-canonical route with this prefix
     *
     * @var string
     */
    protected $non_canonical_route_prefix;

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function getRouteGeneratorClass()
    {
        return ExampleRouteGenerator::class;
    }

    public function isRouteable()
    {
        return ! $this->trashed();
    }

    /**
     * Get the fully qualified class name of the model's link generator
     *
     * @return string
     */
    protected function getLinkGeneratorClass()
    {
        return ExampleLink::class;
    }

    public function setNonCanonicalRoutePrefix($value)
    {
        $this->non_canonical_route_prefix = $value;
        return $this;
    }

    public function getNonCanonicalRoutePrefix()
    {
        return $this->non_canonical_route_prefix;
    }
}
