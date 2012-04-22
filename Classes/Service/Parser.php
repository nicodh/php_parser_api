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
 * provides methods to generate classes from PHP code
 *
 * @package php_parser
 * @version $ID:$
 */


class Tx_PhpParser_Service_Parser extends PHPParser_Parser {

	/**
	 * @var Tx_PhpParser_Parser_Visitor_FileVisitorInterface
	 */
	protected $fileVisitor = NULL;

	/**
	 * @var Tx_Php_Parser_TraverserInterface
	 */
	protected $traverser = NULL;

	/**
	 * @var Tx_PhpParser_Parser_ClassFactoryInterface
	 */
	protected $classFactory = NULL;


	/**
	 * @param string $code
	 * @return Tx_PhpParser_Domain_Model_File
	 */
	public function parse($code) {
		$stmts = $this->parseRawStatements($code);

		// set defaults
		if(NULL === $this->traverser) {
			$this->traverser = new Tx_PhpParser_Parser_Traverser;
		}
		if(NULL === $this->fileVisitor) {
			$this->fileVisitor = new Tx_PhpParser_Parser_Visitor_FileVisitor;
		}
		if(NULL === $this->classFactory) {
			$this->classFactory = new Tx_PhpParser_Parser_ClassFactory;
		}
		$this->fileVisitor->setClassFactory($this->classFactory);
		$this->traverser->addVisitor($this->fileVisitor);
		$this->traverser->traverse(array($stmts));
		$fileObject = $this->fileVisitor->getFileObject();
		return $fileObject;
	}

	/**
	 * @param string $fileName
	 * @return Tx_PhpParser_Domain_Model_File
	 * @throws Exception
	 */
	public function parseFile($fileName) {
		if(!file_exists($fileName)) {
			throw new Tx_PhpParser_Exception_FileNotFoundException('File "'. $fileName . '" not found!');
		}
		$fileHandler = fopen($fileName, 'r');
		$code = fread($fileHandler, filesize($fileName));
		$fileObject = $this->parse($code);
		$fileObject->setFilePathAndName($fileName);
		return $fileObject;
	}

	/**
	 * @param string $code
	 * @return array
	 */
	public function parseRawStatements($code) {
		return parent::parse(new PHPParser_Lexer($code));
	}

	/**
	 * @param Tx_PhpParser_Parser_Visitor_FileVisitorInterface $visitor
	 */
	public function setFileVisitor(Tx_PhpParser_Parser_Visitor_FileVisitorInterface $visitor) {
		$this->classFileVisitor = $visitor;
	}

	/**
	 * @param Tx_PhpParser_Parser_TraverserInterface $traverser
	 */
	public function setTraverser(Tx_PhpParser_Parser_TraverserInterface $traverser) {
		$this->traverser = $traverser;
	}

	/**
	 * @param Tx_PhpParser_Parser_ClassFactoryInterface $classFactory
	 */
	public function setClassFactory(Tx_PhpParser_Parser_ClassFactoryInterface $classFactory) {
		$this->classFactory = $classFactory;
	}

	/**
	 * @param array $stmts
	 * @param array $replacements
	 * @param string $nodeType
	 * @param string $nodeProperty
	 * @return PHPParser_Node
	 */
	public function replaceNodeProperty($stmts, $replacements, $nodeType = NULL, $nodeProperty = 'name') {
		if(NULL === $this->traverser) {
			$this->traverser = new Tx_PhpParser_Parser_Traverser;
		}
		$visitor = new Tx_PhpParser_Parser_Visitor_ReplaceVisitor;
		$visitor->setNodeType($nodeType)
				->setNodeProperty($nodeProperty)
				->setReplacements($replacements);
		$this->traverser->addVisitor($visitor);
		$stmts = $this->traverser->traverse($stmts);
		$this->traverser->resetVisitors();
		return $stmts;
	}

}

?>
