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


class Tx_Classparser_Tests_ParserTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * set to true to see an overview of the parsed class objects in the backend
	 */
	protected $debugMode = TRUE;


	function setUp(){
		$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
	}



	/**
	 * Parse a basic class from a file
	 * @test
	 */
	public function ParseBasicClass() {
		$basicClass = $this->parseClass(t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/BasicClass.php');
		t3lib_utility_Debug::debugInPopUpWindow($basicClass);
		$this->assertEquals($basicClass->getName(),'Tx_Classparser_Tests_BasicClass');
	}

	/**
	 * Parse a complex class from a file
	 * @test
	 */
	public function ParseComplexClass() {
		$classObject = $this->parseClass(t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/ComplexClass.php');
		t3lib_utility_Debug::debugInPopUpWindow($classObject);
		$getters = $classObject->getGetters();
		$this->assertEquals(1, count($getters));
		$firstGetter = array_pop($getters);
		$this->assertEquals('getName', $firstGetter->getName());

		/**
		$defaultOrderingsPropertyValue = $classObject->getProperty('defaultOrderings')->getValue();
		$this->assertEquals(
			$defaultOrderingsPropertyValue,
			"array(\n\t\t'title' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING,\n\t\t'subtitle' =>  Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING,\n\t\t'test' => 'test;',\n\t)",
			'Failed to parse multiline property definition:'
		);
		$params2 = $classObject->getMethod('methodWithVariousParameter')->getParameters();
		$this->assertEquals(
			count($params2),
			4,
			'Wrong parameter count in parsed "methodWithVariousParameter"'
		);
		$this->assertEquals(
			$params2[3]->getName(),
			'param4',
			'Last parameter name was not correctly parsed'
		);
		$this->assertEquals(
			$params2[3]->getDefaultValue(),
			array('test' => array(1, 2, 3))
		);

		*/
	}


	/**
	 * Parse a complex class from a file
	 * @test
	 */
	public function ParseAnotherComplexClass() {
		require_once(t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/AnotherComplexClass.php');
		$classObject = $this->parseClass(t3lib_extmgm::extPath('classparser') . 'Tests/Fixtures/AnotherComplexClass.php');

		/**  here we could include some more tests
		$p = $classObject->getMethod('methodWithStrangePrecedingBlock')->getPrecedingBlock();
		$a = $classObject->getAppendedBlock();
		 */
	}

	/**
	 * Parse a big class from a file
	 * @test
	 */
	public function Parse_t3lib_div() {
		$this->parseClass(PATH_t3lib . 'class.t3lib_div.php');
	}

	/**
	 *
	 * @param $className
	 * @return unknown_type
	 */
	protected function parseClass($fileName) {
		if(!file_exists($fileName)) {
			die('File not found!');
		}
		$fileHandler = fopen($fileName, 'r');
		$code = fread($fileHandler, filesize($fileName));
		$parser = $this->objectManager->get('Tx_Classparser_Service_Parser');
		$parser->injectTraverser($this->objectManager->get('PHPParser_NodeTraverser'));
		$classObject = $parser->parse($code);
		return $classObject;


		/**
		$this->assertTrue($classObject instanceof Tx_ClassParser_Domain_Model_Class);
		$classReflection = new Tx_ClassParser_Reflection_ClassReflection($className);
		$this->ParserFindsAllConstants($classObject, $classReflection);
		$this->ParserFindsAllMethods($classObject, $classReflection);
		$this->ParserFindsAllProperties($classObject, $classReflection);
		 * */
		return $classObject;
	}

	/**
	 * compares the number of methods found by parsing with those retrieved from the reflection class
	 * @param Tx_ClassParser_Domain_Model_Class $classObject
	 * @param Tx_ClassParser_Reflection_ClassReflection $classReflection
	 * @return void
	 */
	public function ParserFindsAllConstants($classObject, $classReflection) {
		$reflectionConstantCount = count($classReflection->getConstants());
		if ($classReflection->getParentClass()) {
			$reflectionConstantCount -= count($classReflection->getParentClass()->getConstants());
		}
		$classObjectConstantCount = count($classObject->getConstants());
		$this->assertEquals($reflectionConstantCount, $classObjectConstantCount, 'Not all Constants were found: ' . $classObject->getName() . serialize($classReflection->getConstants()));
	}

	/**
	 * compares the number of methods found by parsing with those retrieved from the reflection class
	 * @param Tx_ClassParser_Domain_Model_Class $classObject
	 * @param Tx_ClassParser_Reflection_ClassReflection $classReflection
	 * @return void
	 */
	public function ParserFindsAllMethods($classObject, $classReflection) {
		$reflectionMethodCount = count($classReflection->getNotInheritedMethods());
		$classObjectMethodCount = count($classObject->getMethods());
		$this->assertEquals($classObjectMethodCount, $reflectionMethodCount, 'Not all Methods were found!');
	}

	/**
	 * compares the number of properties found by parsing with those retrieved from the reflection class
	 * @param Tx_ClassParser_Domain_Model_Class $classObject
	 * @param Tx_ClassParser_Reflection_ClassReflection $classReflection
	 * @return void
	 */
	public function ParserFindsAllProperties($classObject, $classReflection) {
		$reflectionPropertyCount = count($classReflection->getNotInheritedProperties());
		$classObjectPropertCount = count($classObject->getProperties());
		$this->assertEquals($classObjectPropertCount, $reflectionPropertyCount, 'Not all Properties were found!');
	}



}

?>
