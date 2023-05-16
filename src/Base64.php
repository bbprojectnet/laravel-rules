<?php

namespace BBProjectNet\LaravelRules;

use Illuminate\Contracts\Validation\Rule;

class Base64 implements Rule
{
	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value)
	{
		if (! is_string($value)) {
			return false;
		}

		return strlen($value) % 4 === 0 && preg_match('/^(?>[a-zA-Z0-9+\/]*)={0,3}$/', $value);
	}

	/**
	 * @inheritDoc
	 * @codeCoverageIgnore
	 */
	public function message()
	{
		return 'The :attribute must be a valid base64 encoded string.';
	}
}
