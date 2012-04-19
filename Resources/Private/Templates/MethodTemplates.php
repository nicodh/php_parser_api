<?php

/**
 * This is just a sample description
 * with multiple lines
 *
 *
 * @package classparser
 * @API
 * @author Nico de Haen
 * @author Max Meiert
 */
class MethodTemplates {

	/**
	 * @var string
	 */
	private $propertyName;

	/**
	 * Returns the propertyName
	 *
	 * @return propertyType $propertyName
	 */
	public function getPropertyName() {
		return $this->propertyName;
	}

	/**
	 * Sets the propertyName
	 *
	 * @param string $propertyName
	 * @return void
	 */
	public function setPropertyName( $propertyName) {
		$this->propertyName = $propertyName;
	}
}
?>