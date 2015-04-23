<?php

namespace Store\BackendBundle\Doctrine\Extensions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

/**
 * class YEAR représente la fonction YEAR()
 */
class Year extends FunctionNode
{
    protected $dateExpression;

    // IL parse la fonction SQL en DQL
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->dateExpression = $parser->ArithmeticExpression(); // (4)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    // Retourne le DQL en SQL
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'YEAR(' .
        $sqlWalker->walkArithmeticExpression($this->dateExpression).
        ')';
    }


}

