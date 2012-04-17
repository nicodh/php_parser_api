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
class Tx_Classparser_Domain_Model_Class extends Tx_Classparser_Domain_Model_AbstractObject {

	/**
	 * propertyNames - deprecated -> use this->getPropertyNames() instead
	 *
	 * @var array
	 */
	protected $propertyNames = array();

	/**
	 * interfaces
	 *
	 * @var  array of PHPParser_Node_Name objects
	 */
	protected $interfaces;


	/**
	 * parentClass
	 *
	 * @var  PHPParser_Node_Name parentClass
	 */
	protected $parentClass = NULL;

	/**
	 * constants
	 *
	 * @var string
	 */
	protected $constants;

	/**
	 * properties
	 *
	 * @var string
	 */
	protected $properties = array();

	/**
	 * methods
	 *
	 * @var string
	 */
	protected $methods = array();

	/**
	 * constructor of this class
	 *
	 * @param PHPParser_Node_Stmt_Class $classNode
	 * @return unknown_type
	 */
	public function __construct(PHPParser_Node_Stmt_Class $classNode) {
		$this->name = $classNode->__get('name');
		$this->setDocComment($classNode->getDocComment(), FALSE);
		$this->setInterfaces($classNode->__get('implements'));
		$this->setParentClass($classNode->__get('extends'));
		$this->setModifiers($classNode->__get('type'));
		$this->node = $classNode;
	}

	/**
	 * Setter for a single constant
	 *
	 * @param string $constant constant
	 * @return void
	 */
	public function setConstant($constantName, $constantValue, $node) {
		$this->constants[$constantName] = array('name' => $constantName, 'value' => $constantValue, 'node' => $node);
	}

	/**
	 * Setter for a single constant
	 *
	 * @param string $constant constant
	 * @return void
	 */
	public function setConstantNode($constantNode) {
		foreach($constantNode->__get('consts') as $const) {
			$this->setConstant($const->__get('name'), $const->__get('value')->__get('value'), $constantNode);
		}
	}

	/**
	 * Setter for constants
	 *
	 * @param string $constants constants
	 * @return void
	 */
	public function setConstants($constants) {
		$this->constants = $constants;
	}

	/**
	 * Getter for constants
	 *
	 * @return string constants
	 */
	public function getConstants() {
		return $this->constants;
	}

	/**
	 * Getter for a single constant
	 *
	 * @param $constantName
	 * @return mixed constant value
	 */
	public function getConstant($constantName) {
		if (isset($this->constants[$constantName])) {
			return $this->constants[$constantName]['value'];
		}
		else return NULL;
	}

