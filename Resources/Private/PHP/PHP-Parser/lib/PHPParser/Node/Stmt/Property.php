<?php

/**
 * @property int                                    $type  Modifiers
 * @property PHPParser_Node_Stmt_PropertyProperty[] $props Properties
 */
class PHPParser_Node_Stmt_Property extends PHPParser_Node_Stmt {

	/**
	 * Contains type
	 *
	 * @var int
	 */
	protected $type;

	/**
	 * Contains props
	 *
	 * @var PHPParser_Node_Stmt_PropertyProperty[]
	 */
	protected $props;

	/**
	 * Constructs a class property list node.
	 *
	 * @param int $type Modifiers
	 * @param PHPParser_Node_Stmt_PropertyProperty[] $props Properties
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($type, array $props, $line = -1, $ignorables = array()) {
		$this->setType($type);
		$this->setProps($props);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @param PHPParser_Node_Stmt_PropertyProperty $prop
	 */
	public function appendProp(PHPParser_Node_Stmt_PropertyProperty $prop) {
		if (NULL != $this->props) {
			$this->props = array();
		}
		$this->props[] = $prop;
		$this->setSelfAsSubNodeParent($prop, 'props');
	}

	/**
	 * @param PHPParser_Node_Stmt_PropertyProperty $prop
	 */
	public function removeProp(PHPParser_Node_Stmt_PropertyProperty $prop) {
		if (NULL !== $this->props) {
			foreach ($this->props as $key => $existingProp) {
				if ($prop === $existingProp) {
					unset($this->props[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_PropertyProperty $propNew
	 * @param PHPParser_Node_Stmt_PropertyProperty $propOld
	 */
	public function replaceProp(PHPParser_Node_Stmt_PropertyProperty $propNew, PHPParser_Node_Stmt_PropertyProperty $propOld) {
		if (NULL !== $this->props) {
			foreach ($this->props as $key => $existingProp) {
				if ($propOld === $existingProp) {
					$this->props[$key] = $propNew;
					$existingProp->setParent();
					$this->setSelfAsSubNodeParent($propNew, 'props');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Stmt_PropertyProperty[] $props
	 * @return \PHPParser_Node_Stmt_Property
	 */
	public function setProps(array $props) {
		$this->props = $props;
		$this->setSelfAsSubNodeParent($props, 'props');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Stmt_PropertyProperty
	 */
	public function getPropAtIndex($index = NULL) {
		if (isset($this->props[$index])) {
			return $this->props[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Stmt_PropertyProperty[]
	 */
	public function getProps() {
		return $this->props;
	}

	/**
	 * @param int $type
	 * @return \PHPParser_Node_Stmt_Property
	 */
	public function setType($type) {
		$this->type = (int)$type;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getType() {
		return $this->type;
	}
}