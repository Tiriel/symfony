<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests\NodeVisitor;

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;
use Symfony\Component\Twig\Environment;
use Symfony\Component\Twig\Loader\ArrayLoader;
use Symfony\Component\Twig\Node\BodyNode;
use Symfony\Component\Twig\Node\CheckToStringNode;
use Symfony\Component\Twig\Node\EmptyNode;
use Symfony\Component\Twig\Node\Expression\Variable\ContextVariable;
use Symfony\Component\Twig\Node\ModuleNode;
use Symfony\Component\Twig\Node\PrintNode;
use Symfony\Component\Twig\NodeTraverser;
use Symfony\Component\Twig\NodeVisitor\SandboxNodeVisitor;
use Symfony\Component\Twig\Source;

class SandboxTest extends TestCase
{
    public function testGeneratorExpression()
    {
        $env = new Environment(new ArrayLoader());
        $expr = new ContextVariable('foo', 1);
        $expr->setAttribute('is_generator', true);
        $node = new ModuleNode(new BodyNode([new PrintNode($expr, 1)]), null, new EmptyNode(), new EmptyNode(), new EmptyNode(), new EmptyNode(), new Source('foo', 'foo'));
        $traverser = new NodeTraverser($env, [new SandboxNodeVisitor($env)]);
        $node = $traverser->traverse($node);

        $this->assertNotInstanceOf(CheckToStringNode::class, $node->getNode('body')->getNode(0)->getNode('expr'));
        $this->assertSame("// line 1\nyield from (\$context[\"foo\"] ?? null);\n", $env->compile($node->getNode('body')));
    }
}
