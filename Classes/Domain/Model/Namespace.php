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
 * @package php_parser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PhpParser_Domain_Model_Namespace extends Tx_PhpParser_Domain_Model_AbstractObject{

	protected $constants;

	/**
	 * @var array with nodes
	 */
	protected $aliasDeclarations;

	/**
	 * @var array
	 */
	protected $preIncludes = array();

	protected $postIncludes = array();

	/**
	 * @var array Tx_PhpParser_Domain_Model_Class
	 */
	protected $classes = array();

	protected $functions;

	public function __construct(PHPParser_Node_Stmt_Namespace $node) {
		$this->node = $node;
		$this->name = Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($node->__get('name'));
		$this->initDocComment();
	}


	public function getFirstClass() {
		if(count($this->classes) > 0) {
			reset($this->classes);
			return current($this->classes);
		} else {
			return NULL;
		}

	}

	/**
	 * @param Tx_PhpParser_Domain_Model_Class $class
	 */
	public function addClass(Tx_PhpParser_Domain_Model_Class $class) {
		$this->classes[] = $class;
	}

	public function setClasses($classes) {
		$this->classes = $classes;
	}

	public function getClasses() {
		return $this->classes;
	}

	public function setConstants($constants) {
		$this->constants = $constants;
	}

	public function getConstants() {
		return $this->constants;
	}

	public function setFunctions($functions) {
		$this->functions = $functions;
	}

	public function getFunctions() {
		return $this->functions;
	}

	public function addAliasDeclaration($aliasDeclaration) {
		$this->aliasDeclarations[] = $aliasDeclaration;
	}

	public function getAliasDeclarations() {
		return $this->aliasDeclarations;
	}

	public function getAliasNames() {
		//TODO
	}

	/**
	 * @param array $preIncludes
	 */
	public function setPreIncludes($preIncludes) {
		$this->preIncludes = $preIncludes;
	}

	/**
	 * @return array
	 */
	public function getPreIncludes() {
		return $this->preIncludes;
	}

	public function addPreInclude($preInclude) {
		$this->preIncludes[] = $preInclude;
	}

	public function setPostIncludes($postIncludes) {
		$this->postIncludes = $postIncludes;
	}

	public function getPostIncludes() {
		return $this->postIncludes;
	}


	public function addPostInclude($postInclude) {
		$this->postIncludes[] = $postInclude;
	}

}