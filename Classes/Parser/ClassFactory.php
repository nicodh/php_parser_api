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
 * @package  PhpParserApi
 * @author Nico de Haen
 */

class Tx_PhpParser_Parser_ClassFactory implements Tx_PhpParser_Parser_ClassFactoryInterface{

	public function buildClassObjectFromNode(PHPParser_Node_Stmt_Class $classNode) {
		$classObject = new Tx_PhpParser_Domain_Model_Class($classNode->getName());
		$classObject->setNode($classNode);
		foreach($classNode->getImplements() as $interfaceNode) {
			$classObject->addInterfaceName(Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($interfaceNode), FALSE);
		}
		$classObject->setParentClassName(Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($classNode->getExtends()), FALSE);
		$classObject->setModifiers($classNode->getType());
		$classObject->initDocComment();
		return $classObject;
	}

	public function buildClassMethodObjectFromNode (PHPParser_Node_Stmt_ClassMethod $methodNode) {
		$methodObject = new Tx_PhpParser_Domain_Model_Class_Method($methodNode->getName());
		$this->setPropertiesFromNode($methodNode, $methodObject);
		return $methodObject;
	}

	public function buildFunctionObjectFromNode (PHPParser_Node_Stmt_Function $functionNode) {
		$functionObject = new Tx_PhpParser_Domain_Model_Function($functionNode->getName());
		$this->setPropertiesFromNode($functionNode, $functionObject);
		return $functionObject;
	}

	public function buildPropertyObjectFromNode(PHPParser_Node_Stmt_Property $propertyNode) {
		$propertyName = '';
		$propertyDefault = NULL;
		foreach($propertyNode->getProps() as $subNode) {
			if($subNode instanceof PHPParser_Node_Stmt_PropertyProperty) {
				$propertyName = $subNode->getName();
				if($subNode->getDefault()) {
					$propertyDefault = $subNode->getDefault();
				}
			}
		}
		$propertyObject = new Tx_PhpParser_Domain_Model_Class_Property($propertyName);
		$propertyObject->setModifiers($propertyNode->getType());
		$propertyObject->setNode($propertyNode);
		$propertyObject->initDocComment();
		if(NULL !== $propertyDefault) {
			$propertyObject->setValue(Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($propertyDefault), FALSE, $propertyObject->isTaggedWith('var'));
		}
		return $propertyObject;
	}

	public function buildNamespaceObjectFromNode(PHPParser_Node_Stmt_Namespace $node) {
		$nameSpaceObject = new Tx_PhpParser_Domain_Model_Namespace(Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($node->getName()));
		$nameSpaceObject->setNode($node);
		$nameSpaceObject->initDocComment();
		return $nameSpaceObject;
	}

	protected function setPropertiesFromNode(PHPParser_Node_Stmt $functionNode, $object) {
		$object->setNode($functionNode);
		if(method_exists($functionNode,'getType')) {
			$object->setModifiers($functionNode->getType());
		}
		$object->setBodyStmts($functionNode->getStmts());
		$object->initDocComment();
		$object->initializeParameters();
		return $object;
	}


}
