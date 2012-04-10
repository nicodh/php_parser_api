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

class Tx_Classparser_Service_ClassModifier implements t3lib_Singleton{

	/**
	 * @var Tx_Classparser_Parser_Traverser
	 */
	protected $traverser;

	/**
	 * @param Tx_Classparser_Parser_Traverser $traverser
	 */
	public function injectTraverser(Tx_Classparser_Parser_Traverser $traverser) {
		$this->traverser = $traverser;
	}


	/**
	 * @var Tx_Extbase_Object_Manager
	 */
	protected $objectManager;

	public function injectObjectManager(Tx_Extbase_Object_Manager $objectManager) {
		$this->objectManager = $objectManager;
	}


	public function renamePropertyAndRelatedMethods($classObject, $oldPropertyName, $newPropertyName) {
		$classObject->renameProperty($oldPropertyName, $newPropertyName);
		$getterMethodName = 'get' . ucfirst($oldPropertyName);
		$getMethodObject = $classObject->getMethod($getterMethodName);
		$getMethodNode= $this->replaceNodeProperty(
			$getMethodObject,
			array(
				$getterMethodName => 'get' . ucfirst($newPropertyName),
				$oldPropertyName => $newPropertyName
			)
		);
		$newGetMethodObject = $this->objectManager->get('Tx_Classparser_Domain_Model_Class_Method',$getMethodNode);

		$classObject->removeMethod('getPropertyName');
		$classObject->addMethod($newGetMethodObject);
	}

	/**
	 * @param $objectToModify
	 * @param array $replacements
	 * @param string $nodeType
	 * @param string $nodeProperty
	 * @return PHPParser_Node
	 */
	public function replaceNodeProperty($objectToModify, $replacements, $nodeType = NULL, $nodeProperty = 'name') {
		$node = $objectToModify->getNode();
		$visitor = t3lib_div::makeInstance('Tx_Classparser_Parser_Visitor_ReplaceVisitor');
		$visitor->setNodeType($nodeType)
				->setNodeProperty($nodeProperty)
				->setReplacements($replacements);
		$this->traverser->addVisitor($visitor);
		$stmts = $this->traverser->traverse(array($node));
		$this->traverser->resetVisitors();
		return $stmts[0];
	}
}
