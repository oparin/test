<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdd01b62946cb7c6670924bfe3cfeca31
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Controller\\TaskController' => __DIR__ . '/../..' . '/app/controller/TaskController.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdd01b62946cb7c6670924bfe3cfeca31::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdd01b62946cb7c6670924bfe3cfeca31::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdd01b62946cb7c6670924bfe3cfeca31::$classMap;

        }, null, ClassLoader::class);
    }
}
