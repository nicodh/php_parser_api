<?php

abstract class PHPParser_NodeAbstract implements PHPParser_Node {

	/**
	 * @var array
	 */
	static public $reservedProperties = array(
		'line' => TRUE,
		'attribute' => TRUE,
		'attributes' => TRUE,
		'ignorables' => TRUE,
		'subNodeNames' => TRUE,
		'nodeType' => TRUE,
		'parent' => TRUE,
		'parentSubNodeName' => TRUE
	);

	/**
	 * @var
	 */
	protected $line;

	/**
	 * @var PHPParser_Node_Ignorable[]
	 */
	protected $ignorables = array();

	/**
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * @var PHPParser_Node
	 */
	protected $parent;

	/**
	 * @var string
	 */
	protected $parentSubNodeName;

	/**
	 * Contains subNodeNames
	 *
	 * @var array
	 */
	protected $subNodeNames = array();

	/**
	 * Creates a Node.
	 *
	 * @param array $subNodes Array of sub nodes
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables all ignorables
	 */
	public function __construct($line = -1, array $ignorables = array()) {
		$this->setLine($line);
		$this->setIgnorables($ignorables);
		$this->initalizeSubNodeNames();
	}

	/**
	 * @param mixed $nodes
	 * @param string $subNodeName
	 */
	protected function setSelfAsSubNodeParent($nodes, $subNodeName) {
		if ($nodes instanceof \PHPParser_Node) {
			/** @var $nodes \PHPParser_Node */
			$nodes->setParent($this, $subNodeName);
		} else {
			if (is_array($nodes)) {
				foreach ($nodes as $node) {
					$this->setSelfAsSubNodeParent($node, $subNodeName);
				}
			}
		}
		return $nodes;
	}

	/**
	 * Gets the type of the node.
	 *
	 * @return string Type of the node
	 */
	public function getNodeType() {
		return substr(get_class($this), 15);
	}

	/**
	 * Initializes the subnodes
	 */
	protected function initalizeSubNodeNames() {
		if (empty($this->subNodeNames)) {
			foreach (array_keys(get_class_vars(get_class($this))) as $propertyName) {
				if (!isset(static::$reservedProperties[$propertyName]) && method_exists($this, 'get' . ucfirst($propertyName))) {
					$this->subNodeNames['get' . ucfirst($propertyName)] = $propertyName;
				}
			}
		}
	}

	/**
	 * Gets the names of the sub nodes.
	 *
	 * @return array Names of sub nodes
	 */
	public function getSubNodeNames() {
		return $this->subNodeNames;
	}

	/**
	 * Gets line the node started in.
	 *
	 * @return int Line
	 */
	public function getLine() {
		return $this->line;
	}

	/**
	 * Sets line the node started in.
	 *
	 * @param int $line Line
	 */
	public function setLine($line) {
		$this->line = (int)$line;
		return $this;
	}

	/**
	 * Gets the Ignorables
	 *
	 * @return null|array Ignorables
	 */
	public function getIgnorables() {
		return $this->ignorables;
	}

	/**
	 * Sets the Ignorables
	 *
	 * @param array $ignorables Ignorables
	 */
	public function setIgnorables(array $ignorables) {
		$this->setSelfAsSubNodeParent($ignorables, 'ignorables');
		$this->ignorables = $ignorables;
		return $this;
	}

	/**
	 * @param PHPParser_Node_Ignorable $ignorable */
	public function addIgnorable(PHPParser_Node_Ignorable $ignorable) {
		if (!is_array($this->ignorables)) {
			$this->ignorables = array();
		}
		$this->setSelfAsSubNodeParent($ignorable, 'ignorables');
		$this->ignorables[] = $ignorable;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasLineBreaks() {
		if (NULL !== $this->ignorables) {
			foreach ($this->ignorables as $ignorable) {
				if ($ignorable instanceof PHPParser_Node_Ignorable_Whitespace && strpos($ignorable->getValue(), PHP_EOL) !== FALSE) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}

	/**
	 * @inheritDoc
	 */
	public function setAttribute($key, $value) {
		$this->attributes[$key] = $value;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function hasAttribute($key) {
		return array_key_exists($key, $this->attributes);
	}

	/**
	 * @inheritDoc
	 */
	public function getAttribute($key, $default = NULL) {
		return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : $default;
	}

	/**
	 * @inheritDoc
	 */
	public function getAttributes() {
		return $this->attributes;
	}


	public function __wakeup() {
		$this->initalizeSubNodeNames();
	}

	/**
	 * @param \PHPParser_Node $parent
	 */
	final public function setParent(\PHPParser_Node $parent = NULL, $parentSubNodeName = NULL) {
		if (NULL !== $this->parent && ($parent !== $this->parent || (!empty($this->parentSubNodeName) && $parentSubNodeName !== $this->parentSubNodeName))) {
			// remove from existing parent
			$childNode = $this->parent->{'get' . ucfirst($this->parentSubNodeName)}();
			if (is_array($childNode)) {
				foreach ($childNode as $key => $node) {
					if ($this === $node) {
						unset($childNode[$key]);
						break;
					}
				}
				$this->parent->{'set' . ucfirst($this->parentSubNodeName)}($childNode);
			} else {
				if ($childNode === $this) {
					$this->parent->{'set' . ucfirst($this->parentSubNodeName)}();
				}
			}
		}
		$this->parent = $parent;
		$this->parentSubNodeName = (string)$parentSubNodeName;
		return $this;
	}

	/**
	 * @return \PHPParser_Node
	 */
	final public function getParent() {
		return $this->parent;
	}

	/**
	 * @return string
	 */
	final public function getParentSubNodeName() {
		return $this->parentSubNodeName;
	}
}