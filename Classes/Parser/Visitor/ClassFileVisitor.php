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
* @package classparser
* @author Nico de Haen
*/


/**
* provides methods to import a class object and methods and properties
*
* @package Classparser
* @version $ID:$
*/

class Tx_Classparser_Parser_Visitor_ClassFileVisitor extends PHPParser_NodeVisitorAbstract {

	protected $properties = array();

	/**
	 * @var Tx_Classparser_Domain_Model_Class
	 */
	protected $classObject = NULL;

	/**
	 * currently not used, might be useful for filtering etc.
	 * it keeps a reference to the current "first level" node
	 *
	 * @var array
	 */
	protected $contextStack = array();

	/**
	 * @var Tx_Classparser_Domain_Model_File
	 */
	protected $fileObject = NULL;


	public function getFileObject() {
		return $this->fileObject;
	}

	public function enterNode(PHPParser_Node $node) {

		if($node instanceof PHPParser_Node_Stmt_Namespace || $node instanceof PHPParser_Node_Stmt_Use) {
			$this->contextStack[] = $node;
			$this->fileObject->addNameSpace($node);
		} elseif($node instanceof PHPParser_Node_Expr_Include) {
			$this->contextStack[] = $node;
			if($this->classObject === NULL) {
				$this->fileObject->addPreIncludes($node);
			} else {
				$this->fileObject->addPostInclude($node);
			}
		} elseif($node instanceof PHPParser_Node_Stmt_Class) {
			$this->contextStack[] = $node;
			$this->classObject = new Tx_Classparser_Domain_Model_Class($node);
		} elseif($node instanceof PHPParser_Node_Stmt_ClassConst) {
			$this->classObject->setConstantNode($node);
		} elseif($node instanceof PHPParser_Node_Stmt_Property) {
			$this->contextStack[] = $node;
			$property = new Tx_Classparser_Domain_Model_Class_Property($node);
			$this->classObject->addProperty($property);
		} elseif($node instanceof PHPParser_Node_Stmt_ClassMethod) {
			$this->contextStack[] = $node;
			$method = new Tx_Classparser_Domain_Model_Class_Method($node);
			$this->classObject->addMethod($method);
		}

	}

	public function leaveNode(PHPParser_Node $node){
		if($node instanceof PHPParser_Node_Stmt_Class) {
			array_pop($this->contextStack);
			if(count($this->contextStack) > 0) {
				if(end($this->contextStack)->getType() == 'Stmt_Namespace') {
					$nameSpaceLabel = Tx_Classparser_Parser_Utility_NodeFactory::getValueFromNode(end($this->contextStack));
					$this->classObject->setNameSpace($nameSpaceLabel);
					$this->fileObject->addNameSpacedClass(Tx_Classparser_Parser_Utility_NodeFactory::getValueFromNode(end($this->contextStack)), $this->classObject);
				}
			} else {
				$this->fileObject->addClass($this->classObject);
			}
		}
		if(get_class($node) == get_class(end($this->contextStack))) {
			array_pop($this->contextStack);
		}
	}

	public function beforeTraverse(array $nodes){
		$this->fileObject =  new Tx_Classparser_Domain_Model_File;
	}

	public function afterTraverse(array $nodes){
	}
}