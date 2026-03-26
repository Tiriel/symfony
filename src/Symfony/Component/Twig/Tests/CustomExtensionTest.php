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
use Symfony\Component\Twig\Environment;
use Symfony\Component\Twig\Extension\ExtensionInterface;
use Symfony\Component\Twig\Loader\ArrayLoader;

class CustomExtensionTest extends TestCase
{
    /**
     * @group legacy
     *
     * @dataProvider provideInvalidExtensions
     */
    public function testGetInvalidOperators(ExtensionInterface $extension, $expectedExceptionMessage)
    {
        $env = new Environment(new ArrayLoader());
        $env->addExtension($extension);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $env->getExpressionParsers();
    }

    public static function provideInvalidExtensions()
    {
        return [
            [new InvalidOperatorExtension([1, 2, 3]), '"Symfony\Component\Twig\Tests\InvalidOperatorExtension::getOperators()" must return an array of 2 elements, got 3.'],
        ];
    }
}

class InvalidOperatorExtension implements ExtensionInterface
{
    private $operators;

    public function __construct($operators)
    {
        $this->operators = $operators;
    }

    public function getTokenParsers(): array
    {
        return [];
    }

    public function getNodeVisitors(): array
    {
        return [];
    }

    public function getFilters(): array
    {
        return [];
    }

    public function getTests(): array
    {
        return [];
    }

    public function getFunctions(): array
    {
        return [];
    }

    public function getOperators(): array
    {
        return $this->operators;
    }
}
