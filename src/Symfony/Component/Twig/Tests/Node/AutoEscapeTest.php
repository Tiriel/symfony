<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests\Node;

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Twig\Node\AutoEscapeNode;
use Symfony\Component\Twig\Node\Nodes;
use Symfony\Component\Twig\Node\TextNode;
use Symfony\Component\Twig\Test\NodeTestCase;

class AutoEscapeTest extends NodeTestCase
{
    public function testConstructor()
    {
        $body = new Nodes([new TextNode('foo', 1)]);
        $node = new AutoEscapeNode(true, $body, 1);

        $this->assertEquals($body, $node->getNode('body'));
        $this->assertTrue($node->getAttribute('value'));
    }

    public static function provideTests(): iterable
    {
        $body = new Nodes([new TextNode('foo', 1)]);
        $node = new AutoEscapeNode(true, $body, 1);

        return [
            [$node, "// line 1\nyield \"foo\";"],
        ];
    }
}
