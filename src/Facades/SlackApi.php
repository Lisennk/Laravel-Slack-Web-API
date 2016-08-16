<?php

namespace Lisennk\Laravel\SlackWebApi\Facades;

use Illuminate\Support\Facades\Facade;
use Lisennk\Laravel\SlackWebApi\SlackApi as Api;

class SlackApi extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return Api::class;
    }
}