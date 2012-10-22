<?php

class PHPParser_Tests_Node_Scalar_StringTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider provideTestParseEscapeSequences
	 */
	public function testParseEscapeSequences($expected, $string, $quote) {
		$this->assertEquals(
			$expected,
			PHPParser_Node_Scalar_String::parseEscapeSequences($string, $quote)
		);
	}

	/**
	 * @dataProvider provideTestCreate
	 */
	public function testCreate($expected, $string) {
		$this->assertEquals(
			$expected,
			PHPParser_Node_Scalar_String::create($string)->getValue()
		);
	}

	public function provideTestParseEscapeSequences() {
		return array(
			array('"', '\\"', '"'),
			array('\\"', '\\"', '`'),
			array('\\"\\`', '\\"\\`', NULL),
			array("\\\$\n\r\t\f\v", '\\\\\$\n\r\t\f\v', NULL),
			array("\x1B", '\e', NULL),
			array(chr(255), '\xFF', NULL),
			array(chr(255), '\377', NULL),
			array(chr(0), '\400', NULL),
			array("\0", '\0', NULL),
			array('\xFF', '\\\\xFF', NULL),
		);
	}

	public function provideTestCreate() {
		$tests = array(
			array('A', '\'A\''),
			array('A', 'b\'A\''),
			array('A', '"A"'),
			array('A', 'b"A"'),
			array('\\', '\'\\\\\''),
			array('\'', '\'\\\'\''),
		);

		foreach ($this->provideTestParseEscapeSequences() as $i => $test) {
			// skip second and third tests, they aren't for double quotes
			if ($i != 1 && $i != 2) {
				$tests[] = array($test[0], '"' . $test[1] . '"');
			}
		}

		return $tests;
	}
}