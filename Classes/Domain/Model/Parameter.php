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
 * @author Nico de Haen
 * @package PhpParserApi
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PhpParser_Domain_Model_Parameter extends Tx_PhpParser_Domain_Model_AbstractObject {


	/**
	 * varType
	 *
	 * @var string
	 */
	protected $varType;

	/**
	 * typeHint
	 *
	 * @var string
	 */
	protected $typeHint = NULL;

	/**
	 * defaultValue
	 *
	 * @var array
	 */
	protected $default;

	/**
	 * position
	 *
	 * @var integer
	 */
	protected $position;

	/**
	 * optional
	 *
	 * @var boolean
	 */
	protected $optional = FALSE;

	/**
	 * passedByReference
	 *
	 * @var boolean
	 */
	protected $passedByReference = FALSE;

	/**
	 * __construct
	 *
	 * @param PHPParser_Node_Param $parameterNode
	 * @return unknown_type
	 */
	public function __construct($parameterNode = NULL) {
		if($parameterNode) {
			$this->setName($parameterNode->__get('name'), FALSE);
			$this->setNode($parameterNode);
			$this->setType($parameterNode->getType(), FALSE);
			$this->setTypeHint($parameterNode->__get('type'), FALSE);
			$this->setDefault($parameterNode->__get('default'), FALSE);
			$this->setPassedByReference($parameterNode->__get('byRef'), FALSE);
		} else {
			$this->setNode(new PHPParser_Node_Param(''));
		}
	}

	/**
	 * Returns $type.
	 *
	 * @return
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * Sets $type.
	 *
	 * @param string $type
	 * @return
	 */
	public function setType($type, $updateNodeType = TRUE) {
		$this->type = $type;
		if($updateNodeType) {
			$this->node->setType($type);
		}
	}

	/**
	 * getPosition
	 *
	 * @return int $position
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * setter for position
	 *
	 * @param int $position
	 * @return void
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * getter for default
	 *
	 * @return mixed
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * setter for default
	 *
	 * @param $default
	 * @return void
	 */
	public function setDefault($default, $updateNodeDefault = TRUE) {
		$this->default = $default;
		if($updateNodeDefault) {
			$this->node->setDefault(Tx_PhpParser_Parser_Utility_NodeConverter::getNodeFromvalue($default));
		}
	}

	/**
	 * isOptional
	 *
	 * @return boolean
	 */
	public function isOptional() {
		return $this->optional;
	}

	/**
	 * setOptional
	 *
	 * @param $optional
	 * @return void
	 */
	public function setOptional($optional) {
		$this->optional = $optional;
	}

	/**
	 * isPassedByReference
	 *
	 * @return boolean
	 */
	public function isPassedByReference() {
		return $this->passedByReference;
	}

	public function setPassedByReference( $passedByReference, $updateNodeByRef = TRUE ) {
		$this->passedByReference = $passedByReference;
		if($updateNodeByRef) {
			$this->node->setByRef($passedByReference);
		}
	}

	/**
	 * getTypeHint
	 *
	 * @return
	 */
	public function getTypeHint() {
		return $this->typeHint;
	}

	/**
	 * Sets $typeHint.
	 *
	 * @param string $typeHint
	 * @return
	 */
	public function setTypeHint($typeHint, $updateNodeTypeHint = TRUE ) {
		if(!is_string($typeHint) && !empty($typeHint)) {
			$typeHint = Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($typeHint);
		}
		$this->typeHint = $typeHint;
		if($updateNodeTypeHint) {
			$this->node->setType(Tx_PhpParser_Parser_NodeFactory::buildNodeFromName($typeHint));
		}
	}

	/**
	 * @param string $varType
	 */
	public function setVarType($varType, $updateNodeType = TRUE) {
		if($updateNodeType) {
			$this->setTypeHint(Tx_PhpParser_Parser_Utility_NodeConverter::getTypeHintFromVarType($varType),TRUE);
		}
		$this->varType = $varType;
	}

	/**
	 * @return string
	 */
	public function getVarType() {
		return $this->varType;
	}

}
?>
