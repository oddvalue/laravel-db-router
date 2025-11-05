<?php

namespace Oddvalue\DbRouter\Test\Links;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Oddvalue\LinkBuilder\Contracts\LinkGenerator;

class ExampleLink implements LinkGenerator
{
    /**
     * Instantiate the generator with the linkable model
     */
    public function __construct(protected Linkable $model, protected array $options = [])
    {
    }

    /**
     * Get the link href for a given model
     */
    public function href() : string
    {
        return '/'.trim(collect($this->model->slug)->when(array_key_exists('prefix', $this->options), fn($href) => $href->prepend($this->options['prefix']))->when($this->model->parent, fn($href) => $href->prepend($this->model->parent->getLinkGenerator()->href()))->implode('/'), '/');
    }

    /**
     * Get the link text for a given model
     */
    public function label() : string
    {
        return (string) ($this->model->name ?? last((array) $this->model->slug) ?? '');
    }

    /**
     * Generate an HTML link for the model
     *
     * @return string
     */
    public function toHtml()
    {
        $href = $this->href();
        $label = $this->label();
        return '<a href="' . e($href) . '">' . e($label) . '</a>';
    }

    /**
     * Cast the generator to a string
     */
    public function __toString() : string
    {
        return $this->href();
    }
}
