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

require_once(t3lib_extmgm::extPath('php_parser_api') . 'Tests/BaseTest.php');

class  Tx_PhpParser_Tests_Function_BuildObjectsTest extends Tx_PhpParser_Tests_BaseTest {

	/**
	 * @test
	 */
	public function createSimpleClass() {
		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newClassName = 'Tx_PhpParser_Test_NewClass';
		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName);
		$newClass->setDescription("This is a class created\nfrom scratch")
			->setTag('author','John Doe');
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassFromScratch.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists($newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}

	/**
	 * @test
	 */
	public function createClassWithProperties() {
		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newClassName = 'Tx_PhpParser_Test_NewClassWithProperties';


		$newProperty1 = new Tx_PhpParser_Domain_Model_Class_Property('property1');
		$newProperty1->setDescription('example property2')
			->setValue('example')
			->setTag('var', 'string $property1');

		$newProperty2 = new Tx_PhpParser_Domain_Model_Class_Property('property2');
		$newProperty2->setDescription('example property2')
			->setValue(array('test'=>123))
			->setTag('var', 'array $property2')
			->setModifier('private');

		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName);
		$newClass->setDescription("This is a class created\nfrom scratch")
			->setTag('author','John Doe')
			->setProperty($newProperty1)
			->setProperty($newProperty2);

		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassWithProperties.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}

	/**
	 * @test
	 */
	public function createClassWithConstants() {
		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newClassName = 'Tx_PhpParser_Test_NewClassWithConstants';

		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName);
		$newClass->setConstant('CONST1','FOO')
			->setConstant('CONST2','BAR')
			->setConstant('CONST3',0.432)
			->setConstant('CONST4',123);
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassWithConstants.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$reflecedClass = $this->compareClasses($newClassFileObject, $newClassFilePath);
		$this->assertEquals($reflecedClass->getConstant('CONST1'),'FOO');
		$this->assertEquals($reflecedClass->getConstant('CONST2'),'BAR');
		$this->assertEquals($reflecedClass->getConstant('CONST3'),0.432);
		$this->assertEquals($reflecedClass->getConstant('CONST4'),123);
	}

	/**
	 * @test
	 */
	public function createSimpleNamespacedClass() {
		$nameSpaceName = 'Test\\MyNamespace';
		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newNamespace = new Tx_PhpParser_Domain_Model_Namespace($nameSpaceName);
		$newClassName = 'Tx_PhpParser_Test_NewNamespacedClass';
		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName);
		$newClass->setDescription("This is a class created\nfrom scratch")
			->setTag('author','John Doe')
			->setNamespaceName($nameSpaceName);
		$newNamespace->addClass($newClass);
		$newClassFileObject->addNamespace($newNamespace);
		$newClassFilePath = $this->testDir . 'NewNamespacedClass.php';
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
		$templateClassFileObject = $this->parser->parseFile(t3lib_extmgm::extPath('php_parser_api') . 'Resources/Private/Templates/MethodTemplates.php');
		$getPropertyMethod = $templateClassFileObject->getFirstClass()->getMethod('getPropertyName');

		$newClassFileObject = new Tx_PhpParser_Domain_Model_File;
		$newClassName = 'Tx_PhpParser_Test_NewClassWithTemplateMethod';
		$newClass = new Tx_PhpParser_Domain_Model_Class($newClassName);
		$newClass->addMethod($getPropertyMethod);
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassWithTemplateMethod.php';
		t3lib_div::writeFile($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists($newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}
}