<?php
namespace TYPO3\ParserApi\Domain\Model\ClassObject;
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
class Property extends \TYPO3\ParserApi\Domain\Model\AbstractObject {


	/**
	 * value
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * @var mixed
	 */
	protected $default = NULL;


	/**
	 * @var string
	 */
	protected $varType = '';

	/**
	 * __construct
	 *
	 * @param string name
	 * @return void
	 */
	public function __construct($name, $createNode = TRUE) {
		$this->name = $name;
		if($createNode) {
			$this->node = \TYPO3\ParserApi\Parser\NodeFactory::buildPropertyNode($name);
			$this->initDocComment();
		}
	}

	/**
	 * getValue
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * Setter for value
	 *
	 * @param mixed
	 * @return
	 */
	public function setValue($value, $updateNode = TRUE, $updateVarType = TRUE) {
		$this->value = $value;
		if($updateNode) {
			$props = $this->node->getProps();
			$valueNode = \TYPO3\ParserApi\Parser\NodeFactory::buildNodeFromValue($value);
			$props[0]->setDefault($valueNode);
			$this->node->setProps($props);
		}
		if($updateVarType) {
			$varType = \TYPO3\ParserApi\Parser\Utility\NodeConverter::getVarTypeFromValue($value);
			if(!empty($varType)) {
				$this->setVarType($varType);
			}
		}
		return $this;
	}

	/**
	 * Setter for name
	 *
	 * @param string $name name
	 * @return void
	 */
	public function setName($name, $updateNodeName = TRUE) {
		$this->name = $name;
		if($updateNodeName) {

			$props =  $this->node->getProps();
			$props[0]->setName($name);
			$this->node->setProps($props);
		}
		return $this;
	}

	/**
	 * @param string $varType
	 */
	public function setVarType($varType) {
		$this->varType = $varType;
		if(isset($this->tags['var']) && is_array($this->tags['var'])) {
			$this->tags['var'] = $this->tags['var'][0];
		}
		if(!isset($this->tags['var']) || strpos(strtolower($varType),strtolower($this->tags['var'])) === FALSE) {
			// we use strpos since there might a a var annotation like "array $propertyName" or "array" or "Array"
			$this->tags['var'] = $varType;
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function getVarType() {
		return $this->varType;
	}

	/**
	 * @param mixed $default
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * @return mixed
	 */
	public function getDefault() {
		return $this->default;
	}

}
?>
