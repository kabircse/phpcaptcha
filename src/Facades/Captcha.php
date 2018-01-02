<?php

namespace Kabir\Captcha\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kabir\Captcha
 */
class Captcha extends Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
    protected static function getFacadeAccessor()
    {
        return 'captcha';
    }
}
