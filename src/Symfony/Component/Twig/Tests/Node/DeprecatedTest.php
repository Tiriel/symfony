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

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Component\Twig\Compiler;
use Symfony\Component\Twig\Environment;
use Symfony\Component\Twig\Loader\ArrayLoader;
use Symfony\Component\Twig\Node\DeprecatedNode;
use Symfony\Component\Twig\Node\EmptyNode;
use Symfony\Component\Twig\Node\Expression\ConstantExpression;
use Symfony\Component\Twig\Node\Expression\FunctionExpression;
use Symfony\Component\Twig\Node\IfNode;
use Symfony\Component\Twig\Node\Nodes;
use Symfony\Component\Twig\Source;
use Symfony\Component\Twig\Test\NodeTestCase;
use Symfony\Component\Twig\TwigFunction;

class DeprecatedTest extends NodeTestCase
{
    public function testConstructor()
    {
        $expr = new ConstantExpression('foo', 1);
        $node = new DeprecatedNode($expr, 1);

        $this->assertEquals($expr, $node->getNode('expr'));
    }

    public static function provideTests(): iterable
    {
        $tests = [];

        $expr = new ConstantExpression('This section is deprecated', 1);
        $node = new DeprecatedNode($expr, 1);
        $node->setSourceContext(new Source('', 'foo.twig'));
        $node->setNode('package', new ConstantExpression('twig/twig', 1));
        $node->setNode('version', new ConstantExpression('1.1', 1));

        $tests[] = [$node, <<<EOF
// line 1
trigger_deprecation("twig/twig", "1.1", "This section is deprecated"." in \"foo.twig\" at line 1.");
EOF
        ];

        $t = new Nodes([
            new ConstantExpression(true, 1),
            $dep = new DeprecatedNode($expr, 2),
        ], 1);
        $node = new IfNode($t, null, 1);
        $node->setSourceContext(new Source('', 'foo.twig'));
        $dep->setNode('package', new ConstantExpression('twig/twig', 1));
        $dep->setNode('version', new ConstantExpression('1.1', 1));

        $tests[] = [$node, <<<EOF
// line 1
if (true) {
    // line 2
    trigger_deprecation("twig/twig", "1.1", "This section is deprecated"." in \"foo.twig\" at line 2.");
}
EOF
        ];

        $environment = new Environment(new ArrayLoader());
        $environment->addFunction($function = new TwigFunction('foo', 'Symfony\Component\Twig\Tests\Node\foo', []));

        $expr = new FunctionExpression($function, new EmptyNode(), 1);
        $node = new DeprecatedNode($expr, 1);
        $node->setSourceContext(new Source('', 'foo.twig'));
        $node->setNode('package', new ConstantExpression('twig/twig', 1));
        $node->setNode('version', new ConstantExpression('1.1', 1));

        $compiler = new Compiler($environment);
        $varName = $compiler->getVarName();

        $tests[] = [$node, <<<EOF
// line 1
\$$varName = Symfony\Component\Twig\Tests\Node\\foo();
trigger_deprecation("twig/twig", "1.1", \$$varName." in \"foo.twig\" at line 1.");
EOF, $environment];

        return $tests;
    }
}

function foo()
{
}
