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
 * Test case for class Tx_Classparser_Domain_Model_Class.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Class Parser
 *
 */
class Tx_Classparser_Domain_Model_ClassTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Classparser_Domain_Model_Class
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Classparser_Domain_Model_Class();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getFileNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFileNameForStringSetsFileName() { 
		$this->fixture->setFileName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFileName()
		);
	}
	
	/**
	 * @test
	 */
	public function getConstantsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setConstantsForStringSetsConstants() { 
		$this->fixture->setConstants('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getConstants()
		);
	}
	
	/**
	 * @test
	 */
	public function getPropertiesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPropertiesForStringSetsProperties() { 
		$this->fixture->setProperties('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getProperties()
		);
	}
	
	/**
	 * @test
	 */
	public function getMethodsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setMethodsForStringSetsMethods() { 
		$this->fixture->setMethods('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getMethods()
		);
	}
	
}
?>