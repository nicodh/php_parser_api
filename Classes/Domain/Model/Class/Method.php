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
 * @package classparser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Classparser_Domain_Model_Class_Method extends Tx_Classparser_Domain_Model_AbstractObject {

	/**
	 * defaultIndent
	 *
	 * @var string
	 */
	public $defaultIndent = "\t\t";

	/**
	 * stmts of this methods body
	 *
	 * @var array
	 */
	protected $bodyStmts;

	/**
	 * parameters
	 *
	 * @var array
	 */
	protected $parameters;

	/**
	 * __construct
	 *
	 * @param PHPParser_Node_Stmt_ClassMethod $methodNode
	 * @return
	 */
	public function __construct($methodNode = NULL) {
		if($methodNode) {
			$this->setName($methodNode->__get('name'), FALSE);
			$this->setNode($methodNode);
			$this->addModifier($methodNode->getType());
			$this->setDocComment($methodNode->getDocComment(), 'FALSE');
			$this->setBodyStmts($methodNode->getSubnodes());
			if($methodNode->__get('params')) {
				$position = 0;
				foreach($methodNode->__get('params') as $param) {
					$parameter = new Tx_Classparser_Domain_Model_Class_MethodParameter($param);
					$parameter->setPosition($position);
					$this->addParameter($parameter);
				}
			}
		}
	}

	/**
	 * Setter for body
	 *
	 * @param array $stmts
	 * @return void
	 */
	public function setBodyStmts($stmts) {
		$this->bodyStmts = $stmts;
	}

	/**
	 * Getter for body
	 *
	 * @return array body
	 */
	public function getBodyStmts() {
		return $this->bodyStmts;
	}

	/**
	 * getter for parameters
	 *
	 * @return array parameters
	 */
	public function getParameters() {
		return $this->parameters;
	}

	/**
	 * getter for parameter names
	 *
	 * @return array parameter names
	 */
	public function getParameterNames() {
		$parameterNames = array();
		if(is_array($this->parameters)) {
			foreach ($this->parameters as $parameter) {
				$parameterNames[] = $parameter->getName();
			}
		}
		return $parameterNames;
	}

	/**
	 * adder for parameters
	 *
	 * @param array $parameters of type Tx_Classparser_Domain_Model_Class_MethodParameter
	 * @return void
	 */
	public function setParameters($parameters) {
		// TODO: setParameters in node
		foreach ($parameters as $parameter) {
			$methodParameter = new Tx_Classparser_Domain_Model_Class_MethodParameter($parameter->getName(), $parameter);
			$this->parameters[$methodParameter->getPosition()] = $methodParameter;
		}
	}

	/**
	 * setter for a single parameter
	 *
	 * @param array $parameter
	 * @return void
	 */
	public function addParameter($parameter) {
		$this->parameters[$parameter->getPosition()] = $parameter;
	}

	/**
	 * replace a single parameter, depending on position
	 *
	 * @param array $parameter
	 * @return void
	 */
	public function replaceParameter($parameter) {
		$this->parameters[$parameter->getPosition()] = $parameter;
	}

	/**
	 * removes a parameter
	 *
	 * @param $parameterName
	 * @param $parameterSortingIndex
	 * @return boolean TRUE (if successfull removed)
	 */
	public function removeParameter($parameterName, $parameterPosition) {
		//TODO: Not yet tested
		if (isset($this->parameter[$parameterPosition]) && $this->parameter[$parameterPosition]->getName() == $parameterName) {
			unset($this->parameter[$parameterPosition]);
			return TRUE;
		}
		else return FALSE;
	}

	/**
	 * renameParameter
	 *
	 * @param $parameterName
	 * @param $parameterSortingIndex
	 * @return boolean TRUE (if successfull removed)
	 */
	public function renameParameter($oldName, $newName, $parameterPosition) {
		//TODO: Not yet tested
		if (isset($this->parameter[$parameterPosition])) {
			$parameter = $this->parameter[$parameterPosition];
			if ($parameter->getName() == $oldName) {
				$parameter->setName($newName);
				$this->parameter[$parameterPosition] = $parameter;
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * TODO: THe sorting of tags/annotations should be controlled
	 *
	 * @return
	 */
	public function getAnnotations() {
		$annotations = parent::getAnnotations();
		if (is_array($this->parameters) && count($this->parameters) > 0 && !$this->isTaggedWith('param')) {
			$paramTags = array();
			foreach ($this->parameters as $parameter) {
				$paramTags[] = 'param ' . strtolower($parameter->getVarType()) . '$' . $parameter->getName();
			}
			$annotations = array_merge($paramTags, $annotations);
		}
		if (!$this->isTaggedWith('return')) {
			$annotations[] = 'return';
		}
		return $annotations;
	}

}
?>