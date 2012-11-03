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

class  CloneObjectsTest extends BaseTest{

	protected $templateClass;

	protected $newClass;

	/**
	 * @test
	 */
	function clonePropertyAndAccessorsClass() {

		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newClassName = 'MyModel';
		$this->newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);

		$templateClassFileObject = $this->parseFile('ModelClass.php');
		$this->templateClass = $templateClassFileObject->getFirstClass();

		$this->renameSimplePropertyAndAccessors('property','name');

		$this->renameStorageObjectPropertyAndAccessors('children','articles');

		$newClassFileObject->addClass($this->newClass);

		$newClassFilePath = $this->testDir . 'MyModel.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");

		$this->assertTrue(file_exists($newClassFilePath));
		/*
		$reflectedClass = $this->compareClasses($classFileObject, $newClassFilePath);
		$this->assertTrue($reflectedClass->isFinal());
		$this->assertTrue($reflectedClass->getProperty('property')->isPublic());
		*/
	}

	protected function renameSimplePropertyAndAccessors($oldPropertyName, $newPropertyName) {
		$property = $this->templateClass->getProperty($oldPropertyName);
		$property->setName($newPropertyName);

		$this->newClass->addProperty($property);

		$this->newClass->addMethod($this->templateClass->getMethod('getProperty')->setName('get' . ucfirst($newPropertyName)));
		$this->newClass->addMethod($this->templateClass->getMethod('setProperty')->setName('set' . ucfirst($newPropertyName)));
	}

	protected function renameStorageObjectPropertyAndAccessors($oldPropertyName, $newPropertyName) {
		$property = $this->templateClass->getProperty($oldPropertyName);
		$property->setName($newPropertyName);

		$this->newClass->addProperty($property);

		$this->newClass->addMethod($this->templateClass->getMethod('getChildren')->setName('get' . ucfirst($newPropertyName)));
		$this->newClass->addMethod($this->templateClass->getMethod('setChildren')->setName('set' . ucfirst($newPropertyName)));
		$this->newClass->addMethod($this->templateClass->getMethod('addChild')->setName('add' . ucfirst($newPropertyName)));
		$this->newClass->addMethod($this->templateClass->getMethod('removeChild')->setName('remove' . ucfirst($newPropertyName)));
	}


}
