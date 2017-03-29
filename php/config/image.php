<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Image 使用的驱动
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | 支持: gd, imagick, imagick 会保留 exif 信息(需要清除掉), gd 不会.
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'imagick'

);
