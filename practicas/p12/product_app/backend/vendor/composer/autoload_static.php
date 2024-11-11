<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit96a83ea7d41e597381ff476991e53dd1
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TECWEB\\MYAPI\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TECWEB\\MYAPI\\' => 
        array (
            0 => __DIR__ . '/../..' . '/myapi',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit96a83ea7d41e597381ff476991e53dd1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit96a83ea7d41e597381ff476991e53dd1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit96a83ea7d41e597381ff476991e53dd1::$classMap;

        }, null, ClassLoader::class);
    }
}
