<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen
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

require_once(t3lib_extmgm::extPath('classparser') . 'Tests/BaseTest.php');

class Tx_Classparser_Tests_Unit_ParserTest extends Tx_Classparser_Tests_BaseTest {

	/**
	 * @var Tx_Classparser_Service_Printer
	 */
	protected $parser;

	/**
	 * set to true to see an overview of the parsed class objects in the backend
	 */
	protected $debugMode = TRUE;

	/**
	 * @test
	 */
	function parseSimpleProperty() {
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$this->assertEquals(count($classFileObject->getFirstClass()->getMethods()), 2);
		$this->assertEquals(count($classFileObject->getFirstClass()->getProperties()), 2);
		$this->assertEquals($classFileObject->getFirstClass()->getProperty('property')->getModifierNames(), array('protected'));
		return $classFileObject;
	}

	/**
	 * @test
	 */
	function parseClassMethodWithManyParameter() {
		$classFileObject = $this->parseFile('ClassMethodWithManyParameter.php');
	}


}

?>
