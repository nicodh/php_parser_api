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
	require_once('../BaseTest.php');
}

class  ModifyObjectsTest extends BaseTest{

	/**
	 * @test
	 */
	function changeClassModifier() {
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$classObject = $classFileObject->getFirstClass();
		$classObject->setName('Tx_PhpParser_Tests_ClassWithChangedModifiers');
		$this->assertTrue($classObject->isAbstract());
		$classObject->removeModifier('abstract');
		$this->assertFalse($classObject->isAbstract());
		$classObject->addModifier('final');
		$this->assertTrue($classObject->isFinal());
		$this->assertTrue($classObject->getProperty('property')->isProtected());
		$classObject->getProperty('property')->setModifier('public');
		$this->assertTrue($classObject->getProperty('property')->isPublic());
		$newClassFilePath = $this->testDir . 'SimplePropertyWithChangedModifiers.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertTrue($reflectedClass->isFinal());
		$this->assertTrue($reflectedClass->getProperty('property')->isPublic());
	}

	/**
	 * @test
	 * @expectedException \TYPO3\ParserApi\Exception\SyntaxErrorException
	 */
	function addStaticModifierToClassThrowsException() {
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$classObject = $classFileObject->getFirstClass();
		$classObject->addModifier('static');
	}

	/**
	 * @test
	 * @expectedException \TYPO3\ParserApi\Exception\SyntaxErrorException
	 */
	function addPublicModifierToClassThrowsException() {
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$classObject = $classFileObject->getFirstClass();
		$classObject->addModifier('public');
	}

	/**
	 * @test
	 * @expectedException \TYPO3\ParserApi\Exception\SyntaxErrorException
	 */
	function addingAbstractModifierToFinalClassThrowsException() {
		$classObject = $this->parseFile('SimpleProperty.php')->getFirstClass();
		$this->assertTrue($classObject->isAbstract());
		$classObject->setModifier('final');
	}

	/**
	 * @test
	 *
	 * @expectedRuntimeException PHPParser_Error
	 * @expectedException \TYPO3\ParserApi\Exception\SyntaxErrorException
	 */
	function addingMultipleAccessModifiersThrowsException() {
		$classObject = $this->parseFile('SimpleProperty.php')->getFirstClass();
		$this->assertTrue($classObject->getProperty('property')->isProtected());
		$classObject->getProperty('property')->addModifier('public');
	}

	/**
	 * @test
	 *
	 */
	function removeAllModifiersFromClass() {
		$newName = 'ClassWithoutModifiers';
		$classFileObject = $this->parseFile('SimplePropertyWithGetterAndSetter.php');
		$classFileObject->getFirstClass()->setName('Tx_PhpParser_Tests_ClassWithRemovedModifiers');
		$classFileObject->getFirstClass()->removeAllModifiers();
		$newClassFilePath = $this->testDir . $newName . '.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertFalse($reflectedClass->isAbstract());
	}

	/**
	 * @test
	 *
	 */
	function renameClassTest() {
		$newName = 'Tx_PhpParser_Tests_NewName';
		$classFileObject = $this->parseFile('SimpleProperty.php');
		$classFileObject->getFirstClass()->setName($newName);
		$newClassFilePath = $this->testDir . 'RenamedClass.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertEquals($reflectedClass->getName(), $newName);
	}

	/**
	 * @test
	 *
	 */
	function renameClassMethodTest() {
		$newFileName = 'ClassWithRenamedMethod';
		$classFileObject = $this->parseFile('SimplePropertyWithGetterAndSetter.php');
		$classFileObject->getFirstClass()->getMethod('getProperty')->setName('getNewName');
		$newClassFilePath = $this->testDir . $newFileName . '.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertTrue($reflectedClass->hasMethod('getNewName'));
	}


	/**
	 * @test
	 */
	function renameMethodParameterAndUpdateMethodBody(){
		$classFileObject = $this->parseFile('ClassMethodWithParameterToRename.php');
		$oldBodyStmts = $classFileObject->getFirstClass()->getMethod('doSomething')->getBodyStmts();
		$oldParameterName = 'param1';
		$newParameterName = 'newName';
		$newBodyStmts = $this->parser->replaceNodeProperty(
			$oldBodyStmts,
			array(
				$oldParameterName => $newParameterName
			)
		);
		$classFileObject->getFirstClass()->getMethod('doSomething')->getParameterByPosition(0)->setName('newName');
		$classFileObject->getFirstClass()->getMethod('doSomething')->setBodyStmts($newBodyStmts);
		$newClassFilePath = $this->testDir . 'ClassWithRenamedParameter.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($classFileObject) . "\n?>");
		$this->compareClasses($classFileObject, $newClassFilePath);
		require_once($newClassFilePath);
		$resultingClass = new \Tx_PhpParser_Test_ClassMethodWithParameterToRename();
		$this->assertEquals('foo',$resultingClass->doSomething('foo', FALSE));
		$this->assertEquals('FOO',$resultingClass->doSomething('foo', TRUE));
	}
}
