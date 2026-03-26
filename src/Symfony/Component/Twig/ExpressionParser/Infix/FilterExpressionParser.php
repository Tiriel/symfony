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

use Symfony\Component\Twig\Attribute\FirstClassTwigCallableReady;
use Symfony\Component\Twig\ExpressionParser\AbstractExpressionParser;
use Symfony\Component\Twig\ExpressionParser\ExpressionParserDescriptionInterface;
use Symfony\Component\Twig\ExpressionParser\InfixAssociativity;
use Symfony\Component\Twig\ExpressionParser\InfixExpressionParserInterface;
use Symfony\Component\Twig\ExpressionParser\PrecedenceChange;
use Symfony\Component\Twig\Node\EmptyNode;
use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Node\Expression\ConstantExpression;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Token;

/**
 * @internal
 */
final class FilterExpressionParser extends AbstractExpressionParser implements InfixExpressionParserInterface, ExpressionParserDescriptionInterface
{
    use ArgumentsTrait;

    private $readyNodes = [];

    public function parse(Parser $parser, AbstractExpression $expr, Token $token): AbstractExpression
    {
        $stream = $parser->getStream();
        $token = $stream->expect(Token::NAME_TYPE);
        $line = $token->getLine();

        if (!$stream->test(Token::OPERATOR_TYPE, '(')) {
            $arguments = new EmptyNode();
        } else {
            $arguments = $this->parseNamedArguments($parser);
        }

        $filter = $parser->getFilter($token->getValue(), $line);

        $ready = true;
        if (!isset($this->readyNodes[$class = $filter->getNodeClass()])) {
            $this->readyNodes[$class] = (bool) (new \ReflectionClass($class))->getConstructor()->getAttributes(FirstClassTwigCallableReady::class);
        }

        if (!$ready = $this->readyNodes[$class]) {
            trigger_deprecation('twig/twig', '3.12', 'Twig node "%s" is not marked as ready for passing a "TwigFilter" in the constructor instead of its name; please update your code and then add #[FirstClassTwigCallableReady] attribute to the constructor.', $class);
        }

        return new $class($expr, $ready ? $filter : new ConstantExpression($filter->getName(), $line), $arguments, $line);
    }

    public function getName(): string
    {
        return '|';
    }

    public function getDescription(): string
    {
        return 'Twig filter call';
    }

    public function getPrecedence(): int
    {
        return 512;
    }

    public function getPrecedenceChange(): ?PrecedenceChange
    {
        return new PrecedenceChange('twig/twig', '3.21', 300);
    }

    public function getAssociativity(): InfixAssociativity
    {
        return InfixAssociativity::Left;
    }
}
