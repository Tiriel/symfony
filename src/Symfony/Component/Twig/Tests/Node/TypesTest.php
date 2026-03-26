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

use Symfony\Component\Twig\Node\TypesNode;
use Symfony\Component\Twig\Test\NodeTestCase;

class TypesTest extends NodeTestCase
{
    private static function getValidMapping(): array
    {
        // {foo: 'string', bar?: 'number'}
        return [
            'foo' => [
                'type' => 'string',
                'optional' => false,
            ],
            'bar' => [
                'type' => 'number',
                'optional' => true,
            ],
        ];
    }

    public function testConstructor()
    {
        $types = self::getValidMapping();
        $node = new TypesNode($types, 1);

        $this->assertEquals($types, $node->getAttribute('mapping'));
    }

    public static function provideTests(): iterable
    {
        return [
            // 1st test: Node shouldn't compile at all
            [
                new TypesNode(self::getValidMapping(), 1),
                '',
            ],
        ];
    }
}
