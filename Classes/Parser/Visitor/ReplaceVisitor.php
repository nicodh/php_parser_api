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

class Tx_Classparser_Parser_Visitor_ReplaceVisitor extends PHPParser_NodeVisitorAbstract {


	protected $nodeType;

	protected $nodeProperty;

	protected $replacements;

	public function getClassObject() {
		return $this->classObject;
	}

	public function leaveNode(PHPParser_Node $node) {
		$nodeProperty = $this->nodeProperty;
		$nodeTypeMatch = FALSE;
		if($this->nodeType) {
			if($node instanceof $this->nodeType) {
				$nodeTypeMatch = TRUE;
 			}
		} else {
			// no nodeType so apply conditions to all node types
			$nodeTypeMatch = TRUE;
		}
		if($nodeTypeMatch) {
			foreach($this->replacements as $oldValue => $newValue) {
				if($node->$nodeProperty == $oldValue) {
					t3lib_utility_Debug::debug($node, get_class($node));
					$node->$nodeProperty = $newValue;
				}
			}
			return $node;
		}
	}

	public function beforeTraverse(array $nodes){}
	public function enterNode(PHPParser_Node $node){}
	public function afterTraverse(array $nodes){}

	public function setReplacements(array $replacements) {
		$this->replacements = $replacements;
		return $this;
	}

	public function setNodeProperty($nodeProperty) {
		$this->nodeProperty = $nodeProperty;
		return $this;
	}

	public function setNodeType($nodeType) {
		$this->nodeType = $nodeType;
		return $this;
	}

}