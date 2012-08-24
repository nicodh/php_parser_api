<?php
namespace TYPO3\ParserApi\Service;
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
 * provides methods to generate classes from PHP code
 *
 * @property \TYPO3\ParserApi\Parser\Visitor\FileVisitorInterface classFileVisitor
 * @package PhpParserApi
 * @author Nico de Haen
 */


class Parser extends \PHPParser_Parser {

	/**
	 * @var \TYPO3\ParserApi\Parser\Visitor\FileVisitorInterface
	 */
	protected $fileVisitor = NULL;

	/**
	 * @var \TYPO3\ParserApi\Parser\TraverserInterface
	 */
	protected $traverser = NULL;

	/**
	 * @var \TYPO3\ParserApi\Parser\ClassFactoryInterface
	 */
	protected $classFactory = NULL;


	/**
	 * @param string $code
	 * @return \TYPO3\ParserApi\Domain\Model\File
	 */
	public function parseCode($code) {
		$stmts = $this->parseRawStatements($code);
			// set defaults
		if (NULL === $this->traverser) {
			$this->traverser = new \TYPO3\ParserApi\Parser\Traverser;
		}
		if (NULL === $this->fileVisitor) {
			$this->fileVisitor = new \TYPO3\ParserApi\Parser\Visitor\FileVisitor;
		}
		if (NULL === $this->classFactory) {
			$this->classFactory = new \TYPO3\ParserApi\Parser\ClassFactory;
		}
		$this->fileVisitor->setClassFactory($this->classFactory);
		$this->traverser->appendVisitor($this->fileVisitor);
		$this->traverser->traverse(array($stmts));
		$fileObject = $this->fileVisitor->getFileObject();
		return $fileObject;
	}

	/**
	 * @param string $fileName
	 * @throws \TYPO3\ParserApi\Exception\FileNotFoundException
	 * @return \TYPO3\ParserApi\Domain\Model\File
	 */
	public function parseFile($fileName) {
		if (!file_exists($fileName)) {
			throw new \TYPO3\ParserApi\Exception\FileNotFoundException('File "' . $fileName . '" not found!');
		}
		$fileHandler = fopen($fileName, 'r');
		$code = fread($fileHandler, filesize($fileName));
		$fileObject = $this->parseCode($code);
		$fileObject->setFilePathAndName($fileName);
		return $fileObject;
	}

	/**
	 * @param string $code
	 * @return array
	 */
	public function parseRawStatements($code) {
		return parent::parse(new \PHPParser_Lexer($code));
	}

	/**
	 * @param \TYPO3\ParserApi\Parser\Visitor\FileVisitorInterface $visitor
	 */
	public function setFileVisitor(\TYPO3\ParserApi\Parser\Visitor\FileVisitorInterface $visitor) {
		$this->classFileVisitor = $visitor;
	}

	/**
	 * @param \TYPO3\ParserApi\Parser\TraverserInterface
	 * @return void
	 */
	public function setTraverser(\TYPO3\ParserApi\Parser\TraverserInterface $traverser) {
		$this->traverser = $traverser;
	}

	/**
	 * @param \TYPO3\ParserApi\Parser\ClassFactoryInterface $classFactory
	 */
	public function setClassFactory(\TYPO3\ParserApi\Parser\ClassFactoryInterface $classFactory) {
		$this->classFactory = $classFactory;
	}

	/**
	 * @param array $stmts
	 * @param array $replacements
	 * @param string $nodeType
	 * @param string $nodeProperty
	 * @return array
	 */
	public function replaceNodeProperty($stmts, $replacements, $nodeType = NULL, $nodeProperty = 'name') {
		if (NULL === $this->traverser) {
			$this->traverser = new \TYPO3\ParserApi\Parser\Traverser;
		}
		$this->traverser->resetVisitors();
		$visitor = new \TYPO3\ParserApi\Parser\Visitor\ReplaceVisitor;
		$visitor->setNodeType($nodeType)
				->setNodeProperty($nodeProperty)
				->setReplacements($replacements);
		$this->traverser->appendVisitor($visitor);
		$stmts = $this->traverser->traverse($stmts);
		$this->traverser->resetVisitors();
		return $stmts;
	}

}

?>