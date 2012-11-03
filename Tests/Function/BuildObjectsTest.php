<?php
namespace TYPO3\ParserApi\Tests;
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
if(!class_exists('\\TYPO3\\ParserApi\\Tests\\BaseTest')) {
	require_once(__DIR__ . '/../BaseTest.php');
}
//require_once('../BaseTest.php');

class  BuildObjectsTest extends BaseTest {

	/**
	 * @test
	 */
	public function createSimpleClass() {
		$this->assertTrue(is_writable($this->testDir), 'Directory not writable: ' . $this->testDir . '. Can\'t compare rendered files');
		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newClassName = 'NewClass';
		$newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);
		$newClass->setDescription("This is a class created from scratch")
			->setTag('author','John Doe');
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassFromScratch.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists($newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}

	/**
	 * @test
	 */
	public function createClassWithProperties() {
		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newClassName = 'NewClassWithProperties';


		$newProperty1 = new \TYPO3\ParserApi\Domain\Model\ClassObject\Property('property1');
		$newProperty1->setDescription('example property2')
			->setValue('example')
			->setTag('var', 'string $property1');

		$newProperty2 = new \TYPO3\ParserApi\Domain\Model\ClassObject\Property('property2');
		$newProperty2->setDescription('example property2')
			->setValue(array('test'=>123))
			->setTag('var', 'array $property2')
			->setModifier('private');

		$newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);
		$newClass->setDescription("This is a class created\nfrom scratch")
			->setTag('author','John Doe')
			->setProperty($newProperty1)
			->setProperty($newProperty2);

		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassWithProperties.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}

	/**
	 * @test
	 */
	public function createClassWithConstants() {
		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newClassName = 'NewClassWithConstants';

		$newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);
		$newClass->setConstant('CONST1','FOO')
			->setConstant('CONST2','BAR')
			->setConstant('CONST3',0.432)
			->setConstant('CONST4',123);
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassWithConstants.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
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
		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newNamespace = new \TYPO3\ParserApi\Domain\Model\NamespaceObject($nameSpaceName);
		$newClassName = 'NewNamespacedClass';
		$newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);
		$newClass->setDescription("This is a class created\nfrom scratch")
			->setTag('author','John Doe')
			->setNamespaceName($nameSpaceName);
		$newNamespace->addClass($newClass);
		$newClassFileObject->addNamespace($newNamespace);
		$newClassFilePath = $this->testDir . 'NewNamespacedClass.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists('Test\\MyNamespace\\' . $newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}



	/**
	 * @test
	 */
	function addMethodFromTemplateToNewClass() {
		$templateClassFileObject = $this->parser->parseFile($this->packagePath. 'Resources/Private/Templates/MethodTemplates.php');
		$getPropertyMethod = $templateClassFileObject->getFirstClass()->getMethod('getPropertyName');

		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newClassName = 'NewClassWithTemplateMethod';
		$newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);
		$newClass->addMethod($getPropertyMethod);
		$newClassFileObject->addClass($newClass);
		$newClassFilePath = $this->testDir . 'NewClassWithTemplateMethod.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");
		$this->assertTrue(file_exists($newClassFilePath));
		require_once($newClassFilePath);
		$this->assertTrue(class_exists($newClassName));
		$this->compareClasses($newClassFileObject, $newClassFilePath);
	}
}