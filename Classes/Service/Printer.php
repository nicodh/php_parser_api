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


/**
* provides methods to render the sourcecode for statements
* @package php_parser
* @version $ID:$
*/
class Tx_PhpParser_Service_Printer extends PHPParser_PrettyPrinter_TYPO3CGL implements t3lib_singleton {


	/**
	 * @param array $stmts
	 */
	public function render($stmts) {
		if(!is_array($stmts)) {
			$stmts = array($stmts);
		}
		//t3lib_utility_Debug::debugInPopUpWindow($stmts);
		return $this->prettyPrint($stmts);
	}

	public function renderClassObject($classObject) {
		$classObject->updateStmts();
		return $this->render($classObject->getNode());
	}

	public function renderFileObject($fileObject) {
		foreach($fileObject->getClasses() as $class) {
			$class->updateStmts();
		}
		return $this->render($fileObject->getStmts());
	}

	public function pStmt_Namespace(PHPParser_Node_Stmt_Namespace $node) {
     return 'namespace' . (null !== $node->name ? ' ' . $this->p($node->name) : '') . ';';
 }
}

?>