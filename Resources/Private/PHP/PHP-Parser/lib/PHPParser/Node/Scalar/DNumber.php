<?php

class PHPParser_Node_Scalar_DNumber extends PHPParser_Node_Scalar {

	/**
	 * Contains value
	 *
	 * @var float
	 */
	protected $value;

	/**
	 * Constructs a float number scalar node.
	 *
	 * @param float $value Value of the number
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($value = 0.0, $line = -1, $ignorables = array()) {
		$this->setValue($value);
		parent::__construct($line, $ignorables);
	}

	/**
	 * Parses a DNUMBER token like PHP would.
	 *
	 * @param string $str A string number
	 *
	 * @return float The parsed number
	 */
	public static function parse($str) {
		// if string contains any of .eE just cast it to float
		if (FALSE !== strpbrk($str, '.eE')) {
			return (float)$str;
		}

		// otherwise it's an integer notation that overflowed into a float
		// if it starts with 0 it's one of the special integer notations
		if ('0' === $str[0]) {
			// hex
			if ('x' === $str[1] || 'X' === $str[1]) {
				return hexdec($str);
			}

			// bin
			if ('b' === $str[1] || 'B' === $str[1]) {
				return bindec($str);
			}

			// oct
			// substr($str, 0, strcspn($str, '89')) cuts the string at the first invalid digit (8 or 9)
			// so that only the digits before that are used
			return octdec(substr($str, 0, strcspn($str, '89')));
		}

		// dec
		return (float)$str;
	}

	/**
	 * @param float $value
	 * @return \PHPParser_Node_Scalar_DNumber
	 */
	public function setValue($value) {
		$this->value = (float)$value;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getValue() {
		return $this->value;
	}
}