<?php

namespace BBProjectNet\LaravelRules;

use Illuminate\Contracts\Validation\Rule;

class Extension implements Rule
{
	/**
	 * Allowed extensions list
	 *
	 * @var array<int, string>
	 */
	protected array $allowedExtensions;

	/**
	 * Create a new rule instance
	 *
	 * @param array<int, string> $allowedExtensions
	 * @return void
	 */
	public function __construct(array $allowedExtensions)
	{
		$this->allowedExtensions = array_map('strtolower', $allowedExtensions);
	}

	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value)
	{
		if (! is_string($value)) {
			return false;
		}

		$extension = strtolower(pathinfo($value, PATHINFO_EXTENSION));

		return in_array($extension, $this->allowedExtensions, true);
	}

	/**
	 * @inheritDoc
	 * @codeCoverageIgnore
	 */
	public function message()
	{
		return 'The :attribute extension is not a valid file type.';
	}
}
