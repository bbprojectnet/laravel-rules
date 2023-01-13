<?php

namespace BBProjectNet\LaravelRules;

use Illuminate\Contracts\Validation\Rule;
use InvalidArgumentException;
use UnitEnum;

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
	 * @param class-string<\UnitEnum>|\UnitEnum|array<int, \UnitEnum> $enum
	 * @return void
	 */
	public function __construct(string|UnitEnum|array $enum)
	{
		if (is_string($enum)) {
			if (! enum_exists($enum)) {
				throw new InvalidArgumentException('Argument #1 ($enum) enum "' . $enum . '" not found');
			}

			$enum = $enum::cases();
		}
		elseif ($enum instanceof UnitEnum) {
			$enum = [$enum];
		}
		else {
			foreach ($enum as $entry) {
				if (! $entry instanceof UnitEnum) {
					throw new InvalidArgumentException('Argument #1 ($enum) contains not enum value');
				}
			}
		}

		$this->allowedValues = array_filter(array_map(fn (UnitEnum $case) => $case?->value, $enum));
	}

	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value)
	{
		if ($value instanceof UnitEnum) {
			$value = $value->value;
		}

		return in_array($value, $this->allowedValues, true);
	}

	/**
	 * @inheritDoc
	 * @codeCoverageIgnore
	 */
	public function message()
	{
		return 'The selected :attribute is invalid.';
	}
}
