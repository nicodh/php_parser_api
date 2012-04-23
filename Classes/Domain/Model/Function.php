<?php
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

class Tx_PhpParser_Domain_Model_Function extends Tx_PhpParser_Domain_Model_AbstractObject {

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
	 * @param PHPParser_Node $functionNode
	 * @return
	 */
	public function __construct($name) {
		$this->name = $name;
	}

	public function initializeParameters() {
		$position = 0;
		$getVarTypeFromParamTag = FALSE;
		if (isset($this->tags['param']) && is_array($this->tags['param'])){
			$paramTags = $this->tags['param'];
			if(count($paramTags) == count($this->node->__get('params'))) {
				$getVarTypeFromParamTag = TRUE;
			}
		}

		foreach($this->node->__get('params') as $param) {
			$parameter = new Tx_PhpParser_Domain_Model_Parameter($param);
			$parameter->setPosition($position);
			if(strlen($parameter->getTypeHint()) < 1 && $getVarTypeFromParamTag) {
				// if there is not type hint but a varType in the param tag, we set the varType of the parameter
				// this will result in the typeHint being set
				$paramTag = explode(' ',$paramTags[$position]);
				if($paramTag[0] !== '$' . $param->__get('name')) {
					$parameter->setVarType($paramTag[0]);
				}
			}
			$this->setParameter($parameter);
			$position++;
		}
	}

	/**
	 * Setter for body statements
	 *
	 * @param array $stmts
	 * @return void
	 */
	public function setBodyStmts($stmts) {
		$this->bodyStmts = $stmts;
		$this->node->__set('stmts',$stmts);
		return $this;
	}

	/**
	 * Getter for body statements
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
	 * @param int $position
	 */
	public function getParameterByPosition($position) {
		if(isset($this->parameters[$position])) {
			return $this->parameters[$position];
		} else {
			return NULL;
		}

	}

	/**
	 * adder for parameters
	 *
	 * @param array $parameters of type Tx_PhpParser_Domain_Model_Class_MethodParameter
	 * @return void
	 */
	public function setParameters($parameters) {
		$parameterNodes = array();
		foreach ($parameters as $parameter) {
			$methodParameter = new Tx_PhpParser_Domain_Model_Class_MethodParameter($parameter->getName(), $parameter);
			$this->parameters[$methodParameter->getPosition()] = $methodParameter;
			$parameterNodes[] = $parameter->getNode();
		}
		$this->node->__set('params',$parameterNodes);
		return $this;
	}

	/**
	 * setter for a single parameter
	 *
	 * @param array $parameter
	 * @return void
	 */
	public function setParameter($parameter) {
		$this->parameters[$parameter->getPosition()] = $parameter;
		$parameterNodes = $this->node->__get('params');
		$parameterNodes[$parameter->getPosition()] = $parameter->getNode();
		$this->node->__set('params', $parameterNodes);
		$this->updateParamTags();
		return $this;
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

	/**debug($oldName, $newName);
	 * removes a parameter
	 *
	 * @param $parameterName
	 * @param $parameterSortingIndex
	 * @return boolean TRUE (if successfull removed)
	 */
	public function removeParameter($parameterName, $parameterPosition) {
		//TODO: Not yet tested
		if (isset($this->parameters[$parameterPosition]) && $this->parameters[$parameterPosition]->getName() == $parameterName) {
			unset($this->parameters[$parameterPosition]);
			$params = $this->node->__get('params');
			unset($params[$parameterPosition]);
			$this->node->__set('params',$params);
			$this->updateParamTags();
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
		if (isset($this->parameters[$parameterPosition])) {
			$parameter = $this->parameters[$parameterPosition];
			if ($parameter->getName() == $oldName) {
				$parameter->setName($newName);
				$this->parameters[$parameterPosition] = $parameter;

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

	protected function updateParamTags() {
		$paramTags = array();
		foreach($this->parameters as $position => $parameter) {
			$varType = $parameter->getVarType();
			if(empty($varType)) {
				$varType = $parameter->getTypeHint();
			}
			if(!empty($varType)) {
				$varType .= ' ';
			}
			$paramTags[] = $varType . '$' . $parameter->getName();
		}
		$this->tags['param'] = $paramTags;
		$this->updateDocComment();
	}

}
