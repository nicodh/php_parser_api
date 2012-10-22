<?php

/**
 * @property int                      $type       Type
 * @property string                   $name       Name
 * @property null|PHPParser_Node_Name $extends    Name of extended class
 * @property PHPParser_Node_Name[]    $implements Names of implemented interfaces
 * @property PHPParser_Node[]         $stmts      Statements
 */
class PHPParser_Node_Stmt_Class extends PHPParser_Node_Stmt {

	const MODIFIER_PUBLIC = 1;
	const MODIFIER_PROTECTED = 2;
	const MODIFIER_PRIVATE = 4;
	const MODIFIER_STATIC = 8;
	const MODIFIER_ABSTRACT = 16;
	const MODIFIER_FINAL = 32;
	const MODIFIER_LEGACY = 64;

	/**
	 * Contains type
	 *
	 * @var int
	 */
	protected $type = 0;

	/**
	 * Contains extends
	 *
	 * @var PHPParser_Node_Name
	 */
	protected $extends;

	/**
	 * Contains implements
	 *
	 * @var PHPParser_Node_Name[]
	 */
	protected $implements;

	/**
	 * Contains stmts
	 *
	 * @var PHPParser_Node[]
	 */
	protected $stmts;

	/**
	 * Contains name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * @var array
	 */
	protected static $specialNames = array(
		'self' => TRUE,
		'parent' => TRUE,
		'static' => TRUE,
	);

	/**
	 * Constructs a class node.
	 *
	 * @param string $name Name
	 * @param array $subNodes Array of the following optional subnodes:
	 *                                'type'       => 0      : Type
	 *                                'extends'    => null   : Name of extended class
	 *                                'implements' => array(): Names of implemented interfaces
	 *                                'stmts'      => array(): Statements
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables Ignorables
	 */
	public function __construct($name, array $subNodes = array(), $line = -1, $ignorables = array()) {
		parent::__construct($line, $ignorables);
		$this->setName($name);
		if (isset($subNodes['type']) && NULL !== $subNodes['type']) {
			$this->setType($subNodes['type']);
		}
		if (isset($subNodes['extends']) && NULL !== $subNodes['extends']) {
			$this->setExtends($subNodes['extends']);
		}
		if (isset($subNodes['implements']) && NULL !== $subNodes['implements']) {
			$this->setImplements($subNodes['implements']);
		}
		if (isset($subNodes['stmts']) && NULL !== $subNodes['stmts']) {
			$this->setStmts($subNodes['stmts']);
		}
	}

	/**
	 * @static
	 * @param $a
	 * @param $b
	 * @throws PHPParser_Error
	 */
	public static function verifyModifier($a, $b) {
		if ($a & 7 && $b & 7) {
			throw new PHPParser_Error('Multiple access type modifiers are not allowed');
		}
		if ($a & self::MODIFIER_ABSTRACT && $b & self::MODIFIER_ABSTRACT) {
			throw new PHPParser_Error('Multiple abstract modifiers are not allowed');
		}
		if ($a & self::MODIFIER_STATIC && $b & self::MODIFIER_STATIC) {
			throw new PHPParser_Error('Multiple static modifiers are not allowed');
		}
		if ($a & self::MODIFIER_FINAL && $b & self::MODIFIER_FINAL) {
			throw new PHPParser_Error('Multiple final modifiers are not allowed');
		}
		if ($a & 48 && $b & 48) {
			throw new PHPParser_Error('Cannot use the final modifier on an abstract class member');
		}
	}

	/**
	 * @param PHPParser_Node_Name $extends
	 * @return \PHPParser_Node_Stmt_Class
	 */
	public function setExtends(PHPParser_Node_Name $extends = NULL) {
		if (isset(self::$specialNames[(string)$extends])) {
			throw new PHPParser_Error(sprintf('Cannot use "%s" as class name as it is reserved', $extends));
		}
		$this->extends = $extends;
		$this->setSelfAsSubNodeParent($extends, 'extends');
		return $this;
	}

	/**
	 * @return PHPParser_Node_Name
	 */
	public function getExtends() {
		return $this->extends;
	}

