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

		return (bool)preg_match('/^(?:[a-zA-Z0-9+\/]{4})*(?:|(?:[a-zA-Z0-9+\/]{3}=)|(?:[a-zA-Z0-9+\/]{2}==)|(?:[a-zA-Z0-9+\/]{1}===))$/', $value);
	}

	/**
	 * @inheritDoc
	 */
	public function message()
	{
		return 'The :attribute must be a valid base64 encoded string.';
	}
}
