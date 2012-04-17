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


class Tx_Classparser_Tests_Parser_ParserTest extends Tx_Extbase_Tests_Unit_BaseTestCase {


	/**
	 * @var Tx_Extbase_Object_Manager
	 */
	protected $objectManager;

	/**
	 * @var Tx_Classparser_Service_Printer
	 */
	protected $printer;

	/**
	 * @var Tx_Classparser_Service_Printer
	 */
	protected $parser;

	/**
	 * set to true to see an overview of the parsed class objects in the backend
	 */
	protected $debugMode = TRUE;


	function setUp(){
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->parser =$this->objectManager->get('Tx_Classparser_Service_Parser');
	}


	/**
	 * @test
	 */
	function parseAndWriteSimpleProperty() {
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$this->assertEquals(count($classFileObject->getFirstClass()->getMethods()), 2);
		$this->assertEquals(count($classFileObject->getFirstClass()->getProperties()), 2);
		$this->assertEquals($classFileObject->getFirstClass()->getProperty('property')->getModifierNames(), array('protected'));
	}


	protected function parseFile($fileName) {
		$classFilePath = t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/' . $fileName;
		$classFileObject = $this->parser->parseFile($classFilePath);
		return $classFileObject;
	}

}

?>
