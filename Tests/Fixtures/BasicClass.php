<?php

class Tx_Classparser_Tests_BasicClass {

	protected $names = array(123);

	const TEST = "test";

	const TEST2 = 'test';
	/**
	 *
	 * @return array $names
	 */
	public function getNames(){
		return $this->names;
	}

	/**
	 * @param string $test
	 * @return array
	 */
	public function getNames0($test, $none = NULL){	return $this->names;}

	public function getNames1(){  }

	public function getNames2(){
	}

	public function getNames3(){
		return $this->names;		}

	/**
	 *
	 * @param array $names
	 * @return void
	 */
	public function setNames(array $names){
		// some comment
		$this->names = $names;
		if($names != NULL) {
			return $names;
		}
	}
}
?>