<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Nico de Haen <mail@ndh-websolutions.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 *
 * @package classparser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Classparser_Domain_Model_AbstractObject {

	/**
	 *  const MODIFIER_PUBLIC    =  1;
	 *  const MODIFIER_PROTECTED =  2;
	 *  const MODIFIER_PRIVATE   =  4;
	 *  const MODIFIER_STATIC    =  8;
	 *  const MODIFIER_ABSTRACT  = 16;
	 *  const MODIFIER_FINAL     = 32;
	 *
	 * @var array
	 */
	private $mapModifierNames = array(
		'static'    => PHPParser_Node_Stmt_Class::MODIFIER_STATIC,
		'abstract'  => PHPParser_Node_Stmt_Class::MODIFIER_ABSTRACT,
		'final'     => PHPParser_Node_Stmt_Class::MODIFIER_FINAL,
		'public'    => PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC,
		'protected' => PHPParser_Node_Stmt_Class::MODIFIER_PROTECTED,
		'private'   => PHPParser_Node_Stmt_Class::MODIFIER_PRIVATE

	);

	/**
	 * Description of property
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * array
	 *
	 * @var string
	 */
	protected $modifiers = array();

	/**
	 * array
	 *
	 * @var string
	 */
	protected $tags = array();

	/**
	 * docComment
	 *
	 * @var string
	 */
	protected $docComment;

	/**
	 * @var Tx_Classparser_Parser_DocCommentParser
	 */
	protected $docCommentParser;


	/**
	 * @var PHPParser_Node
	 */
	protected $node;

	/**
	 * precedingBlock
	 * all lines that were found above the declaration of the current element
	 *
	 * @var string
	 */
	protected $precedingBlock;

	/**
	 * Setter for name
	 *
	 * @param string $name name
	 * @return void
	 */
	public function setName($name, $updateNodeName = TRUE) {
		$this->name = $name;
		if($updateNodeName) {
			$this->node->__set('name',$name);
		}
	}

	/**
	 * Getter for name
	 *
	 * @return string name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Setter for modifiers
	 *
	 * @param string $modifiers modifiers
	 * @return void
	 */
	public function setModifiers($modifiers) {
		if (is_array($modifiers)) {
			$this->modifiers = $modifiers;
		} else {
			$this->modifiers = explode(' ', $modifiers);
		}
	}

	/**
	 * adds a modifier
	 *
	 * @param string $modifiers
	 * @return void
	 */
	public function addModifier($modifier) {
		if (!is_numeric($modifier)) {
			$modifier = $this->mapModifierNames[$modifier];
		}
		if (!in_array($modifier, $this->modifiers)) {
			$this->modifiers[] = $modifier;
		}
	}

	/**
	 * Getter for modifiers
	 *
	 * @return int modifiers
	 */
	public function getModifiers() {
		return $this->modifiers;
	}

	/**
	 * getModifierNames
	 *
	 * @return
	 */
	public function getModifierNames() {
		$modifiers = $this->getModifiers();
		$modifierNames = array();
		if (is_array($modifiers)) {
			foreach ($modifiers as $modifier) {
				$modifierNames[] = array_shift(Reflection::getModifierNames($modifier));
			}
		}
		else {
			$modifierNames = Reflection::getModifierNames($modifiers);
		}
		return $modifierNames;
	}

	public function setNode(PHPParser_Node $node) {
		$this->node = $node;
	}

	public function getNode() {
		return $this->node;
	}

	protected function updateDocComment() {
		$this->docComment = $this->docCommentParser->renderDocComment($this->tags, $this->description);
		$this->node->setDocComment($this->docComment);
	}

	/**
	 * Setter for docComment
	 *
	 * @param string $docComment docComment
	 * @param boolean $updateNodeDocComment
	 * @return void
	 */
	public function setDocComment($docComment, $updateNodeDocComment = TRUE) {
		$this->docComment = $docComment;
		if(!is_object($this->docCommentParser)) {
		    // inject not possible?
			$this->docCommentParser = t3lib_div::makeInstance('Tx_Classparser_Parser_DocCommentParser');
		}
		$this->docCommentParser->parseDocComment($docComment);
		$this->tags = $this->docCommentParser->getTags();
		$this->description = $this->docCommentParser->getDescription();
		if($updateNodeDocComment) {
			$this->node->setDocComment($docComment);
		}
	}

	/**
	 * Getter for docComment
	 *
	 * @return string docComment
	 */
	public function getDocComment() {
		return $this->docComment;
	}

	/**
	 * is there a docComment
	 *
	 * @return boolean
	 */
	public function hasDocComment() {
		if (!empty($this->docComment)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Checks if the doc comment of this method is tagged with
	 * the specified tag
	 *
	 * @param  string $tag: Tag name to check for
	 * @return boolean TRUE if such a tag has been defined, otherwise FALSE
	 */
	public function isTaggedWith($tagName) {
		return (isset($this->tags[$tagName]));
	}


	/**
	 * Returns the values of the specified tag
	 * @return array Values of the given tag
	 */
	public function getTagValues($tagName) {
		return $this->tags[$tagName];
	}

	/**
	 * Returns an array of tags and their values
	 *
	 * @return array Tags and values
	 */
	public function getTags() {
		return $this->tag;
	}

	/**
	 * sets a tags
	 *
	 * @param string $tagName
	 * @param mixed $tagValue
	 * @return void
	 */
	public function setTag($tagName, $tagValue, $override = TRUE) {
		if (!$override && isset($this->tags[$tagName])) {
			if (!is_array($this->tags[$tagName])) {
				// build an array with the existing value as first element
				$this->tags[$tagName] = array($this->tags[$tagName]);
			}
			$this->tags[$tagName][] = $tagValue;
		}
		else {
			$this->tags[$tagName] = $tagValue;
		}
		$this->updateDocComment();
	}

	public function addTag($tagName, $tagValue) {
		if(isset($this->tags[$tagName])) {
			$this->tags[$tagName][] = $tagValue;
		} else {
			$this->tags[$tagName] = array($tagValue);
		}
		$this->updateDocComment();
		return $this;
	}

	/**
	 * unsets a tag
	 *
	 * @param string $tagName
	 * @param mixed $tagValue of the tag to be removed
	 * (if second parameter is not set, all tags with that name will be removed)
	 * @return void
	 */
	public function removeTag($tagName, $tagValue = NULL) {
		if(func_num_args() > 1) {
			for($i = 0;$i < count($this->tags[$tagName]);$i++) {
				if($tagValue === $this->tags[$tagName][$i]) {
					unset($this->tags[$tagName][$i]);
				}
			}
		} else {
			unset($this->tags[$tagName]);
		}
		$this->updateDocComment();
	}

	/**
	 * Setter for precedingBlock
	 *
	 * @param string $precedingBlock precedt3lib_div::makeInstance(ingBlock
	 * @return void
	 */
	public function setPrecedingBlock($precedingBlock) {
		$this->precedingBlock = $precedingBlock;
	}

	/**
	 * Getter for precedingBlock
	 *
	 * @return string precedingBlock
	 */
	public function getPrecedingBlock() {
		$cleanPrecedingBlock = str_replace($this->docComment, '', $this->precedingBlock);
		$cleanPrecedingBlock = str_replace('<?php', '', $cleanPrecedingBlock);
		if (strlen(trim($cleanPrecedingBlock)) == 0) {
			return NULL;
		} else {
			return $cleanPrecedingBlock;
		}
	}

}

?>