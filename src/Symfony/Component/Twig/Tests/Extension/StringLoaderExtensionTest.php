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
use Symfony\Component\Twig\Extension\CoreExtension;
use Symfony\Component\Twig\Extension\StringLoaderExtension;
use Symfony\Component\Twig\Loader\ArrayLoader;

class StringLoaderExtensionTest extends TestCase
{
    public function testIncludeWithTemplateStringAndNoSandbox()
    {
        $twig = new Environment(new ArrayLoader());
        $twig->addExtension(new StringLoaderExtension());
        $this->assertSame('something', CoreExtension::include($twig, [], StringLoaderExtension::templateFromString($twig, 'something')));
    }
}
