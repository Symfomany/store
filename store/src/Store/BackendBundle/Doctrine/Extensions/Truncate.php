<?php

namespace Store\BackendBundle\Doctrine\Extensions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

/**
 *
 */
class Truncate extends FunctionNode
{
    protected $nb;
    protected $format;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->nb = $parser->ArithmeticExpression(); // (4)
        $parser->match(Lexer::T_COMMA); // (3)
        $this->format = $parser->ArithmeticExpression(); // (4)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'TRUNCATE('.
            $sqlWalker->walkArithmeticExpression($this->nb).
            ','.
            $sqlWalker->walkArithmeticExpression($this->format).
        ')';
    }
}
