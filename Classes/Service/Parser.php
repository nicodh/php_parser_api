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
 * provides methods to import a class object
 *
 * @package php_parser
 * @version $ID:$
 */


class Tx_PhpParser_Service_Parser extends PHPParser_Parser implements t3lib_singleton{


	/**
	 * @param string $code
	 * @return Tx_PhpParser_Domain_Model_File
	 */
	public function parse($code) {
		$stmts = $this->parseRawStatements($code);
		$visitor = new Tx_PhpParser_Parser_Visitor_ClassFileVisitor;
		if(!is_object($this->traverser)) {
			$this->traverser = new Tx_PhpParser_Parser_Traverser;
		}
		$this->traverser->addVisitor($visitor);
		$this->traverser->traverse(array($stmts));
		$fileObject = $visitor->getFileObject();
		//t3lib_utility_Debug::debug($classObject->getInfo(), 'classObject: ' . $classObject->getName());
		return $fileObject;
	}

	/**
	 * @param string $fileName
	 * @return array|Tx_PhpParser_Domain_Model_File
	 * @throws Exception
	 */
	public function parseFile($fileName) {
		if(!file_exists($fileName)) {
			throw new Exception('File "'. $fileName . '" not found!');
		}
		$fileHandler = fopen($fileName, 'r');
		$code = fread($fileHandler, filesize($fileName));
		$fileObject = $this->parse($code);
		$fileObject->setFilePathAndName($fileName);
		return $fileObject;
	}

	public function parseRawStatements($code) {
		return parent::parse(new PHPParser_Lexer($code));
	}

}

?>
