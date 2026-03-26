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
use Symfony\Component\Twig\Attribute\AsTwigFunction;
use Symfony\Component\Twig\Attribute\AsTwigTest;
use Symfony\Component\Twig\DeprecatedCallableInfo;
use Symfony\Component\Twig\Environment;

class ExtensionWithAttributes
{
    #[AsTwigFilter(name: 'foo', isSafe: ['html'])]
    public function fooFilter(string|int $string)
    {
    }

    #[AsTwigFilter('with_context_filter', needsContext: true)]
    public function withContextFilter(array $context, string $string)
    {
    }

    #[AsTwigFilter('with_env_filter')]
    public function withEnvFilter(Environment $env, string $string)
    {
    }

    #[AsTwigFilter('with_env_and_context_filter', needsContext: true)]
    public function withEnvAndContextFilter(Environment $env, array $context, array $data)
    {
    }

    #[AsTwigFilter('variadic_filter')]
    public function variadicFilter(string ...$strings)
    {
    }

    #[AsTwigFilter('deprecated_filter', deprecationInfo: new DeprecatedCallableInfo('foo/bar', '1.2'))]
    public function deprecatedFilter(string $string)
    {
    }

    #[AsTwigFilter('pattern_*_filter')]
    public function patternFilter(string $string)
    {
    }

    #[AsTwigFunction(name: 'foo', isSafe: ['html'])]
    public function fooFunction(string|int $string)
    {
    }

    #[AsTwigFunction('with_context_function', needsContext: true)]
    public function withContextFunction(array $context, string $string)
    {
    }

    #[AsTwigFunction('with_env_function')]
    public function withEnvFunction(Environment $env, string $string)
    {
    }

    #[AsTwigFunction('with_env_and_context_function', needsContext: true)]
    public function withEnvAndContextFunction(Environment $env, array $context, string $string)
    {
    }

    #[AsTwigFunction('no_arg_function')]
    public function noArgFunction()
    {
    }

    #[AsTwigFunction('variadic_function')]
    public function variadicFunction(string ...$strings)
    {
    }

    #[AsTwigFunction('deprecated_function', deprecationInfo: new DeprecatedCallableInfo('foo/bar', '1.2'))]
    public function deprecatedFunction(string $string)
    {
    }

    #[AsTwigTest(name: 'foo')]
    public function fooTest(string|int $value)
    {
    }

    #[AsTwigTest('variadic_test')]
    public function variadicTest(string ...$value)
    {
    }

    #[AsTwigTest('with_context_test', needsContext: true)]
    public function withContextTest(array $context, $argument)
    {
    }

    #[AsTwigTest('with_env_test')]
    public function withEnvTest(Environment $env, $argument)
    {
    }

    #[AsTwigTest('with_env_and_context_test', needsContext: true)]
    public function withEnvAndContextTest(Environment $env, array $context, $argument)
    {
    }

    #[AsTwigTest('deprecated_test', deprecationInfo: new DeprecatedCallableInfo('foo/bar', '1.2'))]
    public function deprecatedTest($value, $argument)
    {
    }
}