	/**
	 * @param PHPParser_Node_Name $implement
	 */
	public function appendImplement(PHPParser_Node_Name $implement) {
		if (NULL != $this->implements) {
			$this->implements = array();
		}
		$this->implements[] = $implement;
		$this->setSelfAsSubNodeParent($implement, 'implements');
	}

	/**
	 * @param PHPParser_Node_Name $implement
	 */
	public function removeImplement(PHPParser_Node_Name $implement) {
		if (NULL !== $this->implements) {
			foreach ($this->implements as $key => $existingImplement) {
				if ($implement === $existingImplement) {
					unset($this->implements[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Name $implementNew
	 * @param PHPParser_Node_Name $implementOld
	 */
	public function replaceImplement(PHPParser_Node_Name $implementNew, PHPParser_Node_Name $implementOld) {
		if (NULL !== $this->implements) {
			foreach ($this->implements as $key => $existingImplement) {
				if ($implementOld === $existingImplement) {
					$this->implements[$key] = $implementNew;
					$existingImplement->setParent();
					$this->setSelfAsSubNodeParent($implementNew, 'implements');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Name[] $implements
	 * @return \PHPParser_Node_Stmt_Class
	 */
	public function setImplements(array $implements = NULL) {
		if (NULL !== $implements) {
			foreach ($implements as $interface) {
				$interfaceString = (string)$interface;
				if (isset(static::$specialNames[strtolower($interfaceString)])) {
					throw new PHPParser_Error('Cannot use "' . $interfaceString . '" as interface name as it is reserved', $interface->getLine());
				}
			}
		}
		$this->implements = $implements;
		$this->setSelfAsSubNodeParent($implements, 'implements');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Name
	 */
	public function getImplementAtIndex($index = NULL) {
		if (isset($this->implements[$index])) {
			return $this->implements[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Name[]
	 */
	public function getImplements() {
		return $this->implements;
	}

	/**
	 * @param string $name
	 * @return \PHPParser_Node_Stmt_Class
	 */
	public function setName($name) {
		$name = (string)$name;
		if (isset(self::$specialNames[strtolower($name)])) {
			throw new PHPParser_Error('Cannot use "' . $name . '" as class name as it is reserved', $this->getLine());
		}
		$this->name = $name;
		$this->setSelfAsSubNodeParent($name, 'name');
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @stmt PHPParser_Node $stmt
	 */
	public function appendStmt(PHPParser_Node $stmt) {
		if (NULL != $this->stmts) {
			$this->stmts = array();
		}
		$this->stmts[] = $stmt;
		$this->setSelfAsSubNodeParent($stmt, 'stmts');
	}

	/**
	 * @stmt PHPParser_Node $stmt
	 */
	public function removeStmt(PHPParser_Node $stmt) {
		if (NULL !== $this->stmts) {
			foreach ($this->stmts as $key => $existingStmt) {
				if ($stmt === $existingStmt) {
					unset($this->stmts[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @stmt PHPParser_Node $stmtNew
	 * @stmt PHPParser_Node $stmtOld
	 */
	public function replaceStmt(PHPParser_Node $stmtNew, PHPParser_Node $stmtOld) {
		if (NULL !== $this->stmts) {
			foreach ($this->stmts as $key => $existingStmt) {
				if ($stmtOld === $existingStmt) {
					$this->stmts[$key] = $stmtNew;
					$existingStmt->setParent();
					$this->setSelfAsSubNodeParent($stmtNew, 'stmts');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node[] $stmts
	 * @return \PHPParser_Node_Stmt_Class
	 */
	public function setStmts(array $stmts = NULL) {
		$this->stmts = $stmts;
		$this->setSelfAsSubNodeParent($stmts, 'stmts');
		return $this;
	}


	/**
	 * @return PHPParser_Node
	 */
	public function getStmtAtIndex($index = NULL) {
		if (isset($this->stmts[$index])) {
			return $this->stmts[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node[]
	 */
	public function getStmts() {
		return $this->stmts;
	}

	/**
	 * @param int $type
	 * @return \PHPParser_Node_Stmt_Class
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