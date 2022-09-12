<?php

namespace BBProjectNet\LaravelRules;

use Illuminate\Contracts\Validation\Rule;

class ManyOf implements Rule
{
	/**
	 * Delimeter
	 *
	 * @var string
	 */
	protected string $delimeter = ',';

	/**
	 * Trim values
	 *
	 * @var bool
	 */
	protected bool $trim = true;

	/**
	 * Create a new rule instance
	 *
	 * @param \Illuminate\Contracts\Validation\Rule $rule
	 */
	public function __construct(
		protected Rule $rule,
	)
	{
	}

	/**
	 * Set delimeter value
	 *
	 * @param string $delimeter
	 * @return static
	 */
	public function delimeter(string $delimeter): static
	{
		$this->delimeter = $delimeter;

		return $this;
	}

	/**
	 * Set trim value
	 *
	 * @param string $trim
	 * @return static
	 */
	public function trim(bool $trim): static
	{
		$this->trim = $trim;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function passes($attribute, $value)
	{
		if (! is_string($value)) {
			return false;
		}

		$values = explode($this->delimeter, $value);

		if ($this->trim) {
			$values = array_filter(array_map('trim', $values));
		}

		foreach ($values as $value) {
			if (! $this->rule->passes($attribute, $value)) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function message()
	{
		return $this->rule->message();
	}
}
