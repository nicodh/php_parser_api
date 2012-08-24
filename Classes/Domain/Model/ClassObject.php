<?php
namespace TYPO3\ParserApi\Domain\Model;
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
 * @property string parentClass
 * @author Nico de Haen
 * @package PhpParserApi
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ClassObject extends Container {


	/**
	 * interfaces
	 *
	 * @var  string[]
	 */
	protected $interfaceNames = array();


	/**
	 * methods
	 *
	 * @var ClassObject\Method[]
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
	 * @var ClassObject\Property[]
	 */
	protected $properties = array();

	/**
	 * @var array
	 */
	protected $propertyNames = array();


	/**
	 * constructor of this class
	 *
	 * @param string $name
	 * @param boolean $createNode
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function __construct($name, $createNode = TRUE) {
		$this->name = $name;
		if ($createNode) {
			$this->node = \TYPO3\ParserApi\Parser\NodeFactory::buildClassNode($name);
			// $this->initDocComment();
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
		} else {
			return FALSE;
		}
	}

	/**
	 * Setter for methods
	 *
	 * @param ClassObject\Method[])
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function setMethods(array $methods) {
		$this->methods = $methods;
		return $this;
	}

	/**
	 * Setter for a single method (allows to override an existing method)
	 *
	 * @param ClassObject\Method $classMethod
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function setMethod(ClassObject\Method $classMethod) {
		$this->methods[$classMethod->getName()] = $classMethod;
		return $this;
	}

	/**
	 * Getter for methods
	 *
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Method[]
	 */
	public function getMethods() {
		return $this->methods;
	}

	/**
	 * Getter for method
	 *
	 * @param $methodName
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Method
	 */
	public function getMethod($methodName) {
		if ($this->methodExists($methodName)) {
			return $this->methods[$methodName];
		} else {
			return NULL;
		}
	}

	/**
	 * Add a method
	 *
	 * @param \TYPO3\ParserApi\Domain\Model\ClassObject\Method $classMethod
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
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
		} else {
			return FALSE;
		}
	}

	/**
	 * returns all methods starting with "get"
	 *
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Method[]
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
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Method[]
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
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Property
	 */
	public function getProperty($propertyName) {
		if ($this->propertyExists($propertyName)) {
			return $this->properties[$propertyName];
		} else {
			return NULL;
		}
	}

	/**
	 * Setter for properties
	 *
	 * @param array $properties
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function setProperties($properties) {
		$this->properties = $properties;
		return $this;
	}

	/**
	 * Getter for properties
	 *
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Property[]
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
			$property = $this->getProperty($oldName);
			$property->setName($newName);
			$this->properties[$newName] = $property;
			$this->removeProperty($oldName);
			return TRUE;
		} else {
			return FALSE;
		}
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
		} else {
			return FALSE;
		}
	}

	/**
	 * add a property (returns TRUE if successfull added)
	 *
	 * @param ClassObject\Property $classProperty
	 * @return boolean success
	 */
	public function addProperty(ClassObject\Property $classProperty) {
		if (!$this->propertyExists($classProperty->getName())) {
			$this->propertyNames[] = $classProperty->getName();
			$this->properties[$classProperty->getName()] = $classProperty;
			return TRUE;
		} else {
			return FALSE;
		}
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
	 * @param ClassObject\Property
	 * @return boolean success
	 */
	public function setProperty(ClassObject\Property $classProperty) {
		$this->properties[$classProperty->getName()] = $classProperty;
		return $this;
	}

	/**
	 * @param array $interfaceNames
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function setInterfaces(array $interfaceNames) {
		$this->interfaceNames = $interfaceNames;
		$interfaceNodes = array();
		foreach ($interfaceNames as $interfaceName) {
			$interfaceNodes[] = \TYPO3\ParserApi\Parser\NodeFactory::buildNodeFromName($interfaceName);
		}
		$this->node->setImplements($interfaceNodes);
		return $this;
	}


	/**
	 * Adds a interface node, based on a string
	 *
	 * @param string $interfaceName
	 * @param bool $updateNode
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function addInterfaceName($interfaceName, $updateNode = TRUE) {
		if (!in_array($interfaceName, $this->interfaceNames)) {
			$this->interfaceNames[] = $interfaceName;
			if ($updateNode) {
				$interfaceNodes = $this->node->getImplements();
				$interfaceNodes[] = \TYPO3\ParserApi\Parser\NodeFactory::buildNodeFromName($interfaceName);
				$this->node->setImplements($interfaceNodes);
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
	public function removeInterface($interfaceNameToRemove) {
		$interfaceNames = array();
		$interfaceNodes = array();
		foreach ($this->interfaceNames as $interfaceName) {
			if ($interfaceName != $interfaceNameToRemove) {
				$interfaceNames[] = $interfaceName;
				$interfaceNodes[] = \TYPO3\ParserApi\Parser\NodeFactory::buildNodeFromName($interfaceName);
			}
		}
		$this->interfaceNames = $interfaceNames;
		$this->node->setImplements($interfaceNodes);
	}

	public function removeAllInterfaces() {
		$this->interfaceNames = array();
		$this->node->setImplements(array());
	}

	/**
	 * Setter for parentClassName
	 *
	 * @param string $parentClassName
	 * @param boolean $updateNode
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
	public function setParentClassName($parentClassName, $updateNode = TRUE) {
		$this->parentClassName = $parentClassName;
		if ($updateNode) {
			$this->node->setExtends(\TYPO3\ParserApi\Parser\NodeFactory::buildNodeFromName($parentClassName));
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

	/**
	 * removes the parent class
	 */
	public function removeParentClassName() {
		$this->parentClass = '';
		$this->node->setExtends();
	}

	/**
	 * This methods is respsible for generating a statement array in the correct
	 * order and to include all method and property nodes
	 */
	public function updateStmts() {
		$stmts = array();

		$properties = array();
		$methods = array();

		foreach ($this->methods as $method) {
			$methods[$method->getName()] = $method->getNode();
		}

		foreach ($this->properties as $property) {
			$properties[$property->getName()] = $property->getNode();
		}

		foreach ($this->constants as $name => $value) {
			$stmts[] = \TYPO3\ParserApi\Parser\NodeFactory::buildClassConstantNode($name, $value);
		}

		foreach ($properties as $property) {
			$stmts[] = $property;
		}

		foreach ($methods as $method) {
			$stmts[] = $method;
		}

		$this->node->setStmts($stmts);
	}

	/**
	 * @param string $modifierName
	 * @return \TYPO3\ParserApi\Domain\Model\AbstractObject (for fluid interface)
	 * @throws \TYPO3\ParserApi\Exception\SyntaxErrorException
	 */
	public function addModifier($modifierName) {
		if (!in_array($modifierName, array('final', 'abstract'))) {
			throw new \TYPO3\ParserApi\Exception\SyntaxErrorException($modifierName . ' modifier can\'t be applied to classes');
		} else {
			return parent::addModifier($modifierName);
		}
	}

	/**
	 * @param string $modifierName
	 * @return \TYPO3\ParserApi\Domain\Model\AbstractObject (for fluid interface)
	 * @throws \TYPO3\ParserApi\Exception\SyntaxErrorException
	 */
	public function setModifier($modifierName) {
		if (!in_array($modifierName, array('final', 'abstract'))) {
			throw new \TYPO3\ParserApi\Exception\SyntaxErrorException($modifierName . ' modifier can\'t be applied to classes');
		} else {
			return parent::setModifier($modifierName);
		}
	}

}

?>