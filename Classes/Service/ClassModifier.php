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

class Tx_PhpParser_Service_ClassModifier {

	/**
	 * @var Tx_PhpParser_Parser_Traverser
	 */
	protected $traverser = NULL;

	/**
	 * @param Tx_Php_Parser_TraverserInterface $traverser
	 */
	public function setTraverser($traverser) {
		$this->traverser = $traverser;
	}

	/**
	 * @param $objectToModify
	 * @param array $replacements
	 * @param string $nodeType
	 * @param string $nodeProperty
	 * @return PHPParser_Node
	 */
	public function replaceNodeProperty($classToModify, $replacements, $nodeType = NULL, $nodeProperty = 'name') {
		if(NULL === $this->traverser) {
			$this->traverser = new Tx_PhpParser_Parser_Traverser;
		}
		$node = $classToModify->getNode();
		$visitor = t3lib_div::makeInstance('Tx_PhpParser_Parser_Visitor_ReplaceVisitor');
		$visitor->setNodeType($nodeType)
				->setNodeProperty($nodeProperty)
				->setReplacements($replacements);
		$this->traverser->addVisitor($visitor);
		$stmts = $this->traverser->traverse(array($node));
		$this->traverser->resetVisitors();
		return $stmts[0];
	}

}
