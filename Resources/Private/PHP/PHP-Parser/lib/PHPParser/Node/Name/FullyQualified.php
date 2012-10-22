<?php

class PHPParser_Node_Name_FullyQualified extends PHPParser_Node_Name {

	/**
	 * Checks whether the name is unqualified. (E.g. Name)
	 *
	 * @return bool Whether the name is unqualified
	 */
	public function isUnqualified() {
		return FALSE;
	}

	/**
	 * Checks whether the name is qualified. (E.g. Name\Name)
	 *
	 * @return bool Whether the name is qualified
	 */
	public function isQualified() {
		return FALSE;
	}

	/**
	 * Checks whether the name is fully qualified. (E.g. \Name)
	 *
	 * @return bool Whether the name is fully qualified
	 */
	public function isFullyQualified() {
		return TRUE;
	}

	/**
	 * Checks whether the name is explicitly relative to the current namespace. (E.g. namespace\Name)
	 *
	 * @return bool Whether the name is relative
	 */
	public function isRelative() {
		return FALSE;
	}

	/**
	 * Returns a string representation of the name by imploding the namespace parts with a separator.
	 *
	 * @param string $separator The separator to use (defaults to the namespace separator \)
	 *
	 * @return string String representation
	 */
	public function toString($separator = '\\') {
		return '\\' . implode($separator, $this->parts);
	}
}