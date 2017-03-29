<?php

namespace App\Http\Controllers\Api;

/**
 * 辅助 Api
 *
 * @package App\Http\Controllers\Api
 *
 * @author  fengqi <lyf362345@gmail.com>
 * @copyright Copyright (c) 2015 udpower.cn all rights reserved.
 */
class HelperController extends ApiController
{
    public function getIndex()
    {
        return __CLASS__.__FUNCTION__;
    }
}
