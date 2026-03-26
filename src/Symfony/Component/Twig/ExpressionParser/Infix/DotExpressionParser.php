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

use Symfony\Component\Twig\Error\SyntaxError;
use Symfony\Component\Twig\ExpressionParser\AbstractExpressionParser;
use Symfony\Component\Twig\ExpressionParser\ExpressionParserDescriptionInterface;
use Symfony\Component\Twig\ExpressionParser\InfixAssociativity;
use Symfony\Component\Twig\ExpressionParser\InfixExpressionParserInterface;
use Symfony\Component\Twig\Lexer;
use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Node\Expression\ArrayExpression;
use Symfony\Component\Twig\Node\Expression\ConstantExpression;
use Symfony\Component\Twig\Node\Expression\GetAttrExpression;
use Symfony\Component\Twig\Node\Expression\MacroReferenceExpression;
use Symfony\Component\Twig\Node\Expression\NameExpression;
use Symfony\Component\Twig\Node\Expression\Variable\TemplateVariable;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Template;
use Symfony\Component\Twig\Token;

/**
 * @internal
 */
final class DotExpressionParser extends AbstractExpressionParser implements InfixExpressionParserInterface, ExpressionParserDescriptionInterface
{
    use ArgumentsTrait;

    public function parse(Parser $parser, AbstractExpression $expr, Token $token): AbstractExpression
    {
        $nullSafe = '?.' === $token->getValue();
        $stream = $parser->getStream();
        $token = $stream->getCurrent();
        $lineno = $token->getLine();
        $arguments = new ArrayExpression([], $lineno);
        $type = Template::ANY_CALL;

        if ($stream->nextIf(Token::OPERATOR_TYPE, '(')) {
            $attribute = $parser->parseExpression();
            $stream->expect(Token::PUNCTUATION_TYPE, ')');
        } else {
            $token = $stream->next();
            if (
                $token->test(Token::NAME_TYPE)
                || $token->test(Token::NUMBER_TYPE)
                || ($token->test(Token::OPERATOR_TYPE) && preg_match(Lexer::REGEX_NAME, $token->getValue()))
            ) {
                $attribute = new ConstantExpression($token->getValue(), $token->getLine());
            } else {
                throw new SyntaxError(\sprintf('Expected name or number, got value "%s" of type "%s".', $token->getValue(), $token->toEnglish()), $token->getLine(), $stream->getSourceContext());
            }
        }

        if ($stream->test(Token::OPERATOR_TYPE, '(')) {
            $type = Template::METHOD_CALL;
            $arguments = $this->parseCallableArguments($parser, $token->getLine());
        }

        if (
            $expr instanceof NameExpression
            && (
                null !== $parser->getImportedSymbol('template', $expr->getAttribute('name'))
                || '_self' === $expr->getAttribute('name') && $attribute instanceof ConstantExpression
            )
        ) {
            return new MacroReferenceExpression(new TemplateVariable($expr->getAttribute('name'), $expr->getTemplateLine()), 'macro_'.$attribute->getAttribute('value'), $arguments, $expr->getTemplateLine());
        }

        return new GetAttrExpression($expr, $attribute, $arguments, $type, $lineno, $nullSafe);
    }

    public function getName(): string
    {
        return '.';
    }

    public function getAliases(): array
    {
        return ['?.'];
    }

    public function getDescription(): string
    {
        return 'Get an attribute on a variable';
    }

    public function getPrecedence(): int
    {
        return 512;
    }

    public function getAssociativity(): InfixAssociativity
    {
        return InfixAssociativity::Left;
    }
}
