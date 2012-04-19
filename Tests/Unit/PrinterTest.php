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

require_once(t3lib_extmgm::extPath('php_parser') . 'Tests/BaseTest.php');

class Tx_PhpParser_Tests_Unit_PrinterTest extends Tx_PhpParser_Tests_BaseTest {


	/**
	 * @test
	 */
	public function printSimplePropertyClass() {
		$fileName = 'SimpleProperty.php';
		$classFileObject = $this->parseAndWrite($fileName);
		$this->compareClasses($classFileObject, $this->testDir . $fileName);
	}

	/**
	 * @test
	 */
	public function printSimpleClassMethodWithManyParameter() {
		$fileName = 'ClassMethodWithManyParameter.php';
		$classFileObject = $this->parseAndWrite($fileName);
		$this->compareClasses($classFileObject, $this->testDir . $fileName);
	}

	/**
	 * @test
	 */
	public function printSimpleClassMethodWithMissingParameterTypeHint() {
		$fileName = 'ClassMethodWithMissingParameterTypeHint.php';
		$classFileObject = $this->parseAndWrite($fileName);
		$reflectedClass = $this->compareClasses($classFileObject, $this->testDir . $fileName);
		$parameters = $reflectedClass->getMethod('testMethod')->getParameters();
		//$this->assertEquals($parameters[1]->getTypeHint());
	}

	/**
	 * @test
	 */
	public function printSimpleClassMethodWithMissingParameterTag() {
		$fileName = 'ClassMethodWithMissingParameterTag.php';
		$classFileObject = $this->parseAndWrite($fileName);
		$reflectedClass = $this->compareClasses($classFileObject, $this->testDir . $fileName);
		// No way to detect the typeHint with Reflection...

	}

	/**
	 * @test
	 */
	public function printSimpleNamespacedClass() {
		$fileName = 'SimpleNamespace.php';
		$classFileObject = $this->parseAndWrite($fileName,'Namespaces/');
		$this->compareClasses($classFileObject, $this->testDir . $fileName);
	}


	/**
	 * @test
	 */
	public function printSimpleNamespaceWithUseStatement() {
		$fileName = 'SimpleNamespaceWithUseStatement.php';
		$classFileObject = $this->parseAndWrite($fileName,'Namespaces/');
		$this->compareClasses($classFileObject, $this->testDir . $fileName);
	}

	/**
	 * @test
	 */
	public function printMultipleNamespacedClass() {
		$fileName = 'MultipleNamespaces.php';
		$classFileObject = $this->parseAndWrite($fileName,'Namespaces/');
		$this->compareClasses($classFileObject, $this->testDir . $fileName);
	}


	/**
	 * @test
	 */
	public function printMultipleBracedNamespacedClass() {
		$fileName = 'MultipleBracedNamespaces.php';
		$classFileObject = $this->parseAndWrite($fileName,'Namespaces/');
		$this->compareClasses($classFileObject, $this->testDir . $fileName);
	}


	protected function parseAndWrite($fileName, $subFolder = '') {
		$classFilePath = t3lib_extmgm::extPath('php_parser') . 'Tests/Fixtures/' . $subFolder . $fileName;
		$this->assertTrue(file_exists($classFilePath));
		$classFileObject = $this->parser->parseFile($classFilePath);
		$newClassFilePath = $this->testDir . $fileName;
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		return $classFileObject;
	}



}

?>