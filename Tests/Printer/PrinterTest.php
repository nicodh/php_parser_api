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

require_once(t3lib_extmgm::extPath('classparser') . 'Tests/Parser/ParserTest.php');

class Tx_Classparser_Tests_PrinterTest extends Tx_Classparser_Tests_Parser_ParserTest {


	function setUp(){
		parent::setUp();
		$this->printer = $this->objectManager->get('Tx_Classparser_Service_Printer');
		//vfsStream::setup('testDir');
		//$this->testDir = vfsStream::url('testDir').'/';
		$this->testDir = t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/tmp/';
	}



	/**
	 * @test
	 */
	public function printTest() {
		$this->parseAndWrite('ClassMethodWithManyParameter.php');
	}

	protected function parseAndWrite($fileName) {
		$classFilePath = t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/' . $fileName;
		$classFileObject = $this->parser->parseFile($classFilePath);
		$newClassFilePath = $this->testDir . $fileName;
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$this->compareClasses($classFileObject, $classFilePath);
		return $classFileObject;
	}

	protected function compareClasses($classFileObject, $classFilePath) {
		$this->assertTrue(file_exists($classFilePath));
		$classObject = $classFileObject->getFirstClass();
		$this->assertTrue($classObject instanceof Tx_Classparser_Domain_Model_Class);
		if(!class_exists($classObject->getName())) {
			require_once($classFilePath);
		}
		$className = $classObject->getName();
		$this->assertTrue(class_exists($className), 'Class ' . $classObject->getName() . ' does not exist!');
		$ref = new ReflectionClass($className);
		$this->assertEquals(count($ref->getMethods()), count($classObject->getMethods()));
		$this->assertEquals(count($ref->getProperties()), count($classObject->getProperties()));
		$this->assertEquals(count($ref->getConstants()), count($classObject->getConstants()));
	}

}

?>
