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
	require_once(__DIR__ . '/../../../../Framework/TYPO3.Kickstart/Resources/Private/PHP/Sho_Inflect.php');
}

class  CreateObjectsFromTemplateTest extends BaseTest{

	protected $templateClass;

	protected $newClass;

	/**
	 * @var \TYPO3\ParserApi\Parser\Visitor\ReplaceVisitor
	 */
	protected $renameVisitor;

	/**
	 * @test
	 */
	function clonePropertyAndAccessorsClass() {

		$newClassFileObject = new \TYPO3\ParserApi\Domain\Model\File;
		$newClassName = 'MyModel';
		$this->newClass = new \TYPO3\ParserApi\Domain\Model\ClassObject($newClassName);
		$templateClassFileObject = $this->parseFile('ModelClass.php');
		$this->templateClass = $templateClassFileObject->getFirstClass();

		$this->addSimplePropertyAndAccessors('property','name', 'string');

		$this->addSimplePropertyAndAccessors('property','required', 'boolean');

		$this->addStorageObjectPropertyAndAccessors('children','articles', '\\DUMMY\\Dummy\\Domain\\Model\\Child');

		$newClassFileObject->addClass($this->newClass);

		$newClassFilePath = $this->testDir . $newClassName . '.php';
		file_put_contents($newClassFilePath,"<?php\n\n" . $this->printer->renderFileObject($newClassFileObject) . "\n?>");

		$this->assertTrue(file_exists($newClassFilePath));
	}

	protected function addSimplePropertyAndAccessors($oldPropertyName, $newPropertyName, $vartype) {

		$property = $this->templateClass->getProperty($oldPropertyName);
		$property->setName($newPropertyName);
		$property->setTag('var', $vartype . ' ' . $newPropertyName);

		$getMethod = $this->templateClass->getMethod('get' . ucfirst($oldPropertyName));
		$this->updateMethod($getMethod, array($oldPropertyName => $newPropertyName));
		$getMethod->setName('get' . ucfirst($newPropertyName));

		$setMethod = $this->templateClass->getMethod('setProperty');
		$this->updateMethod($setMethod, array($oldPropertyName => $newPropertyName));
		$setMethod->setName('set' . ucfirst($newPropertyName));
		$setMethod->setTag('param', $vartype . ' $' . $newPropertyName);

		$this->newClass->addProperty($property);
		$this->newClass->addMethod($getMethod);
		$this->newClass->addMethod($setMethod);
	}

	protected function addStorageObjectPropertyAndAccessors($oldPropertyName, $newPropertyName, $varType) {
		$property = $this->templateClass->getProperty($oldPropertyName);
		$property->setName($newPropertyName);

		$getMethod = $this->templateClass->getMethod('getChildren');
		$this->updateMethod($getMethod, array($oldPropertyName => $newPropertyName));
		$getMethod->setName('get' . ucfirst($newPropertyName));
		$getMethod->setTag('return', '\\TYPO3\\CMS\Extbase\\Persistence\\ObjectStorage<' . ucfirst(\Sho_Inflect::singularize($newPropertyName)) . '> $' . $newPropertyName);


		$setMethod = $this->templateClass->getMethod('setChildren');
		$this->updateMethod($setMethod, array($oldPropertyName => $newPropertyName));
		$setMethod->setName('set' . ucfirst($newPropertyName));
		$setMethod->setTag('param', '\\TYPO3\\CMS\Extbase\\Persistence\\ObjectStorage<' . ucfirst(\Sho_Inflect::singularize($newPropertyName)) . '> $' . $newPropertyName);


		$addMethod = $this->templateClass->getMethod('addChild');
		$this->updateMethod($addMethod, array($oldPropertyName => $newPropertyName));
		$addMethod->setName('add' . ucfirst($newPropertyName));
		$setMethod->setTag('param', $varType . ' $' . ucfirst(\Sho_Inflect::singularize($newPropertyName)));

		$removeMethod = $this->templateClass->getMethod('removeChild');
		$this->updateMethod($removeMethod, array($oldPropertyName => $newPropertyName));
		$removeMethod->setName('remove' . ucfirst($newPropertyName));


		$this->newClass->addProperty($property);
		$this->newClass->addMethod($getMethod);
		$this->newClass->addMethod($setMethod);

	}

	protected function updateMethod($method, $replacements) {
		$method->setNode(
			current(
				$this->parser->replaceNodeProperty(
					array($method->getNode()),
					$replacements
				)
			)
		);
		return $method;
	}


}
