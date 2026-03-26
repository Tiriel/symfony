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

use Symfony\Component\Twig\Node\TextNode;
use Symfony\Component\Twig\Test\NodeTestCase;

class TextTest extends NodeTestCase
{
    public function testConstructor()
    {
        $node = new TextNode('foo', 1);

        $this->assertEquals('foo', $node->getAttribute('data'));
    }

    public static function provideTests(): iterable
    {
        $tests = [];
        $tests[] = [new TextNode('foo', 1), "// line 1\nyield \"foo\";"];

        return $tests;
    }
}
