<?php

namespace DesignPatterns\Creational\AbstractFactory;

/**
 * Class Text base
 */
abstract class Text implements MediaInterface
{
    /**
     * @var string
     */
    protected $text;

    /**
     * @param string $text
     */
    public function __construct($text)
    {
        $this->text = (string) $text;
    }
}
