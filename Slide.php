<?php namespace VnsModules\Slide;

class Slide extends \Models\Term {

    protected $fillable = ['name', 'slug', 'image', 'description', 'order', 'status'];
}
