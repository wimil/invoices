<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita331dcd69f5cf9ba65338867990e8dea
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Wimil\\Invoices\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Wimil\\Invoices\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita331dcd69f5cf9ba65338867990e8dea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita331dcd69f5cf9ba65338867990e8dea::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
