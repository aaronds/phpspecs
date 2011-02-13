<?php
class ItCase {

	/**
	 * Function to be called before test.
	 */
	public $beforeFn = null;

	/**
	 * Function to be called after a test.
	 */
	public $afterFn = null;

	/**
	 * The name / label of the case.
	 */
	public $name = null;

	/**
	 * The method to be called for testing.
	 */
	public $shouldFn = null;

	/**
	 * __construct
	 *
	 * Build an invokable test case, designed to be constructed from a $it method.
	 */
	public function __construct($name,$should = null){
		$this->name = $name;
		$this->shouldFn = $should;
	}

	/**
	 * Set a function to be called before a test.
	 */
	public function before($beforeFn){
		$this->beforeFn = $beforeFn;
		return $this;
	}

	/**
	 * Set a function to be called after a test.
	 */
	public function after($afterFn){
		$this->afterFn = $afterFn;
		return $this;
	}

	/**
	 * Name getter.
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * Bind the actual test function after its creation.
	 */
	public function should($fn){
		$this->shouldFn = $fn;
		return $this;
	}
}
?>
