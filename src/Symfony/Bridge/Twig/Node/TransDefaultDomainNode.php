<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bridge\Twig\Node;

use Symfony\Component\Twig\Attribute\YieldReady;
use Symfony\Component\Twig\Compiler;
use Symfony\Component\Twig\Node\Expression\AbstractExpression;
use Symfony\Component\Twig\Node\Node;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
#[YieldReady]
final class TransDefaultDomainNode extends Node
{
    public function __construct(AbstractExpression $expr, int $lineno = 0)
    {
        parent::__construct(['expr' => $expr], [], $lineno);
    }

    public function compile(Compiler $compiler): void
    {
        // noop as this node is just a marker for TranslationDefaultDomainNodeVisitor
    }
}
