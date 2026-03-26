<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests\Extension\Fixtures;

use Symfony\Component\Twig\Attribute\AsTwigTest;

class TestWithoutValue
{
    #[AsTwigTest('my_test')]
    public function myTest()
    {
    }
}