	/**
	 * removes a constant
	 *
	 * @param string $constantName
	 * @return boolean TRUE (if successfull removed)
	 */
	public function removeConstant($constantName) {
		if (isset($this->constants[$constantName])) {
			unset($this->constants[$constantName]);
			return TRUE;
		}
		return FALSE;
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
	 * @param array $methods (Tx_Classparser_Domain_Model_Class_Method[])
	 * @return void
	 */
	public function setMethods(array $methods) {
		$this->methods = $methods;
	}

	/**
	 * Setter for a single method (allows to override an existing method)
	 *
	 * @param Tx_Classparser_Domain_Model_Class_Method $method
	 * @return void
	 */
	public function setMethod(Tx_Classparser_Domain_Model_Class_Method $classMethod) {
		$this->methods[$classMethod->getName()] = $classMethod;
	}

	/**
	 * Getter for methods
	 *
	 * @return Tx_Classparser_Domain_Model_Class_Method[]
	 */
	public function getMethods() {
		return $this->methods;
	}

	/**
	 * Getter for method
	 *
	 * @param $methodName
	 * @return Tx_Classparser_Domain_Model_Class_Method
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
	 * @param Tx_Classparser_Domain_Model_Class_Method $classMethod
	 * @return void
	 */
	public function addMethod($classMethod) {
		if (!$this->methodExists($classMethod->getName())) {
			$this->methods[$classMethod->getName()] = $classMethod;
		}
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
	 * @return Tx_Classparser_Domain_Model_Class_Method[]
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
	 * @return Tx_Classparser_Domain_Model_Class_Method[]
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
	 * @return Tx_Classparser_Reflection_PropertyReflection
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
	}

	/**
	 * Getter for properties
	 *
	 * @return Tx_Classparser_Domain_Model_Class_Property[]
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
	 * @param Tx_Classparser_Domain_Model_Class_Property
	 * @return boolean success
	 */
	public function addProperty(Tx_Classparser_Domain_Model_Class_Property $classProperty) {
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
	 * @param Tx_Classparser_Domain_Model_Class_Property
	 * @return boolean success
	 */
	public function setProperty($classProperty) {
		$this->properties[$classProperty->getName()] = $classProperty;
	}

	/**
	 * Setter for interfaces
	 *
	 * @param array of PHPParser_Node_Name objects
	 * @return void
	 */
	public function setInterfaces($interfaces) {
		$this->interfaces = $interfaces;
	}

	/**
	 * Adds a interface node, based on a string
	 *
	 * @param string $interfaceName
	 */
	public function addInterfaceName($interfaceName) {
		$this->interfaces[] = Tx_Classparser_Parser_Utility_NodeFactory::getNodeFromName($interfaceName);
		$this->node->__set('implements',$this->interfaces);
	}


	/**
	 * Getter for interfaces
	 *
	 * @return array interfaces
	 */
	public function getInterfaces() {
		return $this->interfaces;
	}

	/**
	 * Getter for interfaceNames
	 *
	 * @return array interfaceNames
	 */
	public function getInterfaceNames() {
		$interfaceNames = array();
		foreach($this->interfaces as $interface) {
			$interfaceNames[] = implode('',$interface->__get('parts'));
		}
		return $interfaceNames;
	}

	/**
	 * @param string $interfaceName
	 * @return bool
	 */
	public function hasInterface($interfaceName) {
		$interfaceNames = $this->getInterfaceNames();
		return in_array($interfaceName, $interfaceNames);
	}

	public function removeInterface( $interfaceName) {
		$interfaces = array();
		foreach($this->interfaces as $interface) {
			if($interfaceName != implode('',$interface->__get('parts'))){
				$interfaces[] = $interface;
			}
		}
		$this->interfaces = $interfaces;
		$this->node->__set('implements', $this->interfaces);
	}

	/**
	 * Setter for parentClass
	 *
	 * @param PHPParser_Node_Name $parentClass
	 * @return void
	 */
	public function setParentClass($parentClass) {
		$this->parentClass = $parentClass;
	}

	/**
	 * Setter for parentClassName
	 *
	 * @param string $parentClass
	 * @return void
	 */
	public function setParentClassName($parentClass) {
		$this->node->__get('extends')->__set('parts',array($parentClass));
	}

	/**
	 * Getter for parentClass
	 *
	 * @return string parentClass
	 */
	public function getParentClassName() {
		return implode('', $this->parentClass->__get('parts'));
	}

	public function removeParentClass() {
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

		foreach ($this->constants as $constantName => $constant) {
			$stmts[] = $constant['node'];
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
	 * getInfo
	 *
	 * @return
	 */
	public function getInfo() {
		$infoArray = array();
		$infoArray['className'] = $this->getName();
		$infoArray['fileName'] = $this->getFileName();

		$methodArray = array();
		foreach ($this->getMethods() as $method) {
			$methodArray[$method->getName()] = array(
				'parameter' => $method->getParameters()
			);
			//'body'=>$method->getBody()
		}
		$infoArray['Methods'] = $methodArray;
		//$infoArray['Inherited Methods'] = count($this->getInheritedMethods());
		//$infoArray['Not inherited Methods'] = count($this->getNotInheritedMethods());
		$infoArray['Properties'] = $this->getProperties();
		//$infoArray['Inherited Properties'] = count($this->getInheritedProperties());
		//$infoArray['Not inherited Properties'] = count($this->getNotInheritedProperties());
		$infoArray['Constants'] = $this->getConstants();
		$infoArray['Modifiers'] = $this->getModifierNames();
		$infoArray['Tags'] = $this->tags;
		//$infoArray['Methods'] = count($this->getMethods());
		$infoArray['node'] = $this->getNode();
		return $infoArray;
	}

}
?>