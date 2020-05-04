<?php

namespace Oddvalue\DbRouter\Test\Links;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Contracts\LinkGenerator;

class ExampleLink implements LinkGenerator
{
    protected $model;
    protected $options;

        /**
     * Instantiate the generator with the linkable model
     *
     * @param Linkable $model
     * @param array $options
     */
    public function __construct(Linkable $model, array $options = [])
    {
        $this->model = $model;
        $this->options = $options;
    }

    /**
     * Get the link href for a given model
     *
     * @return string
     */
    public function href() : string
    {
        return '/'.trim(collect($this->model->slug)->when(key_exists('prefix', $this->options), function ($href) {
            return $href->prepend($this->options['prefix']);
        })->when($this->model->parent, function ($href) {
            return $href->prepend($this->model->parent->getLinkGenerator()->href());
        })->implode('/'), '/');
    }

    /**
     * Get the link text for a given model
     *
     * @return string
     */
    public function label() : string {}

    /**
     * Generate an HTML link for the model
     *
     * @return string
     */
    public function toHtml() {}

    /**
     * Cast the generator to a string
     *
     * @return string
     */
    public function __toString() : string {}
}
