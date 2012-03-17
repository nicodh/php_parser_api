<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen <mail@ndh-websolutions.de>
 *  			
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
 * Test case for class Tx_Classparser_Domain_Model_AbstractObject.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Class Parser
 *
 * @author Nico de Haen <mail@ndh-websolutions.de>
 */
class Tx_Classparser_Domain_Model_AbstractObjectTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Classparser_Domain_Model_AbstractObject
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Classparser_Domain_Model_AbstractObject();
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
	public function getModifiersReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setModifiersForStringSetsModifiers() { 
		$this->fixture->setModifiers('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getModifiers()
		);
	}
	
	/**
	 * @test
	 */
	public function getTagsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTagsForStringSetsTags() { 
		$this->fixture->setTags('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTags()
		);
	}
	
	/**
	 * @test
	 */
	public function getDocCommentReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDocCommentForStringSetsDocComment() { 
		$this->fixture->setDocComment('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDocComment()
		);
	}
	
	/**
	 * @test
	 */
	public function getPrecedingBlockReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPrecedingBlockForStringSetsPrecedingBlock() { 
		$this->fixture->setPrecedingBlock('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPrecedingBlock()
		);
	}
	
}
?>