<?php

class Autoloader
{
    private string $prefix;
    private string $dir;

    /**
     * Autoload constructor.
     * @param string $prefix
     * @param string $dir
     */
    public function __construct($prefix, $dir)
    {
        $this->setDir($dir);
        $this->setPrefix($prefix);
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @param string $dir
     */
    public function setDir(string $dir): void
    {
        $this->dir = $dir;
    }

    public function register()
    {
        spl_autoload_register(function ($class){
            $class = str_replace($this->getPrefix(), $this->getDir(), $class);
            $path = (str_replace('\\','/', $class) . '.php');
            require_once $path;
        });
    }
}
$a = new Autoloader('App', 'src');
$a->register();