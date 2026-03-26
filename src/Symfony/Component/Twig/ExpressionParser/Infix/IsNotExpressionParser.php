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

use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Node\Expression\Unary\NotUnary;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Token;

/**
 * @internal
 */
final class IsNotExpressionParser extends IsExpressionParser
{
    public function parse(Parser $parser, AbstractExpression $expr, Token $token): AbstractExpression
    {
        return new NotUnary(parent::parse($parser, $expr, $token), $token->getLine());
    }

    public function getName(): string
    {
        return 'is not';
    }
}
