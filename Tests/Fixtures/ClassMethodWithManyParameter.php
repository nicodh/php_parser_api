<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen <mail@ndh-websolutions.de>
 *  All rights reserved
 *
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @package
 * @author Nico de Haen
 */

class ClassMethodWithManyParameter {

	/**
	 * @static
	 * @param $number
	 * @param $string
	 * @param array $arr
	 * @param bool $boolean
	 * @param float $float
	 * @return string
	 */
	private static function testMethod($number, $string, array $arr, $boolean = FALSE, $float = 0.2, Tx_Classparser_Parser_Utility_NodeConverter $n) {
		if($number > 3) {
			return 'bar';
		} else {
			return 'foo';
		}
	}
}