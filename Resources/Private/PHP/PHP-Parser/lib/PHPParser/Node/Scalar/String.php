<?php

/**
 * @property string $value String value
 */
class PHPParser_Node_Scalar_String extends PHPParser_Node_Scalar {

	/**
	 * @var array
	 */
	protected static $replacements = array(
		'\\' => '\\',
		'$' => '$',
		'n' => "\n",
		'r' => "\r",
		't' => "\t",
		'f' => "\f",
		'v' => "\v",
		'e' => "\x1B",
	);

	/**
	 * Contains value
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Constructs a string scalar node.
	 *
	 * @param string $value Value of the string
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct($value = NULL, $line = -1, $ignorables = array()) {
		$this->setValue($value);
		parent::__construct($line, $ignorables);
	}

	/**
	 * Creates a String node from a string token (parses escape sequences).
	 *
	 * @param string $str String
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 *
	 * @return PHPParser_Node_Scalar_String String Node
	 */
	public static function create($str, $line = -1, $ignorables = array()) {
		$bLength = 0;
		if ('b' === $str[0]) {
			$bLength = 1;
		}

		if ('\'' === $str[$bLength]) {
			$str = str_replace(
				array('\\\\', '\\\''),
				array('\\', '\''),
				substr($str, $bLength + 1, -1)
			);
		} else {
			$str = self::parseEscapeSequences(substr($str, $bLength + 1, -1), '"');
		}

		return new self($str, $line, $ignorables);
	}

	/**
	 * Parses escape sequences in strings (all string types apart from single quoted).
	 *
	 * @param string $str String without quotes
	 * @param null|string $quote Quote type
	 *
	 * @return string String with escape sequences parsed
	 */
	public static function parseEscapeSequences($str, $quote) {
		if (NULL !== $quote) {
			$str = str_replace('\\' . $quote, $quote, $str);
		}

		return preg_replace_callback(
			'~\\\\([\\\\$nrtfve]|[xX][0-9a-fA-F]{1,2}|[0-7]{1,3})~',
			array(__CLASS__, 'parseCallback'),
			$str
		);
	}

	/**
	 * @static
	 * @param $matches
	 * @return string
	 */
	public static function parseCallback($matches) {
		$str = $matches[1];

		if (isset(self::$replacements[$str])) {
			return self::$replacements[$str];
		} elseif ('x' === $str[0] || 'X' === $str[0]) {
			return chr(hexdec($str));
		} else {
			return chr(octdec($str));
		}
	}

	/**
	 * Parses a constant doc string.
	 *
	 * @param string $startToken Doc string start token content (<<<SMTHG)
	 * @param string $str String token content
	 *
	 * @return string Parsed string
	 */
	public static function parseDocString($startToken, $str) {
		// strip last newline (thanks tokenizer for sticking it into the string!)
		$str = preg_replace('~(\r\n|\n|\r)$~', '', $str);

		// nowdoc string
		if (FALSE !== strpos($startToken, '\'')) {
			return $str;
		}

		return self::parseEscapeSequences($str, NULL);
	}

	/**
	 * @param string $value
	 * @return \PHPParser_Node_Scalar_String
	 */
	public function setValue($value) {
		$this->value = (string)$value;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
}