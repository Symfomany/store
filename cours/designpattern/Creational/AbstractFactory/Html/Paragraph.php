<?php

namespace DesignPatterns\Creational\AbstractFactory\Html;

use DesignPatterns\Creational\AbstractFactory\Text as BaseText;

/**
 * Class Paragraph
 *
 * Text is a concrete text for HTML rendering
 */
class Paragraph extends BaseText
{
    /**
     * some crude rendering from HTML output
     *
     * @return string
     */
    public function render()
    {
        return '<p>' . htmlspecialchars($this->text) . '</p>';
    }
}
