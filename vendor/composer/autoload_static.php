<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8a130ad44f9a7b94a0afa15935346609
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8a130ad44f9a7b94a0afa15935346609::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8a130ad44f9a7b94a0afa15935346609::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8a130ad44f9a7b94a0afa15935346609::$classMap;

        }, null, ClassLoader::class);
    }
}
