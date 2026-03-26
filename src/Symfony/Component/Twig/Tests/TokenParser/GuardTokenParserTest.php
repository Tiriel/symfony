<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Twig\Tests\TokenParser;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Twig\Environment;
use Symfony\Component\Twig\Error\SyntaxError;
use Symfony\Component\Twig\Loader\ArrayLoader;
use Symfony\Component\Twig\Parser;
use Symfony\Component\Twig\Source;

class GuardTokenParserTest extends TestCase
{
    public function testUndefinedHandlers()
    {
        $this->expectNotToPerformAssertions();

        $env = new Environment(new ArrayLoader(), ['cache' => false, 'autoescape' => false]);
        $env->registerUndefinedFunctionCallback(static fn ($name) => throw new SyntaxError('boom.'));
        (new Parser($env))->parse($env->tokenize(new Source('{% guard function boom %}{% endguard %}', '')));
    }
}
