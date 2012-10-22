<?php

class PHPParser_Serializer_XML implements PHPParser_Serializer {

	protected $writer;

	/**
	 * Constructs a XML serializer.
	 */
	public function __construct() {
		$this->writer = new XMLWriter;
		$this->writer->openMemory();
		$this->writer->setIndent(TRUE);
	}

	public function serialize(array $nodes) {
		$this->writer->flush();
		$this->writer->startDocument('1.0', 'UTF-8');

		$this->writer->startElement('AST');
		$this->writer->writeAttribute('xmlns:node', 'http://nikic.github.com/PHPParser/XML/node');
		$this->writer->writeAttribute('xmlns:subNode', 'http://nikic.github.com/PHPParser/XML/subNode');
		$this->writer->writeAttribute('xmlns:scalar', 'http://nikic.github.com/PHPParser/XML/scalar');

		$this->_serialize($nodes);

		$this->writer->endElement();

		return $this->writer->outputMemory();
	}

	public function _serialize($node) {
		if ($node instanceof PHPParser_Node) {
			/** @var $node PHPParser_Node */
			$this->writer->startElement('node:' . $node->getNodeType());

			if (-1 !== $line = $node->getLine()) {
				$this->writer->writeAttribute('line', $line);
			}

			foreach ($node->getIgnorables() as $ignorable) {
				if ($ignorable instanceof PHPParser_Node_Ignorable_DocComment) {
					/** @var $ignorable PHPParser_Node_Ignorable_DocComment */
					$this->writer->writeAttribute('docComment', $ignorable->getValue());
				} elseif ($ignorable instanceof PHPParser_Node_Ignorable_Comment) {
					/** @var $ignorable PHPParser_Node_Ignorable_Comment */
					$this->writer->writeAttribute('comment', $ignorable->getValue());
				}
			}

			foreach ($node->getSubNodeNames() as $getterMethod => $name) {
				$this->writer->startElement('subNode:' . $name);
				$this->_serialize($node->$getterMethod());

				$this->writer->endElement();
			}

			$this->writer->endElement();
		} elseif (is_array($node)) {
			$this->writer->startElement('scalar:array');
			foreach ($node as $subNode) {
				$this->_serialize($subNode);
			}
			$this->writer->endElement();
		} elseif (is_string($node)) {
			$this->writer->writeElement('scalar:string', $node);
		} elseif (is_int($node)) {
			$this->writer->writeElement('scalar:int', $node);
		} elseif (is_float($node)) {
			$this->writer->writeElement('scalar:float', $node);
		} elseif (TRUE === $node) {
			$this->writer->writeElement('scalar:true');
		} elseif (FALSE === $node) {
			$this->writer->writeElement('scalar:false');
		} elseif (NULL === $node) {
			$this->writer->writeElement('scalar:null');
		} else {
			throw new InvalidArgumentException('Unexpected node type');
		}
	}
}