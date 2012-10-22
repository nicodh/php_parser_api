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

	/**
	 * @param \PHPParser_Node_Stmt_Class $classNode
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject
	 */
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

	/**
	 * @param \PHPParser_Node_Stmt_ClassMethod $methodNode
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Method
	 */
	public function buildClassMethodObjectFromNode (\PHPParser_Node_Stmt_ClassMethod $methodNode) {
		$methodObject = new \TYPO3\ParserApi\Domain\Model\ClassObject\Method($methodNode->getName());
		$this->setPropertiesFromNode($methodNode, $methodObject);
		return $methodObject;
	}

	/**
	 * @param \PHPParser_Node_Stmt_Function $functionNode
	 * @return \TYPO3\ParserApi\Domain\Model\FunctionObject
	 */
	public function buildFunctionObjectFromNode (\PHPParser_Node_Stmt_Function $functionNode) {
		$functionObject = new\TYPO3\ParserApi\Domain\Model\FunctionObject($functionNode->getName());
		$this->setPropertiesFromNode($functionNode, $functionObject);
		return $functionObject;
	}

	/**
	 * @param \PHPParser_Node_Stmt_Property $propertyNode
	 * @return \TYPO3\ParserApi\Domain\Model\ClassObject\Property
	 */
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

	/**
	 * @param \PHPParser_Node_Stmt_Namespace $nameSpaceNode
	 * @return \TYPO3\ParserApi\Domain\Model\NamespaceObject
	 */
	public function buildNamespaceObjectFromNode(\PHPParser_Node_Stmt_Namespace $nameSpaceNode) {
		$nameSpaceObject = new \TYPO3\ParserApi\Domain\Model\NamespaceObject(\TYPO3\ParserApi\Parser\Utility\NodeConverter::getValueFromNode($nameSpaceNode->getName()));
		$nameSpaceObject->setNode($nameSpaceNode);
		$nameSpaceObject->initDocComment();
		return $nameSpaceObject;
	}

	/**
	 * @param \PHPParser_Node_Stmt $node
	 * @param \TYPO3\ParserApi\Domain\Model\AbstractObject
	 * @return \TYPO3\ParserApi\Domain\Model\AbstractObject
	 */
	protected function setPropertiesFromNode(\PHPParser_Node_Stmt $node, $object) {
		$object->setNode($node);
		if(method_exists($node,'getType')) {
			$object->setModifiers($node->getType());
		}
		$object->setBodyStmts($node->getStmts());
		$object->initDocComment();
		$object->initializeParameters();
		return $object;
	}


}