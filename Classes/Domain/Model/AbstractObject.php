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
 * @author Nico de Haen
 * @package php_parser
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_PhpParser_Domain_Model_AbstractObject {

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
		'public'    => PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC,
		'protected' => PHPParser_Node_Stmt_Class::MODIFIER_PROTECTED,
		'private'   => PHPParser_Node_Stmt_Class::MODIFIER_PRIVATE,
		'static'    => PHPParser_Node_Stmt_Class::MODIFIER_STATIC,
		'abstract'  => PHPParser_Node_Stmt_Class::MODIFIER_ABSTRACT,
		'final'     => PHPParser_Node_Stmt_Class::MODIFIER_FINAL
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
	 * @var Tx_PhpParser_Parser_DocCommentParser
	 */
	protected $docCommentParser;

	/**
	 * @var string
	 */
	protected $namespace;


	/**
	 * @var PHPParser_Node
	 */
	protected $node;

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
		if($this->isNamespaced()) {
			return $this->namespace . '\\' . $this->name;
		} else {
			return $this->name;
		}
	}

	/**
	 * Getter for short name (without namespace
	 *
	 * @return string name
	 */
	public function getShortName() {
		return $this->name;
	}

	/**
	 * @return bool
	 */
	public function isPublic() {
		return (($this->modifiers & PHPParser_Node_Stmt_Class::MODIFIER_PUBLIC) !==0);
	}

	/**
	 * @return bool
	 */

	public function isProtected() {
		return (($this->modifiers & PHPParser_Node_Stmt_Class::MODIFIER_PROTECTED) !==0);
	}

	/**
	 * @return bool
	 */
	public function isPrivate() {
		return (($this->modifiers & PHPParser_Node_Stmt_Class::MODIFIER_PRIVATE) !==0);
	}

	/**
	 * @return bool
	 */
	public function isStatic() {
		return (($this->modifiers & PHPParser_Node_Stmt_Class::MODIFIER_STATIC) !==0);
	}

	/**
	 * @return bool
	 */
	public function isAbstract() {
		return (($this->modifiers & PHPParser_Node_Stmt_Class::MODIFIER_ABSTRACT) !==0);
	}

	/**
	 * @return bool
	 */
	public function isFinal() {
		return (($this->modifiers & PHPParser_Node_Stmt_Class::MODIFIER_FINAL) !==0);
	}

	/**
	 * Setter for modifiers (will set all modifiers at once,
	 * since modifiers are claculated bitwise)
	 *
	 * @param int $modifiers modifiers
	 * @return void
	 */
	public function setModifiers($modifiers) {
		$this->modifiers = $modifiers;
	}

	/**
	 * adds a modifier
	 *
	 * @param string $modifiers
	 * @return boolean TRUE if modifier could be added
	 */
	public function addModifier($modifier) {
		if(!in_array($modifier, $this->getModifierNames())) {
			try{
				PHPParser_Node_Stmt_Class::verifyModifier($this->modifiers, $this->mapModifierNames[$modifier]);
				$this->modifiers |= $this->mapModifierNames[$modifier];
				$this->node->__set('type',$this->modifiers);
				return TRUE;
			} catch(Exception $e) {
				//debug('Error: ' . $e->getMessage(), 'Error');
				throw new Tx_PhpParser_Exception_SyntaxErrorException($e->getMessage());
				//return FALSE;
			}

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
		return Tx_PhpParser_Parser_Utility_NodeConverter::modifierToNames($modifiers);
	}

	/**
	 * @param PHPParser_Node $node
	 */
	public function setNode(PHPParser_Node $node) {
		$this->node = $node;
	}

	/**
	 * @return PHPParser_Node
	 */
	public function getNode() {
		return $this->node;
	}

	/**
	 * for internal use only
	 * @return void
	 */
	public function initDocComment() {
		if(empty($this->docComment)) {
			foreach($this->node->getIgnorables() as $ignorable) {
				if($ignorable instanceof PHPParser_Node_Ignorable_DocComment) {
					$this->docComment = $ignorable->__get('value');
				}
			}
		}
		if(!is_object($this->docCommentParser)) {
		    // we don't use injection since the class parser might run before
			// any extbase object manager is loadable
			$this->docCommentParser = t3lib_div::makeInstance('Tx_PhpParser_Parser_DocCommentParser');
		}
		$this->docCommentParser->parseDocComment($this->docComment);
		$this->tags = $this->docCommentParser->getTags();
		$this->description = $this->docCommentParser->getDescription();
	}

	/**
	 * for internal use
	 */
	protected function updateDocComment() {
		if(isset($this->tags['return'])) {
			$returnTagValue = $this->tags['return'];
			// always keep the return tag as last tag
			unset($this->tags['return']);
			$this->tags['return'] = $returnTagValue;
		}
		$this->docComment = $this->docCommentParser->renderDocComment($this->tags, $this->description);
		foreach($this->node->getIgnorables() as $ignorable) {
			if($ignorable instanceof PHPParser_Node_Ignorable_DocComment) {
				$ignorable->__set('value', $this->docComment);
			}
		}
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
		if($updateNodeDocComment){
			if(is_array($this->node->getIgnorables())) {
				foreach($this->node->getIgnorables() as $ignorable) {
					if($ignorable instanceof PHPParser_Node_Ignorable_DocComment) {
						$ignorable->__set('value', $this->docComment);
					}
				}
			} else {
				$this->node->setIgnorables(array(new PHPParser_Node_Ignorable_DocComment($docComment)));
			}

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
		return $this->tags;
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

	/**
	 *
	 * @param $tagName
	 * @param $tagValue
	 * @return Tx_PhpParser_Domain_Model_AbstractObject
	 */
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
	 * @param string $description
	 */
	public function setDescription($description) {
		$this->description = $description;
		$this->updateDocComment();
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $namespace
	 */
	public function setNamespaceName($namespace) {
		$this->namespace = $namespace;
	}

	/**
	 * @return string
	 */
	public function getNamespaceName() {
		return $this->namespace;
	}

	/**
	 * @return bool
	 */
	public function isNamespaced() {
		if(empty($this->namespace)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function inNamespace($namespace) {
		if($this->getNamespaceName() == $namespace) {
			return TRUE;
		}
	}

}

?>
