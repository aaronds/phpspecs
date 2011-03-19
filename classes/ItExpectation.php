<?php

/**
 * Some default matches
 */

class ItExpectation {

	public $message = '%s';

	public function __construct($value,$desc){
		$this->value = $value;
		$this->desc = $desc;
	}

	/**
	 * Allow messages to be changed.
	 *
	 * Usage: $expect(true)->withMessage("%s messagae")->toBeTrue()
	 */

	public function withMessage($m){
		$this->message = $message;
		return $this;
	}

	/**
	 * Try to map arbitary calls starting with to or toBe to sensible expectations
	 */

	public function __call($name,$args){
		$expectationName = preg_replace("/^(toBe|to|is)/","",$name) . "Expectation";

		if(empty($args)){
			$expObj  = new $expectationName();
		}else{
			$refClass = new ReflectionClass($expectationName);
			$expObj = $refClass->newInstanceArgs($args);
		}

		$this->desc->assert($expObj,$this->value,$this->message);
		return $this;
	}

}
?>
