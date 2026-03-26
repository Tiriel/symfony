<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\ExpressionParser\Prefix;

use Symfony\Component\Twig\Error\SyntaxError;
use Symfony\Component\Twig\ExpressionParser\AbstractExpressionParser;
use Symfony\Component\Twig\ExpressionParser\ExpressionParserDescriptionInterface;
use Symfony\Component\Twig\ExpressionParser\PrefixExpressionParserInterface;
use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Node\Expression\ListExpression;
use Symfony\Component\Twig\Node\Expression\Variable\AssignContextVariable;
use Symfony\Component\Twig\Node\Expression\Variable\ContextVariable;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Token;

/**
 * @internal
 */
final class GroupingExpressionParser extends AbstractExpressionParser implements PrefixExpressionParserInterface, ExpressionParserDescriptionInterface
{
    public function parse(Parser $parser, Token $token): AbstractExpression
    {
        $stream = $parser->getStream();
        $expr = $parser->parseExpression($this->getPrecedence());

        if ($stream->nextIf(Token::PUNCTUATION_TYPE, ')')) {
            if (!$stream->test(Token::OPERATOR_TYPE, '=>')) {
                return $expr->setExplicitParentheses();
            }

            return new ListExpression([self::toAssignContextVariable($expr)], $token->getLine());
        }

        // determine if we are parsing an arrow function arguments
        if (!$stream->test(Token::PUNCTUATION_TYPE, ',')) {
            $stream->expect(Token::PUNCTUATION_TYPE, ')', 'An opened parenthesis is not properly closed');
        }

        $names = [$expr];
        while (true) {
            if ($stream->nextIf(Token::PUNCTUATION_TYPE, ')')) {
                break;
            }
            $stream->expect(Token::PUNCTUATION_TYPE, ',');
            $token = $stream->expect(Token::NAME_TYPE);
            $names[] = new ContextVariable($token->getValue(), $token->getLine());
        }

        if (!$stream->test(Token::OPERATOR_TYPE, '=>')) {
            throw new SyntaxError('A list of variables must be followed by an arrow.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }

        return new ListExpression(array_map(self::toAssignContextVariable(...), $names), $token->getLine());
    }

    private static function toAssignContextVariable(AbstractExpression $expr): AssignContextVariable
    {
        if (!$expr instanceof ContextVariable) {
            throw new SyntaxError('A list must only contain variables.', $expr->getTemplateLine(), $expr->getSourceContext());
        }

        return $expr instanceof AssignContextVariable ? $expr : new AssignContextVariable($expr->getAttribute('name'), $expr->getTemplateLine());
    }

    public function getName(): string
    {
        return '(';
    }

    public function getDescription(): string
    {
        return 'Explicit group expression (a)';
    }

    public function getPrecedence(): int
    {
        return 0;
    }
}
