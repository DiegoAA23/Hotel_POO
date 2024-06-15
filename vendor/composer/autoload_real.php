<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit97a322713879b3bbcb801d0717c6b1eb
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit97a322713879b3bbcb801d0717c6b1eb', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit97a322713879b3bbcb801d0717c6b1eb', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit97a322713879b3bbcb801d0717c6b1eb::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
