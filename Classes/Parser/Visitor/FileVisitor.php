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

class Tx_PhpParser_Parser_Visitor_FileVisitor extends PHPParser_NodeVisitorAbstract implements Tx_PhpParser_Parser_Visitor_FileVisitorInterface{

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
	 * @var
	 */
	protected $currentContainer = NULL;

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
			$this->currentContainer = $this->currentNamespace;
			//$this->fileObject->addNamespace($currentNamespace);
		} elseif($node instanceof PHPParser_Node_Stmt_Use) {
			$this->currentContainer->addAliasDeclaration($node);
		} elseif($node instanceof PHPParser_Node_Expr_Include) {
			$this->contextStack[] = $node;
			// will be added onLeave
		} elseif($node instanceof PHPParser_Node_Stmt_Class) {
			$this->contextStack[] = $node;
			$this->currentClassObject = $this->classFactory->buildClassObjectFromNode($node);
			$this->currentContainer = $this->currentClassObject;
		} elseif($node instanceof PHPParser_Node_Stmt_ClassConst || $node instanceof PHPParser_Node_Stmt_Const) {
			$constants = Tx_PhpParser_Parser_Utility_NodeConverter::convertClassConstantNodeToArray($node);
			foreach($constants as $constant) {
				$this->currentContainer->setConstant($constant['name'],$constant['value']);
			}
		} elseif($node instanceof PHPParser_Node_Stmt_Property) {
			$this->contextStack[] = $node;
			$property = $this->classFactory->buildPropertyObjectFromNode($node);
			$this->currentClassObject->addProperty($property);
		} elseif($node instanceof PHPParser_Node_Stmt_ClassMethod) {
			$this->contextStack[] = $node;
			$method = $this->classFactory->buildClassMethodObjectFromNode($node);
			$this->currentClassObject->addMethod($method);
		} elseif($node instanceof PHPParser_Node_Stmt_Function) {
			$this->contextStack[] = $node;
			$function = $this->classFactory->buildFunctionObjectFromNode($node);
			$this->currentContainer->addFunction($function);
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
				}
			} else {
				$this->fileObject->addClass($this->currentClassObject);
				$this->currentClassObject = NULL;
				$this->currentContainer = $this->fileObject;
			}
		} elseif($node instanceof PHPParser_Node_Expr_Include) {
			array_pop($this->contextStack);
			if($this->currentContainer->getFirstClass() === FALSE) {
				$this->currentContainer->addPreInclude($node);
			} else {
				$this->currentContainer->addPostInclude($node);
			}

		} elseif($node instanceof PHPParser_Node_Stmt_Namespace) {
			array_pop($this->contextStack);
			$this->fileObject->addNamespace($this->currentNamespace);
			$this->currentNamespace = NULL;
			$this->currentContainer = $this->fileObject;
		}
		if(get_class($node) == get_class(end($this->contextStack))) {
			array_pop($this->contextStack);
		}
	}

	public function beforeTraverse(array $nodes){
		$this->fileObject =  new Tx_PhpParser_Domain_Model_File;
		$this->currentContainer = $this->fileObject;
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