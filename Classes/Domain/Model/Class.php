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
 * TODO: enable declares
 *
 * @package php_parser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PhpParser_Domain_Model_Class extends Tx_PhpParser_Domain_Model_Container {


	/**
	 * interfaces
	 *
	 * @var  array of string
	 */
	protected $interfaceNames;


	/**
	 * methods
	 *
	 * @var array
	 */
	protected $methods = array();


	/**
	 * parentClassName
	 *
	 * @var  string parentClassName
	 */
	protected $parentClassName = '';
	
	/**
	 * properties
	 *
	 * @var array
	 */
	protected $properties = array();


	/**
	 * constructor of this class
	 *
	 * @param boolean $createNode
	 * @param string $name
	 * @return unknown_type
	 */
	public function __construct($name, $createNode = TRUE) {
		$this->name = $name;
		if($createNode) {
			$this->node = Tx_PhpParser_Parser_NodeFactory::buildClassNode($name);
			$this->initDocComment();
		}
	}


	/**
	 * methodExists
	 *
	 * @param $methodName
	 * @return boolean
	 */
	public function methodExists($methodName) {
		if (!is_array($this->methods)) {
			return FALSE;
		}
		$methodNames = array_keys($this->methods);
		if (is_array($methodNames) && in_array($methodName, $methodNames)) {
			return TRUE;
		}
		else return FALSE;
	}

	/**
	 * Setter for methods
	 *
	 * @param array $methods (Tx_PhpParser_Domain_Model_Class_Method[])
	 * @return void
	 */
	public function setMethods(array $methods) {
		$this->methods = $methods;
		return $this;
	}

	/**
	 * Setter for a single method (allows to override an existing method)
	 *
	 * @param Tx_PhpParser_Domain_Model_Class_Method $method
	 * @return void
	 */
	public function setMethod(Tx_PhpParser_Domain_Model_Class_Method $classMethod) {
		$this->methods[$classMethod->getName()] = $classMethod;
		return $this;
	}

	/**
	 * Getter for methods
	 *
	 * @return Tx_PhpParser_Domain_Model_Class_Method[]
	 */
	public function getMethods() {
		return $this->methods;
	}

	/**
	 * Getter for method
	 *
	 * @param $methodName
	 * @return Tx_PhpParser_Domain_Model_Class_Method
	 */
	public function getMethod($methodName) {
		if ($this->methodExists($methodName)) {
			return $this->methods[$methodName];
		}
		else return NULL;
	}

	/**
	 * Add a method
	 *
	 * @param Tx_PhpParser_Domain_Model_Class_Method $classMethod
	 * @return void
	 */
	public function addMethod($classMethod) {
		if (!$this->methodExists($classMethod->getName())) {
			$this->methods[$classMethod->getName()] = $classMethod;
		}
		return $this;
	}

	/**
	 * removes a method
	 *
	 * @param string $methodName
	 * @return boolean TRUE (if successfull removed)
	 */
	public function removeMethod($methodName) {
		if ($this->methodExists($methodName)) {
			unset($this->methods[$methodName]);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * rename a method
	 *
	 * @param string $oldName
	 * @param string $newName
	 * @return boolean success
	 */
	public function renameMethod($oldName, $newName) {
		if ($this->methodExists($oldName)) {
			$method = $this->methods[$oldName];
			$method->setName($newName);
			$this->methods[$newName] = $method;
			$this->removeMethod($oldName);
			return TRUE;
		}
		else return FALSE;
	}

	/**
	 * returns all methods starting with "get"
	 *
	 * @return Tx_PhpParser_Domain_Model_Class_Method[]
	 */
	public function getGetters() {
		$getterMethods = array();
		foreach ($this->getMethods() as $method) {
			$methodName = $method->getName();
			if (strpos($methodName, 'get') === 0) {
				$propertyName = strtolower(substr($methodName, 3));
				if ($this->propertyExists($propertyName)) {
					$getterMethods[$propertyName] = $method;
				}
			}
		}

		return $getterMethods;
	}

	/**
	 * returnes all methods starting with "set"
	 *
	 * @return Tx_PhpParser_Domain_Model_Class_Method[]
	 */
	public function getSetters() {
		$setterMethods = array();
		foreach ($this->getMethods() as $method) {
			$methodName = $method->getName();
			if (strpos($methodName, 'set') === 0) {
				$propertyName = strtolower(substr($methodName, 3));
				if ($this->propertyExists($propertyName)) {
					$setterMethods[$propertyName] = $method;
				}
			}
		}
		return $setterMethods;
	}

	/**
	 * Getter for property
	 *
	 * @param string $propertyName the name of the property
	 * @return Tx_PhpParser_Reflection_PropertyReflection
	 */
	public function getProperty($propertyName) {
		if ($this->propertyExists($propertyName)) {
			return $this->properties[$propertyName];
		}
		else return NULL;
	}

	/**
	 * Setter for properties
	 *
	 * @param select $properties properties
	 * @return void
	 */
	public function setProperties($properties) {
		$this->properties = $properties;
		return $this;
	}

	/**
	 * Getter for properties
	 *
	 * @return Tx_PhpParser_Domain_Model_Class_Property[]
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * removes a property
	 *
	 * @param string $propertyName
	 * @return boolean TRUE (if successfull removed)
	 */
	public function removeProperty($propertyName) {
		if ($this->propertyExists($propertyName)) {
			unset($this->properties[$propertyName]);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * rename a property
	 *
	 * @param string $oldName
	 * @param string $newName
	 * @return boolean success
	 */
	public function renameProperty($oldName, $newName) {
		if ($this->propertyExists($oldName)) {
			$property = $this->properties[$oldName];
			$property->setName($newName);
			$this->properties[$newName] = $property;
			$this->removeProperty($oldName);
			return TRUE;
		}
		else return FALSE;
	}

	/**
	 * propertyExists
	 *
	 * @param string $propertyName
	 * @return boolean
	 */
	public function propertyExists($propertyName) {
		if (!is_array($this->properties)) {
			return FALSE;
		}
		if (in_array($propertyName, $this->getPropertyNames())) {
			return TRUE;
		}
		else return FALSE;
	}

	/**
	 * add a property (returns TRUE if successfull added)
	 *
	 * @param Tx_PhpParser_Domain_Model_Class_Property
	 * @return boolean success
	 */
	public function addProperty(Tx_PhpParser_Domain_Model_Class_Property $classProperty) {
		if (!$this->propertyExists($classProperty->getName())) {
			$this->propertyNames[] = $classProperty->getName();
			$this->properties[$classProperty->getName()] = $classProperty;
		}
		else return FALSE;
	}

	/**
	 * returns all property names
	 *
	 * @return array
	 */
	public function getPropertyNames() {
		return array_keys($this->properties);
	}

	/**
	 * Setter for property
	 *
	 * @param Tx_PhpParser_Domain_Model_Class_Property
	 * @return boolean success
	 */
	public function setProperty($classProperty) {
		$this->properties[$classProperty->getName()] = $classProperty;
		return $this;
	}


	/**
	 * Adds a interface node, based on a string
	 *
	 * @param string $interfaceName
	 */
	public function addInterfaceName($interfaceName, $updateNode = TRUE) {
		if(!in_array($interfaceName, $this->interfaceNames)) {
			$this->interfaceNames[] = $interfaceName;
			if($updateNode) {
				$interfaceNodes = $this->node->__get('implements');
				$interfaceNodes[] = Tx_PhpParser_Parser_NodeFactory::buildNodeFromName($interfaceName);
				$this->node->__set('implements',$interfaceNodes);
			}
		}
		return $this;
	}


	/**
	 * Getter for interfaces
	 *
	 * @return array interfaces
	 */
	public function getInterfaceNames() {
		return $this->interfaceNames;
	}

	/**
	 * @param string $interfaceName
	 * @return bool
	 */
	public function hasInterface($interfaceName) {
		return in_array($interfaceName, $this->interfaceNames);
	}

	/**
	 * @param $interfaceNameToRemove
	 */
	public function removeInterface( $interfaceNameToRemove) {
		$interfaceNames = array();
		$interfaceNodes = array();
		foreach($this->interfaceNames as $interfaceName) {
			if($interfaceName != $interfaceNameToRemove){
				$interfaceNames[] = $interfaceName;
				$interfaceNodes[] = Tx_PhpParser_Parser_NodeFactory::buildNodeFromName($interfaceName);
			}
		}
		$this->node->__set('implements', $interfaceNodes);
	}

	/**
	 * Setter for parentClassName
	 *
	 * @param string $parentClass
	 * @return void
	 */
	public function setParentClassName($parentClassName, $updateNode = TRUE) {
		$this->parentClassName = $parentClassName;
		if($updateNode) {
			$this->node->__set('extends',Tx_PhpParser_Parser_NodeFactory::buildNodeFromName($parentClassName));
		}
		return $this;
	}

	/**
	 * Getter for parentClass
	 *
	 * @return string parentClass
	 */
	public function getParentClassName() {
		return $this->parentClassName;
	}

	public function removeParentClassName() {
		$this->parentClass = '';
		$this->node->__set('extends',NULL);
	}

	public function updateStmts() {
		$stmts = array();

		$properties = array();
		$methods = array();

		foreach($this->methods as $method) {
			$methods[$method->getName()] = $method->getNode();
		}

		foreach($this->properties as $property) {
			$properties[$property->getName()] = $property->getNode();
		}

        //ksort($properties);
        //ksort($methods);

		foreach ($this->constants as $name => $value) {
			$stmts[] = Tx_PhpParser_Parser_NodeFactory::buildConstantNode($name, $value);
		}

	    foreach ($properties as $property) {
	         $stmts[] = $property;
	    }

	    foreach ($methods as $method) {
            $stmts[] = $method;
        }

	    $this->node->stmts = $stmts;
	}

	/**
	 * @param string $modifierName
	 * @return Tx_PhpParser_Domain_Model_AbstractObject (for fluid interface)
	 * @throws Tx_PhpParser_Exception_SyntaxErrorException
	 */
	public function addModifier($modifierName) {
		if(!in_array($modifierName, array('final','abstract'))) {
			throw new Tx_PhpParser_Exception_SyntaxErrorException($modifierName . ' modifier can\'t be applied to classes');
		} else {
			return parent::addModifier($modifierName);
		}
	}

	/**
	 * @param string $modifierName
	 * @return Tx_PhpParser_Domain_Model_AbstractObject (for fluid interface)
	 * @throws Tx_PhpParser_Exception_SyntaxErrorException
	 */
	public function setModifier($modifierName) {
		if(!in_array($modifierName, array('final','abstract'))) {
			throw new Tx_PhpParser_Exception_SyntaxErrorException($modifierName . ' modifier can\'t be applied to classes');
		} else {
			return parent::setModifier($modifierName);
		}
	}

}
?>
