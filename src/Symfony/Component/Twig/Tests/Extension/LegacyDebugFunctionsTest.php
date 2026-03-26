<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests\Extension;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Twig\Environment;
use Symfony\Component\Twig\Extension\DebugExtension;
use Symfony\Component\Twig\Loader\ArrayLoader;

/**
 * @group legacy
 */
class LegacyDebugFunctionsTest extends TestCase
{
    public function testDump()
    {
        $env = new Environment(new ArrayLoader());

        $this->assertSame(DebugExtension::dump($env, 'Foo'), twig_var_dump($env, 'Foo'));
    }
}
