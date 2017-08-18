<?php

namespace Brick\Geo\Doctrine\Functions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Base class for Doctrine functions.
 */
abstract class AbstractFunction extends FunctionNode
{
    /**
     * @var \Doctrine\ORM\Query\AST\Node[]
     */
    private $args = [];

    /**
     * @return string
     */
    abstract protected function getSqlFunctionName();

    /**
     * @return integer
     */
    abstract protected function getParameterCount();

    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        $sql = $this->getSqlFunctionName() . '(';

        foreach ($this->args as $key => $arg) {
            if ($key !== 0) {
                $sql .= ', ';
            }

            $sql .= $arg->dispatch($sqlWalker);
        }

        $sql .= ')';

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(Parser $parser)
    {
        $this->args = [];

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $parameterCount = $this->getParameterCount();

        for ($i = 0; $i < $parameterCount; $i++) {
            if ($i !== 0) {
                $parser->match(Lexer::T_COMMA);
            }

            $this->args[] = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
