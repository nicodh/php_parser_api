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

abstract class Tx_PhpParser_Tests_BaseTest extends Tx_Extbase_Tests_Unit_BaseTestCase{

	/**
	 * @var string
	 */
	protected $testDir = '';

	/**
	 * @var Tx_PhpParser_Service_Parser
	 */
	protected $parser;

	/**
	 * @var Tx_PhpParser_Service_Printer
	 */
	protected $printer;

	public function setUp(){
		$this->parser = t3lib_div::makeInstance('Tx_PhpParser_Service_Parser');
		$this->printer = t3lib_div::makeInstance('Tx_PhpParser_Service_Printer');
		//vfsStream::setup('testDir');
		//$this->testDir = vfsStream::url('testDir').'/';
		$this->testDir = t3lib_extmgm::extPath('php_parser') . 'Tests/Fixtures/tmp/';
	}

	public function tearDown() {
		$tmpFiles = t3lib_div::getFilesInDir($this->testDir);
		foreach($tmpFiles as $tmpFile) {
			// uncomment this to have a look at the generated files
			//unlink($this->testDir . $tmpFile);
		}
	}

	protected function parseFile($fileName) {
		$classFilePath = t3lib_extmgm::extPath('php_parser') . 'Tests/Fixtures/' . $fileName;
		$classFileObject = $this->parser->parseFile($classFilePath);
		return $classFileObject;
	}

	protected function compareClasses($classFileObject, $classFilePath) {
		$this->assertTrue(file_exists($classFilePath), $classFilePath . 'not exists');
		$classObject = $classFileObject->getFirstClass();
		$this->assertTrue($classObject instanceof Tx_PhpParser_Domain_Model_Class);
		$className = $classObject->getName();
		if(!class_exists($className)) {
			require_once($classFilePath);
		}
		$this->assertTrue(class_exists($className), 'Class "' . $className . '" does not exist! Tried ' . $classFilePath);
		$reflectedClass = new ReflectionClass($className);
		$this->assertEquals(count($reflectedClass->getMethods()), count($classObject->getMethods()), 'Method count does not match');
		$this->assertEquals(count($reflectedClass->getProperties()), count($classObject->getProperties()));
		$this->assertEquals(count($reflectedClass->getConstants()), count($classObject->getConstants()));
		if(strlen($classObject->getNamespaceName()) > 0 ) {
			$this->assertEquals( $reflectedClass->getNamespaceName(), $classObject->getNamespaceName());
		}
		return $reflectedClass;
	}
}
