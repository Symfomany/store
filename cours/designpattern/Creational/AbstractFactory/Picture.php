<?php

namespace DesignPatterns\Creational\AbstractFactory;

    /**
     * @var string
     */
abstract class Picture implements MediaInterface
{
    protected $path;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $path
     * @param string $name
     */
    public function __construct($path, $name = '')
    {
        $this->name = (string) $name;
        $this->path = (string) $path;
    }
}
