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

class Tx_PhpParser_Tests_Unit_ParserTest extends Tx_PhpParser_Tests_BaseTest {

	/**
	 * @var Tx_PhpParser_Service_Parser
	 */
	protected $parser;

	/**
	 * @test
	 */
	function parseSimpleProperty() {
		$this->parser->setTraverser(new Tx_PhpParser_Parser_Traverser);
		$classFileObject = $this->parseFile('SimpleProperty.php');
		t3lib_utility_Debug::debugInPopUpWindow($classFileObject);
		$this->assertEquals(count($classFileObject->getFirstClass()->getMethods()), 2);
		$this->assertEquals(count($classFileObject->getFirstClass()->getProperties()), 2);
		$this->assertEquals($classFileObject->getFirstClass()->getProperty('property')->getModifierNames(), array('protected'));
	}

	/**
	 * @test
	 */
	function parseSimpleNonBracedNamespace() {
		$classFileObject = $this->parseFile('Namespaces/SimpleNamespace.php');
		$this->assertEquals('Test\\Model',$classFileObject->getFirstClass()->getNamespaceName());
	}

	/**
	 * @test
	 */
	function parseClassMethodWithManyParameter() {
		$classFileObject = $this->parseFile('ClassMethodWithManyParameter.php');
		$parameters = $classFileObject->getFirstClass()->getMethod('testMethod')->getParameters();
		$this->assertEquals( 6, count($parameters));
		$this->assertEquals($parameters[3]->getName(), 'booleanParam');
		$this->assertEquals($parameters[3]->getVarType(), 'boolean');
		$this->assertEquals($parameters[5]->getTypeHint(), 'Tx_PhpParser_Parser_Utility_NodeConverter');
	}


}

?>
