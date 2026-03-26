<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests\Node\Expression;

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Twig\Node\Expression\ParentExpression;
use Symfony\Component\Twig\Test\NodeTestCase;

class ParentTest extends NodeTestCase
{
    public function testConstructor()
    {
        $node = new ParentExpression('foo', 1);

        $this->assertEquals('foo', $node->getAttribute('name'));
    }

    public static function provideTests(): iterable
    {
        $tests = [];
        $tests[] = [new ParentExpression('foo', 1), '$this->renderParentBlock("foo", $context, $blocks)'];

        return $tests;
    }
}
