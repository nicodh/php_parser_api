<?php

class PHPParser_Node_Ignorable_DocComment extends PHPParser_Node_Ignorable {

	/**
	 * Contains description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Contains tags
	 *
	 * @var array
	 */
	protected $tags;

	/**
	 * Constructs a doc comment
	 *
	 * @param string $value Value
	 * @param int $line Line
	 */
	public function __construct($value, $line = -1) {
		$this->setValue($value);
		PHPParser_NodeAbstract::__construct($line);
	}

	/**
	 * Parses the given doc comment and saves the result (description and
	 * tags) in the parser's object. They can be retrieved by the
	 * getTags() getTagValues() and getDescription() methods.
	 *
	 * @param string $docComment A doc comment as returned by the reflection getDocComment() method
	 * @return void
	 */
	protected function parseDocComment($docComment) {
		$this->description = '';
		$this->tags = array();

		$lines = explode(chr(10), $docComment);
		foreach ($lines as $line) {
			$line = preg_replace('/(\s*\*\/\s*)?$/', '', $line);
			$line = trim($line);
			if ($line === '*/') {
				break;
			}
			if (strlen($line) > 0 && strpos($line, '* @') !== FALSE) {
				$this->parseTag(substr($line, strpos($line, '@')));
			} else {
				if (count($this->tags) === 0) {
					$this->description .= preg_replace('/\s*\\/?[\\\\*]*\s?(.*)$/', '$1', $line) . chr(10);
				}
			}
		}
		$this->description = trim($this->description);
	}

	/**
	 * Returns the tags which have been previously parsed
	 *
	 * @return array Array of tag names and their (multiple) values
	 */
	public function &getTagsValues() {
		return $this->tags;
	}

	/**
	 * Returns the values of the specified tag. The doc comment
	 * must be parsed with parseDocComment() before tags are
	 * available.
	 *
	 * @param string $tagName The tag name to retrieve the values for
	 * @return array The tag's values
	 */
	public function &getTagValues($tagName) {
		if (!$this->isTaggedWith($tagName)) {
			throw new \InvalidArgumentException('Tag "' . $tagName . '" does not exist.', 1337645712);
		}
		return $this->tags[$tagName];
	}

	/**
	 * Checks if a tag with the given name exists
	 *
	 * @param string $tagName The tag name to check for
	 * @return boolean TRUE the tag exists, otherwise FALSE
	 */
	public function isTaggedWith($tagName) {
		return (isset($this->tags[$tagName]));
	}

	/**
	 * Parses a line of a doc comment for a tag and its value.
	 * The result is stored in the internal tags array.
	 *
	 * @param string $line A line of a doc comment which starts with an @-sign
	 * @return void
	 */
	protected function parseTag($line) {
		$tagAndValue = array();
		if (preg_match('/@([A-Za-z0-9\\\-]+)(\(.*\))? ?(.*)/', $line, $tagAndValue) === 0) {
			$tagAndValue = preg_split('/\s/', $line, 2);
		} else {
			array_shift($tagAndValue);
		}
		$tag = trim($tagAndValue[0].$tagAndValue[1], '@');
		if (count($tagAndValue) > 1) {
			$this->tags[$tag][] = trim($tagAndValue[2], ' "');
		} else {
			$this->tags[$tag] = array();
		}
	}

	/**
	 * Returns a string representation of the ignorable.
	 *
	 * @param bool $singleLineCommentAllowed
	 * @return string String representation
	 */
	public function toString($singleLineCommentAllowed = FALSE) {
		$docComment = array();
		foreach ($this->tags as $tagName => $tags) {
			if (is_array($tags) && !empty($tags)) {
				foreach ($tags as $tagValue) {
					$docComment[] = '@' . $tagName . ' ' . $tagValue;
				}
			} elseif (is_array($tags) && empty($tags)) {
				$docComment[] = '@' . $tagName;
			} else {
				$docComment[] = '@' . $tagName . ' ' . $tags;
			}
		}
		if (!empty($this->description)) {
			if (!empty($docComment)) {
				array_unshift($docComment, PHP_EOL);
			}
			array_unshift($docComment, $this->description);
		}
		if ($singleLineCommentAllowed && count($docComment) === 1) {
			return '/** ' . $docComment[0] . ' */';
		} else {
			$docComment = preg_replace('/\s+$/', '', $docComment);
			$docComment = preg_replace('/^/', ' * ', $docComment);
			return '/**' . PHP_EOL . implode(PHP_EOL, $docComment) . PHP_EOL . ' */';
		}
	}

	/**
	 * @param string $description */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param array $tags */
	public function setTags($tags) {
		$this->tags = $tags;
	}

	/**
	 * @return array
	 */
	public function &getTags() {
		return $this->tags;
	}

	/**
	 * @param string $value */
	public function setValue($value) {
		$this->parseDocComment($value);
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->toString(TRUE);
	}
}
