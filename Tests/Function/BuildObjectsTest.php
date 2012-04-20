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

class  Tx_PhpParser_Tests_Function_BuildObjectsTest extends Tx_PhpParser_Tests_BaseTest {

	/**
	 * @test
	 */
	public function createSimpleClass() {
		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newClassName = 'Tx_PhpParser_Test_NewClass';
		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName, TRUE);
		$newClass->setDocComment("This is a class created\nfrom scratch");
		$newClass->setTag('author','John Doe');
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassFile.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists($newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}

	/**
	 * @test
	 */
	public function createSimpleNamespacedClass() {
		$nameSpaceName = 'Test\\MyNamespace';
		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newNamespace = new Tx_PhpParser_Domain_Model_Namespace($nameSpaceName, TRUE);
		$newClassName = 'Tx_PhpParser_Test_NewNamespacedClass';
		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName, TRUE);
		$newClass->setDocComment("This is a class created\nfrom scratch");
		$newClass->setTag('author','John Doe');
		$newClass->setNamespaceName($nameSpaceName);
		$newNamespace->addClass($newClass);
		$newClassFileObject->addNamespace($newNamespace);
		$newClassFilePath = $this->testDir . 'NewNamespacedClassFile.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists('Test\\MyNamespace\\' . $newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}



	/**
	 * @test
	 */
	function addMethodFromTemplateToNewClass() {
		$templateClassFileObject = $this->parser->parseFile(t3lib_extmgm::extPath('php_parser') . 'Resources/Private/Templates/MethodTemplates.php');
		$getPropertyMethod = $templateClassFileObject->getFirstClass()->getMethod('getPropertyName');

		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newClassName = 'Tx_PhpParser_Test_NewClassWithTemplateMethod';
		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName, TRUE);
		$newClass->addMethod($getPropertyMethod);
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . $newClassName . '.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists($newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}
}