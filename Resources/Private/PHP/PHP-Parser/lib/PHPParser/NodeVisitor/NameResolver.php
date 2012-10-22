<?php

class PHPParser_NodeVisitor_NameResolver extends PHPParser_NodeVisitorAbstract {

	/**
	 * @var null|PHPParser_Node_Name Current namespace
	 */
	protected $namespace;

	/**
	 * @var array Currently defined namespace and class aliases
	 */
	protected $aliases;

	public function beforeTraverse(array $nodes) {
		$this->namespace = NULL;
		$this->aliases = array();
	}

	public function enterNode(PHPParser_Node $node) {
		if ($node instanceof PHPParser_Node_Stmt_Namespace) {
			/** @var $node PHPParser_Node_Stmt_Namespace */
			$this->namespace = $node->getName();
			$this->aliases = array();
		} elseif ($node instanceof PHPParser_Node_Stmt_UseUse) {
			/** @var $node PHPParser_Node_Stmt_UseUse */
			if (isset($this->aliases[$node->getAlias()])) {
				throw new PHPParser_Error(
					sprintf(
						'Cannot use "%s" as "%s" because the name is already in use',
						$node->getName(), $node->getAlias()
					),
					$node->getLine()
				);
			}
			$this->aliases[$node->getAlias()] = $node->getName();
		} elseif ($node instanceof PHPParser_Node_Stmt_Class) {
			/** @var $node PHPParser_Node_Stmt_Class */
			if (NULL !== $node->getExtends()) {
				$node->setExtends($this->resolveClassName($node->getExtends()));
			}
			$interfaces = $node->getImplements();
			if (NULL !== $interfaces) {
				foreach ($interfaces as &$interface) {
					$interface = $this->resolveClassName($interface);
				}
				$node->setImplements($interfaces);
			}
			$this->addNamespacedName($node);
		} elseif ($node instanceof PHPParser_Node_Stmt_Interface) {
			$interfaces = $node->getExtends();
			if (NULL !== $interfaces) {
				foreach ($interfaces as &$interface) {
					$interface = $this->resolveClassName($interface);
				}
				$node->setExtends($interfaces);
			}
			$this->addNamespacedName($node);
		} elseif ($node instanceof PHPParser_Node_Stmt_Trait) {
			$this->addNamespacedName($node);
		} elseif ($node instanceof PHPParser_Node_Stmt_Function) {
			$this->addNamespacedName($node);
		} elseif ($node instanceof PHPParser_Node_Stmt_Const) {
			/** @var $node PHPParser_Node_Stmt_Const */
			foreach ($node->getConsts() as $const) {
				$this->addNamespacedName($const);
			}
		} elseif ($node instanceof PHPParser_Node_Expr_StaticCall
				|| $node instanceof PHPParser_Node_Expr_StaticPropertyFetch
				|| $node instanceof PHPParser_Node_Expr_ClassConstFetch
				|| $node instanceof PHPParser_Node_Expr_New
				|| $node instanceof PHPParser_Node_Expr_Instanceof
		) {
			/** @var $node PHPParser_Node_Expr_StaticCall */
			if ($node->getClass() instanceof PHPParser_Node_Name) {
				$node->setClass($this->resolveClassName($node->getClass()));
			}
		} elseif ($node instanceof PHPParser_Node_Expr_FuncCall
				|| $node instanceof PHPParser_Node_Expr_ConstFetch
		) {
			if ($node->getName() instanceof PHPParser_Node_Name) {
				$node->setName($this->resolveOtherName($node->getName()));
			}
		} elseif ($node instanceof PHPParser_Node_Stmt_TraitUse) {
			/** @var $node PHPParser_Node_Stmt_TraitUse */
			$traits = $node->getTraits();
			if (NULL !== $traits) {
				foreach ($traits as &$trait) {
					$trait = $this->resolveClassName($trait);
				}
				$node->setTraits($traits);
			}
		} elseif ($node instanceof PHPParser_Node_Param
				&& $node->getType() instanceof PHPParser_Node_Name
		) {
			$node->setType($this->resolveClassName($node->getType()));
		}
	}

	protected function resolveClassName(PHPParser_Node_Name $name) {
		// don't resolve special class names
		if (in_array((string)$name, array('self', 'parent', 'static'))) {
			return $name;
		}

		// fully qualified names are already resolved
		if ($name->isFullyQualified()) {
			return $name;
		}

		// resolve aliases (for non-relative names)
		if (!$name->isRelative() && isset($this->aliases[$name->getFirst()])) {
			$name->setFirst($this->aliases[$name->getFirst()]);
			// if no alias exists prepend current namespace
		} elseif (NULL !== $this->namespace) {
			$name->prepend($this->namespace);
		}

		return new PHPParser_Node_Name_FullyQualified($name->getParts());
	}

	protected function resolveOtherName(PHPParser_Node_Name $name) {
		// fully qualified names are already resolved and we can't do anything about unqualified
		// ones at compiler-time
		if ($name->isFullyQualified() || $name->isUnqualified()) {
			return $name;
		}

		// resolve aliases for qualified names
		if ($name->isQualified() && isset($this->aliases[$name->getFirst()])) {
			$name->setFirst($this->aliases[$name->getFirst()]);
			// prepend namespace for relative names
		} elseif (NULL !== $this->namespace) {
			$name->prepend($this->namespace);
		}

		return new PHPParser_Node_Name_FullyQualified($name->getParts());
	}

	protected function addNamespacedName(PHPParser_Node $node) {
		if (NULL !== $this->namespace) {
			$namespacedName = clone $this->namespace;
			$namespacedName->append($node->getName());
			$node->setAttribute('namespacedName', $namespacedName);
		} else {
			$namespacedName = new PHPParser_Node_Name($node->getName());
			$node->setAttribute('namespacedName', $namespacedName);
		}
	}
}