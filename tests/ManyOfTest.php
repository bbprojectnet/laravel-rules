<?php

use BBProjectNet\LaravelRules\Extension;
use BBProjectNet\LaravelRules\ManyOf;
use PHPUnit\Framework\TestCase;

class ManyOfTest extends TestCase
{
	public function passes_provider()
	{
		return [
			'null' => [null, false],
			'integer' => [40, false],
			'one incorrect value' => ['app.exe', false],
			'one correct value' => ['scan.pdf', true],
			'many values with one incorrect' => ['scan.pdf,notes.txt,app.exe', false],
			'many values with all correct' => ['scan.pdf,notes.txt,report.doc', true],
			'many values with white chars' => ['scan.pdf , notes.txt , report.doc', true],
		];
	}

	/**
	 * @dataProvider passes_provider
	 */
	public function test_passes($value, $expected)
	{
		$manyOf = (new ManyOf(new Extension(['txt', 'pdf', 'doc'])))
			->delimeter(',')
			->trim();

		$result = $manyOf->passes('attribute', $value);

		$this->assertSame($expected, $result);
	}

	public function test_message()
	{
		$extension = new Extension(['txt']);

		$message = (new ManyOf($extension))->message();

		$this->assertSame($extension->message(), $message);
	}
}
