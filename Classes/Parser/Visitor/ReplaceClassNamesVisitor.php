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
 * Example Visitor
 * replaces all occurances of new "className" and static class calls like "className::"
 *
 * @package PhpParserApi
 * @author Nico de Haen
 */

class Tx_PhpParser_Parser_Visitor_ReplaceClassNamesVisitor extends PHPParser_NodeVisitorAbstract {


	protected $nodeType;

	protected $nodeProperty;

	protected $oldClassPrefix;

	protected $newClassPrefix;

	public function getClassObject() {
		return $this->classObject;
	}

	/**
	 * @param \PHPParser_Node $node
	 * @return PHPParser_Node|void
	 */
	public function leaveNode(PHPParser_Node $node) {
		if(NULL !== $node->__get('class')) {
			$oldClassName = Tx_PhpParser_Parser_Utility_NodeConverter::getValueFromNode($node->__get('class'));
			if(strpos($oldClassName,$this->oldClassPrefix) !== FALSE) {
				$newClassName = str_replace($this->oldClassPrefix,$this->newClassPrefix,$oldClassName);
				$node->setClass(Tx_PhpParser_Parser_NodeFactory::buildNodeFromName($newClassName));
				return $node;
			}
		}
	}

	public function beforeTraverse(array $nodes){}
	public function enterNode(PHPParser_Node $node){}
	public function afterTraverse(array $nodes){}

	public function setNewClassPrefix($newClassPrefix) {
		$this->newClassPrefix = $newClassPrefix;
	}

	public function setOldClassPrefix($oldClassPrefix) {
		$this->oldClassPrefix = $oldClassPrefix;
	}

}
