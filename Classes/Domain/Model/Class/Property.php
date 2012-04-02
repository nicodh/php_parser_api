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
 *ClassSchema
 * @package classparser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Classparser_Domain_Model_Class_Property extends Tx_Classparser_Domain_Model_AbstractObject {

	/**
	 * if there is a domain object property associated
	 * with this ClassProperty this object holds all extbase related information
	 * (like SQL, TYPO3 related stuff)
	 *
	 * @var object associatedDomainObjectProperty
	 */
	protected $associatedDomainObjectProperty = NULL;

	/**
	 * varType
	 *
	 * @var string
	 */
	protected $varType;

	/**
	 * default
	 *
	 * @var string
	 */
	protected $default;

	/**
	 * value
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * __construct
	 *
	 * @param PHPParser_Node_Stmt_Property $propertyNode
	 * @return void
	 */
	public function __construct($propertyNode = NULL) {
		if($propertyNode) {
			$this->setVarType($propertyNode->getType());
			$this->setStmts(array($propertyNode));
			foreach($propertyNode->getSubNodes() as $subNode) {
				if($subNode instanceof PHPParser_Node_Stmt_PropertyProperty) {
					$this->setName($subNode->__get('name'));
					if($subNode->__get('default')) {
						$this->setDefault(TRUE);
					}
				}
			}
		}
	}

	/**
	 * all properties that have a setter in this class and a getter in the reflection class will be set here
	 *
	 * @param Tx_Classparser_Reflection_PropertyReflection $propertyReflection
	 * @return void
	 */
	public function mapToReflectionProperty($propertyReflection) {
		if ($propertyReflection instanceof Tx_Classparser_Reflection_PropertyReflection) {

			$tags = $propertyReflection->getTagsValues(); // just to initialize the docCommentParser
			foreach ($this as $key => $value) {
				$setterMethodName = 'set' . t3lib_div::underscoredToUpperCamelCase($key);
				$getterMethodName = 'get' . t3lib_div::underscoredToUpperCamelCase($key);

				// map properties of reflection class to this class
				if (method_exists($propertyReflection, $getterMethodName) && method_exists($this, $setterMethodName) && $key != 'value') {
					$this->$setterMethodName($propertyReflection->$getterMethodName());
				}

				$isMethodName = 'is' . t3lib_div::underscoredToUpperCamelCase($key);

				// map properties of reflection class to this class
				if (method_exists($propertyReflection, $setterMethodName) && method_exists($this, $isMethodName)) {
					$this->$setterMethodName($propertyReflection->$isMethodName());
				}
			}

			// This is not yet used later on. The type is not validated, so it might be anything!!
			if (isset($this->tags['var'])) {
				$parts = preg_split('/\s/', $this->tags['var'][0], 2);
				$this->varType = $parts[0];
			}
			else {
				t3lib_div::devLog('No var type set for property $' . $this->name . ' in class ' . $propertyReflection->getDeclaringClass()->name, 'extension_builder');
			}

			if (empty($this->tags)) {
				// strange behaviour in php ReflectionProperty->getDescription(). A backslash is added to the description
				$this->description = str_replace("\n/", '', $this->description);
				$this->description = trim($this->description);
				$this->setTag('var', 'mixed // please define a var type here');
			}
		}
	}

	/**
	 * getVarType
	 *
	 * @return string $type.
	 */
	public function getVarType() {
		return $this->varType;
	}

	/**
	 * Sets $type.
	 *
	 * @param string $type
	 * @return
	 */
	public function setVarType($varType) {
		$this->tags['var'] = array($varType);
		$this->varType = $varType;
	}

	/**
	 * Returns $associatedDomainObjectProperty.
	 *
	 * @return object associatedDomainObjectProperty
	 */
	public function getAssociatedDomainObjectProperty() {
		return $this->associatedDomainObjectProperty;
	}

	/**
	 * Sets $associatedDomainObjectProperty.
	 *
	 * @param object $associatedDomainObjectProperty
	 * @return
	 */
	public function setAssociatedDomainObjectProperty($associatedDomainObjectProperty) {
		$this->associatedDomainObjectProperty = $associatedDomainObjectProperty;
		if (empty($this->description)) {
			$this->description = $associatedDomainObjectProperty->getDescription();
			if (empty($this->description)) {
				$this->description = $this->name;
			}
		}
	}

	/**
	 * hasAssociatedDomainObjectProperty
	 *
	 * @return
	 */
	public function hasAssociatedDomainObjectProperty() {
		return !is_null($this->associatedDomainObjectProperty);
	}

	/**
	 * isDefault
	 *
	 * @return boolean
	 */
	public function isDefault() {
		return $this->default;
	}

	/**
	 * setDefault
	 *
	 * @param boolean $default
	 * @return
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * getDefault
	 *
	 * @return boolean
	 */
	public function getDefault() {
		return $this->default;
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
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * This is a helper function to be called in fluid if conditions
	 * it returns TRUE even if the default value is 0 or an empty string or "FALSE"
	 *
	 * @return bool
	 */
	public function getHasDefaultValue() {
		if(isset($this->default) && $this->default !== NULL) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * This is a helper function to be called in fluid if conditions
	 * it returns TRUE even if the value is 0 or an empty string or "FALSE"
	 *
	 * @return bool
	 */
	public function getHasValue() {
		if(isset($this->value) && $this->value !== NULL) {
			return TRUE;
		}
		return FALSE;
	}

}
?>