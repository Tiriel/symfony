<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests;

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;
use Symfony\Component\Twig\RuntimeLoader\FactoryRuntimeLoader;

class FactoryRuntimeLoaderTest extends TestCase
{
    public function testLoad()
    {
        $loader = new FactoryRuntimeLoader(['stdClass' => '\Symfony\Component\Twig\Tests\getRuntime']);

        $this->assertInstanceOf('stdClass', $loader->load('stdClass'));
    }

    public function testLoadReturnsNullForUnmappedRuntime()
    {
        $loader = new FactoryRuntimeLoader();

        $this->assertNull($loader->load('stdClass'));
    }
}

function getRuntime()
{
    return new \stdClass();
}
