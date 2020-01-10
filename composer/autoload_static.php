<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite1633004235c41501d75f032a94c9247
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite1633004235c41501d75f032a94c9247::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite1633004235c41501d75f032a94c9247::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInite1633004235c41501d75f032a94c9247::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
