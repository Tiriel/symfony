<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Node\Expression\Binary;

use Symfony\Component\Twig\Compiler;
use Symfony\Component\Twig\Node\Expression\ReturnNumberInterface;

class BitwiseAndBinary extends AbstractBinary implements ReturnNumberInterface
{
    public function operator(Compiler $compiler): Compiler
    {
        return $compiler->raw('&');
    }
}
