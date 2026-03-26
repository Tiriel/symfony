<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\ExpressionParser\Infix;

use Symfony\Component\Twig\ExpressionParser\AbstractExpressionParser;
use Symfony\Component\Twig\ExpressionParser\ExpressionParserDescriptionInterface;
use Symfony\Component\Twig\ExpressionParser\InfixAssociativity;
use Symfony\Component\Twig\ExpressionParser\InfixExpressionParserInterface;
use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Node\Expression\ArrowFunctionExpression;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Token;

/**
 * @internal
 */
final class ArrowExpressionParser extends AbstractExpressionParser implements InfixExpressionParserInterface, ExpressionParserDescriptionInterface
{
    public function parse(Parser $parser, AbstractExpression $expr, Token $token): AbstractExpression
    {
        // As the expression of the arrow function is independent from the current precedence, we want a precedence of 0
        return new ArrowFunctionExpression($parser->parseExpression(), $expr, $token->getLine());
    }

    public function getName(): string
    {
        return '=>';
    }

    public function getDescription(): string
    {
        return 'Arrow function (x => expr)';
    }

    public function getPrecedence(): int
    {
        return 250;
    }

    public function getAssociativity(): InfixAssociativity
    {
        return InfixAssociativity::Left;
    }
}
