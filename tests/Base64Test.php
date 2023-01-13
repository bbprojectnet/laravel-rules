<?php

use BBProjectNet\LaravelRules\Base64;
use PHPUnit\Framework\TestCase;

class Base64Test extends TestCase
{
	public function passes_provider()
	{
		return [
			'null' => [null, false],
			'integer' => [40, false],
			'empty string' => ['', true],
			'base64 string' => ['Y29udGVudA==', true],
			'invalid base64 string' => ['Y29udGVudA=', false],
		];
	}

	/**
	 * @dataProvider passes_provider
	 */
	public function test_passes($value, $expected)
	{
		$result = (new Base64())->passes('attribute', $value);

		$this->assertSame($expected, $result);
	}
}
