<?php

class PHPParser_Node_Expr_Array extends PHPParser_Node_Expr {

	/**
	 * Contains items
	 *
	 * @var PHPParser_Node_Expr_ArrayItem[]
	 */
	protected $items;

	/**
	 * Constructs an array node.
	 *
	 * @param PHPParser_Node_Expr_ArrayItem[] $items Items of the array
	 * @param int $line Line
	 * @param PHPParser_Node_Ignorable[] $ignorables All Ignorables
	 */
	public function __construct(array $items = array(), $line = -1, $ignorables = array()) {
		$this->setItems($items);
		parent::__construct($line, $ignorables);
	}

	/**
	 * @return bool
	 */
	public function itemsHaveLineBreaks() {
		if (NULL !== $this->items) {
			foreach ($this->items as $item) {
				if ($item->hasLineBreaks()) {
					return TRUE;
				} elseif ($item->getValue() instanceof PHPParser_Node_Expr_Array) {
					return $item->getValue()->itemsHaveLineBreaks();
				}
			}
		}
		return FALSE;
	}

	/**
	 * @item PHPParser_Node_Expr_ArrayItem $item
	 */
	public function appendItem(PHPParser_Node_Expr_ArrayItem $item) {
		if (NULL != $this->items) {
			$this->items = array();
		}
		$this->items[] = $item;
		$this->setSelfAsSubNodeParent($item, 'items');
	}

	/**
	 * @item PHPParser_Node_Expr_ArrayItem $item
	 */
	public function removeItem(PHPParser_Node_Expr_ArrayItem $item) {
		if (NULL !== $this->items) {
			foreach ($this->items as $key => $existingItem) {
				if ($item === $existingItem) {
					unset($this->items[$key]);
					break;
				}
			}
		}
	}

	/**
	 * @item PHPParser_Node_Expr_ArrayItem $itemNew
	 * @item PHPParser_Node_Expr_ArrayItem $itemOld
	 */
	public function replaceItem(PHPParser_Node_Expr_ArrayItem $itemNew, PHPParser_Node_Expr_ArrayItem $itemOld) {
		if (NULL !== $this->items) {
			foreach ($this->items as $key => $existingItem) {
				if ($itemOld === $existingItem) {
					$this->items[$key] = $itemNew;
					$existingItem->setParent();
					$this->setSelfAsSubNodeParent($itemNew, 'items');
					break;
				}
			}
		}
	}

	/**
	 * @param PHPParser_Node_Expr_ArrayItem[] $items
	 * @return \PHPParser_Node_Expr_Array
	 */
	public function setItems(array $items = NULL) {
		$this->items = $items;
		$this->setSelfAsSubNodeParent($items, 'items');
		return $this;
	}


	/**
	 * @return PHPParser_Node_Expr_ArrayItem
	 */
	public function getItemAtIndex($index = NULL) {
		if (isset($this->items[$index])) {
			return $this->items[$index];
		}
		return NULL;
	}

	/**
	 * @return PHPParser_Node_Expr_ArrayItem[]
	 */
	public function getItems() {
		return $this->items;
	}
}