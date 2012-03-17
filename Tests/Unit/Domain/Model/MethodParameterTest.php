<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 
 *  All rights reserved
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
 * Test case for class Tx_Classparser_Domain_Model_MethodParameter.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Class Parser
 *
 */
class Tx_Classparser_Domain_Model_MethodParameterTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Classparser_Domain_Model_MethodParameter
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Classparser_Domain_Model_MethodParameter();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getVarTypeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setVarTypeForStringSetsVarType() { 
		$this->fixture->setVarType('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getVarType()
		);
	}
	
	/**
	 * @test
	 */
	public function getTypeHintReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTypeHintForStringSetsTypeHint() { 
		$this->fixture->setTypeHint('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTypeHint()
		);
	}
	
	/**
	 * @test
	 */
	public function getDefaultValueReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDefaultValueForStringSetsDefaultValue() { 
		$this->fixture->setDefaultValue('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDefaultValue()
		);
	}
	
	/**
	 * @test
	 */
	public function getPositionReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getPosition()
		);
	}

	/**
	 * @test
	 */
	public function setPositionForIntegerSetsPosition() { 
		$this->fixture->setPosition(12);

		$this->assertSame(
			12,
			$this->fixture->getPosition()
		);
	}
	
	/**
	 * @test
	 */
	public function getOptionalReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getOptional()
		);
	}

	/**
	 * @test
	 */
	public function setOptionalForBooleanSetsOptional() { 
		$this->fixture->setOptional(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getOptional()
		);
	}
	
	/**
	 * @test
	 */
	public function getPassedByReferenceReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getPassedByReference()
		);
	}

	/**
	 * @test
	 */
	public function setPassedByReferenceForBooleanSetsPassedByReference() { 
		$this->fixture->setPassedByReference(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getPassedByReference()
		);
	}
	
}
?>