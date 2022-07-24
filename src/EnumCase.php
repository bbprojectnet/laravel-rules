<?php

namespace BBProjectNet\LaravelRules;

use Illuminate\Contracts\Validation\Rule;
use InvalidArgumentException;

class EnumCase implements Rule
{
	/**
	 * Allowed values
	 *
	 * @var array<int, string>
	 */
	protected array $allowedValues;

	/**
	 * Create a new rule instance
	 *
	 * @param string|class-string|object|array<int, object> $enum
	 * @return void
	 */
	public function __construct(string|object|array $enum)
	{
		if (is_string($enum)) {
			if (! enum_exists($enum)) {
				throw new InvalidArgumentException('Argument #1 ($enum) enum "' . $enum . '" not found'); // @codeCoverageIgnore
			}

			$enum = $enum::cases();
		}
		elseif (is_object($enum)) {
			$enum = [$enum];
		}

		$this->allowedValues = array_filter(array_map(fn (object $case) => $case?->value, $enum));
	}

	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value)
	{
		return in_array($value, $this->allowedValues, true);
	}

	/**
	 * @inheritDoc
	 */
	public function message()
	{
		return 'The selected :attribute is invalid.';
	}
}
