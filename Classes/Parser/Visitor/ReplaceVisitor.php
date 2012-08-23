<?php
namespace TYPO3\ParserApi\Parser\Visitor;
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
 *
 * a generic visitor to replace node properties in statements
 * (Usage see: Tests/Function/ModifyObjects renameMethodParameterAndUpdateMethodBody)
 *
 * @package PhpParserApi
 * @author Nico de Haen
 */


class ReplaceVisitor extends \PHPParser_NodeVisitorAbstract {


	/**
	 * @var string
	 */
	protected $nodeType = '';

	/**
	 * @var string
	 */
	protected $nodeProperty = '';

	/**
	 * @var array
	 */
	protected $replacements = array();

	public function getClassObject() {
		return $this->classObject;
	}

	/**
	 * @param PHPParser_Node $node
	 * @return PHPParser_Node|void
	 */
	public function leaveNode(\PHPParser_Node $node) {
		$nodeProperty = $this->nodeProperty;
		$nodeTypeMatch = FALSE;
		if(!empty($this->nodeType)) {
			if($node instanceof $this->nodeType) {
				$nodeTypeMatch = TRUE;
 			}
		} else {
			// no nodeType so apply conditions to all node types
			$nodeTypeMatch = TRUE;
		}
		if($nodeTypeMatch) {
			foreach($this->replacements as $oldValue => $newValue) {
				if(method_exists($node,'get' . strtoupper($nodeProperty))) {
					$nodePropertyValue = NULL;
					eval('$nodePropertyValue = $node->get' . strtoupper($nodeProperty) . '();');
					if($nodePropertyValue == $oldValue) {
						eval('$node->set' . strtoupper($nodeProperty) . '($newValue);');
						//$node->$nodeProperty = $newValue;
					}
				}

			}
			return $node;
		}
	}

	public function beforeTraverse(array $nodes){}
	public function enterNode(\PHPParser_Node $node){}
	public function afterTraverse(array $nodes){}

	/**
	 * @param array $replacements $oldValue => $newValue
	 * @return Tx_PhpParser_Parser_Visitor_ReplaceVisitor
	 */
	public function setReplacements(array $replacements) {
		$this->replacements = $replacements;
		return $this;
	}

	/**
	 * The property of a node that should be changed (defaults to 'name')
	 * @param $nodeProperty
	 * @return Tx_PhpParser_Parser_Visitor_ReplaceVisitor
	 */
	public function setNodeProperty($nodeProperty) {
		$this->nodeProperty = $nodeProperty;
		return $this;
	}

	public function setNodeType($nodeType) {
		$this->nodeType = $nodeType;
		return $this;
	}

}