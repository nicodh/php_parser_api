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

	const TEST = 123;

	private static $testProperty = 5;

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
	 * @param array $propertyName
	 * @return void
	 */
	public function setPropertyName(array $propertyName) {
		if($propertyName > 8) {
			// single Line
			$propertyName = 'Test';
		} else {
			$propertyName = 'propertyName';
			$propertyNames = array();
		}
		$this->propertyName = $propertyName;
	}
}
?>