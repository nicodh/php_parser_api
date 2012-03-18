<?php

class Tx_Classparser_Tests_BasicClass {

	/**
	 *
	 *
	 */
	const TEST = "test";

	/**
	 *
	 *
	 */
	const TEST2 = "test";

	/**
	 * names
	 *
	 * @var mixed // please define a var type here
	 */
	protected $names;

	/**
	 * getNames
	 *
	 * @return array $names
	 */
	public function getNames() {
		return $this->names;
	}

	/**
	 * getNames0
	 *
	 * @return
	 */
	public function getNames0() {
		return $this->names;
	}

	/**
	 * getNames1
	 *
	 * @return
	 */
	public function getNames1() {

	}

	/**
	 * getNames2
	 *
	 * @return
	 */
	public function getNames2() {

	}

	/**
	 * getNames3
	 *
	 * @return
	 */
	public function getNames3() {
		return $this->names;
	}

	/**
	 * setNames
	 *
	 * @param array $names
	 * @return void
	 */
	public function setNames(array $names) {
		$this->names = $names;
	}

}
?>