<?php

namespace Store\BackendBundle\Doctrine\Extensions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

/**
 * Class DateFormat.
 */
class DateFormat extends FunctionNode
{
    /**
     * @var
     */
    protected $dateExpression;

    /**
     * @var
     */
    protected $formatChar;

    /**
     * get SQL Format.
     *
     * @param SqlWalker $sqlWalker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT('.
        $sqlWalker->walkArithmeticExpression($this->dateExpression).
        ','.
        $sqlWalker->walkStringPrimary($this->formatChar).
        ')';
    }
    /**
     * Parsing date.
     *
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->match(Lexer::T_COMMA);

        $this->formatChar = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
