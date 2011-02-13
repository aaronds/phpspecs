<?php
/**
 * An invoker for it methods.
 */

class ItInvoker extends SimpleInvoker {

	public $description = null;

	/*
	 * Expect counter - used for identifying the failed expectation.
	 */

	public $expectNumber = 0;

	public function __construct($desc){
		$this->description = $desc;
	}

	/**
	 * Before a method.
	 */

	public function before($method){
		if($method->beforeFn){
			$beforeFn = $method->beforeFn;
			$beforeFn();
		}
	}
	
	/**
	 * After a method.
	 */

	public function after($method){
		if($method->afterFn){
			$afterFn = $method->afterFn;
			$afterFn();
		}
	}

	/**
	 * Run the actual case.
	 */

	public function invoke($method){
		$desc = &$this->description;
		$expectCounter = &$this->expectNumber;

		$expect = function($value) use (&$desc,&$expectCounter) {
			$expectCounter++;
			return new ItExpectation($value,$desc);
		};

		$shouldFn = $method->shouldFn;
		$shouldFn($expect);
	}
}
?>
