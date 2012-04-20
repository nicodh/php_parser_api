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
* @package php_parser
* @author Nico de Haen
*/


/**
* provides methods to import a class object and methods and properties
*
* @package php_parser
* @version $ID:$
*/

class Tx_PhpParser_Parser_Visitor_ClassFileVisitor extends PHPParser_NodeVisitorAbstract {

	protected $properties = array();

	/**
	 * @var Tx_PhpParser_Domain_Model_Class
	 */
	protected $currentClassObject = NULL;

	/**
	 * @var Tx_PhpParser_Domain_Model_Namespace
	 */
	protected $currentNamespace = NULL;

	/**
	 * @var Tx_PhpParser_Domain_Model_File
	 */
	protected $fileObject = NULL;

	/**
	 * @var Tx_PhpParser_Parser_ClassFactoryInterface
	 */
	protected $classFactory = NULL;

	/**
	 * currently not used, might be useful for filtering etc.
	 * it keeps a reference to the current "first level" node
	 *
	 * @var array
	 */
	protected $contextStack = array();

	public function getFileObject() {
		return $this->fileObject;
	}

	public function enterNode(PHPParser_Node $node) {

		if($node instanceof PHPParser_Node_Stmt_Namespace) {
			$this->contextStack[] = $node;
			$this->currentNamespace = $this->classFactory->buildNamespaceObjectFromNode($node);
			//$this->fileObject->addNamespace($currentNamespace);
		} elseif($node instanceof PHPParser_Node_Stmt_Use) {
			if($this->currentNamespace !== NULL) {
				$this->currentNamespace->addAliasDeclaration($node);
			} else {
				$this->fileObject->addAliasDeclaration($node);
			}
		} elseif($node instanceof PHPParser_Node_Expr_Include) {
			$this->contextStack[] = $node;
		} elseif($node instanceof PHPParser_Node_Stmt_Class) {
			$this->contextStack[] = $node;
			$this->currentClassObject = $this->classFactory->buildClassObjectFromNode($node);
		} elseif($node instanceof PHPParser_Node_Stmt_ClassConst) {
			$constants = Tx_PhpParser_Parser_Utility_NodeConverter::convertClassConstantNodeToArray($node);
			foreach($constants as $constant) {
				$this->currentClassObject->setConstant($constant['name'],$constant['value']);
			}
		} elseif($node instanceof PHPParser_Node_Stmt_Property) {
			$this->contextStack[] = $node;
			$property = $this->classFactory->buildPropertyObjectFromNode($node);
			$this->currentClassObject->addProperty($property);
		} elseif($node instanceof PHPParser_Node_Stmt_ClassMethod) {
			$this->contextStack[] = $node;
			$method = $this->classFactory->buildClassMethodObjectFromNode($node);
			$this->currentClassObject->addMethod($method);
		}

	}

	public function leaveNode(PHPParser_Node $node){
		if($node instanceof PHPParser_Node_Stmt_Class) {
			array_pop($this->contextStack);
			if(count($this->contextStack) > 0) {
				if(end($this->contextStack)->getType() == 'Stmt_Namespace') {
					$currentNamespaceName = Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode(end($this->contextStack));
					$this->currentClassObject->setNamespaceName($currentNamespaceName);
					$this->currentNamespace->addClass($this->currentClassObject);
					$this->fileObject->addNamespace($this->currentNamespace);
					$this->currentNamespace = NULL;
				}
			} else {
				$this->fileObject->addClass($this->currentClassObject);
				$this->currentClassObject = NULL;
			}
		}
		if($node instanceof PHPParser_Node_Expr_Include) {
			array_pop($this->contextStack);
			if($this->currentNamespace === NULL) {
				if($this->fileObject->getFirstClass() === NULL) {
					$this->fileObject->addPreInclude($node);
				} else {
					$this->fileObject->addPostInclude($node);
				}
			} else {
				if($this->currentNamespace->getFirstClass() === NULL) {
					$this->currentNamespace->addPreInclude($node);
				} else {
					$this->currentNamespace->addPostInclude($node);
				}
			}
		}
		if(get_class($node) == get_class(end($this->contextStack))) {
			array_pop($this->contextStack);
		}
	}

	public function beforeTraverse(array $nodes){
		$this->fileObject =  new Tx_PhpParser_Domain_Model_File;
	}

	public function afterTraverse(array $nodes){
	}

	/**
	 * @param \Tx_PhpParser_Parser_ClassFactoryInterface $classFactory
	 */
	public function setClassFactory($classFactory) {
		$this->classFactory = $classFactory;
	}
}