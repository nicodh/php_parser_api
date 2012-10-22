<?php

interface PHPParser_Node {

	/**
	 * Gets the type of the node.
	 *
	 * @return string Type of the node
	 */
	public function getNodeType();

	/**
	 * Gets the names of the sub nodes.
	 *
	 * @return array Names of sub nodes
	 */
	public function getSubNodeNames();

	/**
	 * Gets line the node started in.
	 *
	 * @return int Line
	 */
	public function getLine();

	/**
	 * Sets line the node started in.
	 *
	 * @param int $line Line
	 * @return \PHPParser_Node
	 */
	public function setLine($line);

	/**
	 * Gets the nearest doc comment.
	 *
	 * @return array $ignorables All Ignorables
	 */
	public function getIgnorables();

	/**
	 * Sets the nearest doc comment.
	 *
	 * @param array $ignorables All Ignorables
	 * @return \PHPParser_Node
	 */
	public function setIgnorables(array $ignorables);

	/**
	 * Sets an attribute on a node.
	 *
	 * @param string $key * @param mixed $value
	 * @return \PHPParser_Node
	 */
	public function setAttribute($key, $value);

	/**
	 * Returns whether an attribute exists.
	 *
	 * @param string $key *
	 * @return Boolean
	 */
	public function hasAttribute($key);

	/**
	 * Returns the value of an attribute.
	 *
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function getAttribute($key, $default = NULL);

	/**
	 * Returns all attributes for the given node.
	 *
	 * @return array
	 */
	public function getAttributes();

	/**
	 * @param \PHPParser_Node $parent
	 * @param string $parentSubNodeName
	 * @return \PHPParser_Node
	 */
	public function setParent(\PHPParser_Node $parent = NULL, $parentSubNodeName = NULL);

	/**
	 * @return \PHPParser_Node
	 */
	public function getParent();

	/**
	 * @return string
	 */
	public function getParentSubNodeName();

}