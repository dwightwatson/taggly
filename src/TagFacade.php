<?php namespace Watson\Taggly;

use Illuminate\Support\Facades\Facade;

class TagFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'tag'; }
}