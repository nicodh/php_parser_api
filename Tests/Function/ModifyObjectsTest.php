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

require_once(t3lib_extmgm::extPath('php_parser') . 'Tests/BaseTest.php');

class  Tx_PhpParser_Tests_Function_ModifyObjectsTest extends Tx_PhpParser_Tests_BaseTest{

	/**
	 * @test
	 */
	function changeClassModifier() {
		$classObject = $this->parseFile('SimpleProperty.php')->getFirstClass();
		$this->assertTrue($classObject->isAbstract());
		$classObject->addModifier('static');
		$this->assertTrue($classObject->isStatic());
		$this->assertTrue($classObject->getProperty('test')->isPrivate());
	}

	/**
	 * @test
	 *
	 */
	function renameClassTest() {
		$newName = 'Tx_PhpParser_Tests_NewName';
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$classFileObject->getFirstClass()->setName($newName);
		$newClassFilePath = $this->testDir . $newName . '.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertEquals($reflectedClass->getName(), $newName);
	}

	/**
	 * @test
	 *
	 */
	function renameClassMethodTest() {
		$newFileName = 'Tx_PhpParser_Tests_CopyAndRenameClassMethodTest';
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$classFileObject->getFirstClass()->getMethod('getProperty')->setName('getNewName');
		$newClassFilePath = $this->testDir . $newFileName . '.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertTrue($reflectedClass->hasMethod('getNewName'));
	}


	/**
	 * @test
	 *
	 * @expectedRuntimeException PHPParser_Error
	 * @expectedException Tx_PhpParser_Exception_SyntaxErrorException
	 */
	function addingMultipleAccessModifiersThrowsException() {
		$classObject = $this->parseFile('SimpleProperty.php')->getFirstClass();
		$this->assertTrue($classObject->getProperty('test')->isPrivate());
		$classObject->getProperty('test')->addModifier('public');
	}
}
