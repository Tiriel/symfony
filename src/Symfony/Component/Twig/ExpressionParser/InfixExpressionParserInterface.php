<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\ExpressionParser;

use Symfony\Component\Twig\Error\SyntaxError;
use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Token;

interface InfixExpressionParserInterface extends ExpressionParserInterface
{
    /**
     * @throws SyntaxError
     */
    public function parse(Parser $parser, AbstractExpression $left, Token $token): AbstractExpression;

    public function getAssociativity(): InfixAssociativity;
}
