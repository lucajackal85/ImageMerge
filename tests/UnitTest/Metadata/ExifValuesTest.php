<?php

namespace Jackal\ImageMerge\Test\UnitTest\Metadata;

use Jackal\ImageMerge\Metadata\Parser\ExifParser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ExifValuesTest extends TestCase
{
    private function parser(array $data): ExifParser
    {
        $reflection = new ReflectionClass(ExifParser::class);
        $parser = $reflection->newInstanceWithoutConstructor();
        $reflection->getProperty('data')->setValue($parser, $data);

        return $parser;
    }

    public static function flashValues(): array
    {
        return [
            'no flash' => [0, false],
            'fired' => [1, true],
            'did not fire, compulsory' => [16, false],
            'did not fire, auto' => [24, false],
            'fired, auto' => [25, true],
            'missing' => [null, null],
        ];
    }

    #[DataProvider('flashValues')]
    public function testFlash(?int $value, ?bool $expected): void
    {
        $this->assertSame($expected, $this->parser($value === null ? [] : ['Flash' => $value])->getFlash());
    }

    public static function rationals(): array
    {
        return [
            ['72/1', 72],
            ['300/2', 150],
            ['28/10', 2.8],
            ['0/0', null],
        ];
    }

    #[DataProvider('rationals')]
    public function testRationalValues(string $value, int|float|null $expected): void
    {
        $this->assertSame($expected, $this->parser(['FNumber' => $value])->getApertureValue());
    }
}
