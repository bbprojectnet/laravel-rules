<?php

use BBProjectNet\LaravelRules\EnumCase;
use PHPUnit\Framework\TestCase;

enum TestEnum: string
{
	case First = 'first';
	case Second = 'second';
	case Third = 'third';
}

class EnumCaseTest extends TestCase
{
	public function construct_provider()
	{
		return [
			'not existing enum' => [OtherEnum::class, false],
			'existing enum' => [TestEnum::class, true],
			'one allowed case' => [TestEnum::Second, true],
			'multiple allowed cases' => [[TestEnum::Second, TestEnum::Third], true],
			'multiple invalid allowed cases' => [['first', 'second'], false],
		];
	}

	/**
	 * @dataProvider construct_provider
	 */
	public function test_construct($enum, $expected)
	{
		if (! $expected) {
			$this->expectException(InvalidArgumentException::class);
		}

		$enumCase = new EnumCase($enum);

		if ($expected) {
			$this->assertInstanceOf(EnumCase::class, $enumCase);
		}
	}

	public function passes_provider()
	{
		return [
			'null' => [TestEnum::class, null, false],
			'incorrect value' => [TestEnum::class, 'ten', false],
			'correct value' => [TestEnum::class, 'first', true],
			'enum case value' => [TestEnum::class, TestEnum::First, true],
			'one allowed case with incorrect value' => [TestEnum::Second, 'first', false],
			'one allowed case with correct value' => [TestEnum::Second, 'second', true],
			'multiple allowed cases with incorrect value' => [[TestEnum::Second, TestEnum::Third], 'first', false],
			'multiple allowed cases with correct value' => [[TestEnum::Second, TestEnum::Third], 'third', true],
		];
	}

	/**
	 * @dataProvider passes_provider
	 */
	public function test_passes($enum, $value, $expected)
	{
		$result = (new EnumCase($enum))->passes('attribute', $value);

		$this->assertSame($expected, $result);
	}
}
