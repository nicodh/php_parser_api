<?php
namespace TYPO3\ParserApi\Parser;
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

class ClassFactory implements ClassFactoryInterface{

	public function buildClassObjectFromNode(\PHPParser_Node_Stmt_Class $classNode) {
		$classObject = new \TYPO3\ParserApi\Domain\Model\ClassObject($classNode->getName());
		$classObject->setNode($classNode);
		foreach($classNode->getImplements() as $interfaceNode) {
			$classObject->addInterfaceName(Utility\NodeConverter::getValueFromNode($interfaceNode), FALSE);
		}
		$classObject->setParentClassName(Utility\NodeConverter::getValueFromNode($classNode->getExtends()), FALSE);
		$classObject->setModifiers($classNode->getType());
		$classObject->initDocComment();
		return $classObject;
	}

	public function buildClassMethodObjectFromNode (\PHPParser_Node_Stmt_ClassMethod $methodNode) {
		$methodObject = new \TYPO3\ParserApi\Domain\Model\ClassObject\Method($methodNode->getName());
		$this->setPropertiesFromNode($methodNode, $methodObject);
		return $methodObject;
	}

	public function buildFunctionObjectFromNode (\PHPParser_Node_Stmt_Function $functionNode) {
		$functionObject = new\TYPO3\ParserApi\Domain\Model\FunctionObject($functionNode->getName());
		$this->setPropertiesFromNode($functionNode, $functionObject);
		return $functionObject;
	}

	public function buildPropertyObjectFromNode(\PHPParser_Node_Stmt_Property $propertyNode) {
		$propertyName = '';
		$propertyDefault = NULL;
		foreach($propertyNode->getProps() as $subNode) {
			if($subNode instanceof \PHPParser_Node_Stmt_PropertyProperty) {
				$propertyName = $subNode->getName();
				if($subNode->getDefault()) {
					$propertyDefault = $subNode->getDefault();
				}
			}
		}
		$propertyObject = new \TYPO3\ParserApi\Domain\Model\ClassObject\Property($propertyName);
		$propertyObject->setModifiers($propertyNode->getType());
		$propertyObject->setNode($propertyNode);
		$propertyObject->initDocComment();
		if(NULL !== $propertyDefault) {
			$propertyObject->setValue(\TYPO3\ParserApi\Parser\Utility\NodeConverter::getValueFromNode($propertyDefault), FALSE, $propertyObject->isTaggedWith('var'));
		}
		return $propertyObject;
	}

	public function buildNamespaceObjectFromNode(\PHPParser_Node_Stmt_Namespace $node) {
		$nameSpaceObject = new \TYPO3\ParserApi\Domain\Model\NamespaceObject(\TYPO3\ParserApi\Parser\Utility\NodeConverter::getValueFromNode($node->getName()));
		$nameSpaceObject->setNode($node);
		$nameSpaceObject->initDocComment();
		return $nameSpaceObject;
	}

	protected function setPropertiesFromNode(\PHPParser_Node_Stmt $functionNode, $object) {
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
