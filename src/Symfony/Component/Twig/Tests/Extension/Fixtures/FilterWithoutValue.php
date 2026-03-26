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

use Symfony\Component\Twig\Attribute\AsTwigFilter;

class FilterWithoutValue
{
    #[AsTwigFilter('my_filter')]
    public function myFilter()
    {
    }
}
