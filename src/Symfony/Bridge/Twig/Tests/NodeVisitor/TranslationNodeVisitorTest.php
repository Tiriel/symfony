<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Tests\NodeVisitor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\NodeVisitor\TranslationNodeVisitor;
use Symfony\Component\Twig\Environment;
use Symfony\Component\Twig\Loader\ArrayLoader;
use Symfony\Component\Twig\Node\Expression\ArrayExpression;
use Symfony\Component\Twig\Node\Expression\ConstantExpression;
use Symfony\Component\Twig\Node\Expression\FilterExpression;
use Symfony\Component\Twig\Node\Expression\Variable\ContextVariable;
use Symfony\Component\Twig\Node\Node;
use Symfony\Component\Twig\Node\Nodes;
use Symfony\Component\Twig\TwigFilter;

class TranslationNodeVisitorTest extends TestCase
{
    #[DataProvider('getMessagesExtractionTestData')]
    public function testMessagesExtraction(Node $node, array $expectedMessages)
    {
        $env = new Environment(new ArrayLoader(), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $visitor = new TranslationNodeVisitor();
        $visitor->enable();
        $visitor->enterNode($node, $env);
        $visitor->leaveNode($node, $env);
        $this->assertEquals($expectedMessages, $visitor->getMessages());
    }

    public function testMessageExtractionWithInvalidDomainNode()
    {
        $message = 'new key';

        $n = new Nodes([
            new ArrayExpression([], 0),
            new ContextVariable('variable', 0),
        ]);

        $node = new FilterExpression(
            new ConstantExpression($message, 0),
            new TwigFilter('trans'),
            $n,
            0
        );

        $this->testMessagesExtraction($node, [[$message, TranslationNodeVisitor::UNDEFINED_DOMAIN]]);
    }

    public static function getMessagesExtractionTestData()
    {
        $message = 'new key';
        $domain = 'domain';

        return [
            [TwigNodeProvider::getTransFilter($message), [[$message, null]]],
            [TwigNodeProvider::getTransTag($message), [[$message, null]]],
            [TwigNodeProvider::getTransFilter($message, $domain), [[$message, $domain]]],
            [TwigNodeProvider::getTransTag($message, $domain), [[$message, $domain]]],
        ];
    }
}
