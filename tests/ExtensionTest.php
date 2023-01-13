<?php

use BBProjectNet\LaravelRules\Extension;
use PHPUnit\Framework\TestCase;

class ExtensionTest extends TestCase
{
	public function passes_provider()
	{
		return [
			'null' => [['jpg'], null, false],
			'integer' => [['jpg'], 60, false],
			'filename' => [['jpg', 'png'], 'image.jpg', true],
			'filename with mixed case' => [['JPG', 'PNG'], 'Image.Jpg', true],
			'filename with not allowed extension' => [['gif', 'png'], 'image.jpg', false],
			'full path' => [['7z', 'zip'], '/home/john/files.zip', true],
		];
	}

	/**
	 * @dataProvider passes_provider
	 */
	public function test_passes($allowedExtensions, $value, $expected)
	{
		$result = (new Extension($allowedExtensions))->passes('attribute', $value);

		$this->assertSame($expected, $result);
	}
}
