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

abstract class BaseTest extends \TYPO3\FLOW3\Tests\UnitTestCase{

	/**
	 * @var string
	 */
	protected $testDir = '';

	protected $fixturesPath = '';

	/**
	 * @var string
	 */
	protected $packagePath = '';

	/**
	 * @var \TYPO3\ParserApi\Service\Parser
	 */
	protected $parser;

	/**
	 * @var \TYPO3\ParserApi\Service\Printer
	 */
	protected $printer;

	/**
	 * @var \TYPO3\FLOW3\Reflection\ReflectionService
	 *
	 * @FLOW3\Inject
	 */
	protected $reflectionService;

	public function setUp(){
		$path = dirname(__FILE__);
		$pathParts = explode('Tests',$path);
		$this->packagePath = $pathParts[0];
		$this->fixturesPath = $this->packagePath . 'Tests/Fixtures/';
		require_once($this->packagePath.'Resources/Private/PHP/PHP-Parser/lib/bootstrap.php');
		$this->parser = new \TYPO3\ParserApi\Service\Parser();
		$this->printer = new \TYPO3\ParserApi\Service\Printer();
		\vfsStreamWrapper::register();
		\vfsStreamWrapper::setRoot(new \vfsStreamDirectory('testDirectory'));
		$this->testDir = \vfsStream::url('testDirectory') . '/';
		/**
		// uncomment for inspecting the generated files
		$this->testDir = $this->packagePath . 'Tests/Fixtures/tmp/';
		if(!is_dir($this->testDir)) {
			mkdir($this->testDir);
		}
		 * */
	}

	public function tearDown() {
		$tmpFiles = \TYPO3\FLOW3\Utility\Files::readDirectoryRecursively($this->testDir);
		foreach($tmpFiles as $tmpFile) {
			//unlink($this->testDir . $tmpFile);
		}
		//rmdir($this->testDir);
	}

	protected function parseFile($fileName) {
		$classFilePath = $this->packagePath . 'Tests/Fixtures/' . $fileName;
		$classFileObject = $this->parser->parseFile($classFilePath);
		return $classFileObject;
	}

	protected function compareClasses($classFileObject, $classFilePath) {
		$this->assertTrue(file_exists($classFilePath), $classFilePath . 'not exists');
		$classObject = $classFileObject->getFirstClass();
		$this->assertTrue($classObject instanceof \TYPO3\ParserApi\Domain\Model\ClassObject);
		$className = $classObject->getName();
		if(!class_exists($className)) {
			require_once($classFilePath);
		}
		$this->assertTrue(class_exists($className), 'Class "' . $className . '" does not exist! Tried ' . $classFilePath);
		$reflectedClass = new \ReflectionClass($className);
		$this->assertEquals(count($reflectedClass->getMethods()), count($classObject->getMethods()), 'Method count does not match');
		$this->assertEquals(count($reflectedClass->getProperties()), count($classObject->getProperties()));
		$this->assertEquals(count($reflectedClass->getConstants()), count($classObject->getConstants()));
		if(strlen($classObject->getNamespaceName()) > 0 ) {
			$this->assertEquals( $reflectedClass->getNamespaceName(), $classObject->getNamespaceName());
		}
		return $reflectedClass;
	}
}
