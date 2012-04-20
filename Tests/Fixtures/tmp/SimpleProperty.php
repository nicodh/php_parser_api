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
abstract class Tx_PhpParser_Tests_SimplePropertyTest {

	const TEST = 'MyConstant';
	const TEST4 = 'MyConstant2';
	const TEST2 = 890;
	private $test = array(
		'test' => 123,
		'test5' => 456,
		'arr' => array(
			'sieben' => 7
		)
	);
	
	/**
	 * @var string
	 */
	protected $property = array('a' => 'b');
	
	/**
	 * @param string $property
	 */
	public function setProperty( $property) {
		// comment in a new line
		if (strlen($property) > 50) {
			// some comment here
			$property = substr($property, 0, 49);
		}
		$this->property = $property;
	}
	
	/**
	 * @return string
	 */
	public function getProperty() {
		return $this->property;
	}

}

?>