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
 *  the Free Software Foundation; either version 3 of the License, or
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
 *
 *
 * @package classparser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Classparser_Domain_Model_AbstractObject extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * array
	 *
	 * @var string
	 */
	protected $modifiers;

	/**
	 * array
	 *
	 * @var string
	 */
	protected $tags;

	/**
	 * docComment
	 *
	 * @var string
	 */
	protected $docComment;

	/**
	 * precedingBlock
	 *
	 * @var string
	 */
	protected $precedingBlock;

	/**
	 * Returns the name
	 *
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the modifiers
	 *
	 * @return string $modifiers
	 */
	public function getModifiers() {
		return $this->modifiers;
	}

	/**
	 * Sets the modifiers
	 *
	 * @param string $modifiers
	 * @return void
	 */
	public function setModifiers($modifiers) {
		$this->modifiers = $modifiers;
	}

	/**
	 * Returns the tags
	 *
	 * @return string $tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
	 * Sets the tags
	 *
	 * @param string $tags
	 * @return void
	 */
	public function setTags($tags) {
		$this->tags = $tags;
	}

	/**
	 * Returns the docComment
	 *
	 * @return string $docComment
	 */
	public function getDocComment() {
		return $this->docComment;
	}

	/**
	 * Sets the docComment
	 *
	 * @param string $docComment
	 * @return void
	 */
	public function setDocComment($docComment) {
		$this->docComment = $docComment;
	}

	/**
	 * Returns the precedingBlock
	 *
	 * @return string $precedingBlock
	 */
	public function getPrecedingBlock() {
		return $this->precedingBlock;
	}

	/**
	 * Sets the precedingBlock
	 *
	 * @param string $precedingBlock
	 * @return void
	 */
	public function setPrecedingBlock($precedingBlock) {
		$this->precedingBlock = $precedingBlock;
	}

}
?>