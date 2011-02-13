<?php
/**
 * A php specifier, inspired by scala specs and jasmin for javascript.
 */

class DescribeTest extends SimpleTestCase {

	/**
	 * The array of tests.
	 */
	public $tests = array();

	/**
	 * Function to be called before executing the tests.
	 */
	public $beforeFn = null;

	/**
	 * Function to be called after running all tests.
	 */
	public $afterFn = null;

	/**
	 * Function before each test.
	 */

	public $beforeEach = null;

	/**
	 * Function after each test.
	 */

	public $afterEach = null;

	/**
	 * The current test - used for more sensible debug.
	 */

	public $curentTest = null;

	/**
	 * The current invoker used to pull out the expectation number.
	 */

	public $currentInvoker = null;

	/**
	 * __construct
	 *
	 * @param	name	The name of the test case.
	 *
	 */
	public function __construct($name,$description){
		parent::__construct($name);

		$description($this);
	}

	/**
	 * Invoke this to create a test.
	 */
	
	public function __invoke($name,$should){
		$case = new ItCase($name,$should);
		$this->tests[] = $case;
		return $case;
	}

	/**
	 * Set a function to be run before each.
	 */

	public function beforeEach($beforeFn){
		$this->beforeEach = $beforeFn;
	}

	/**
	 * Set a function to be run after each.
	 */
	
	public function afterEach($afterFn){
		$this->afterEach = $afterFn;
	}

	/**
	 * Overriden from SimpleTestCase.
	 *
	 * Hopefully the funtionality should be preserved.
	 */

	public function run($reporter){
		$context = SimpleTest::getContext();
		$context->setTest($this);
		$context->setReporter($reporter);
		$this->reporter = $reporter;
		$started = false;
		$beforeEach = $this->beforeEach;
		$afterEach = $this->afterEach;
		foreach($this->tests as $test){
			if($reporter->shouldInvoke($this->getLabel(),$test->getName())){
				$this->skip();
				if($this->shouldSkip()){
					break;
				}

				if(!$started){
					$reporter->paintCaseStart($this->getLabel());
					$started = true;
				}

				$invoker = $this->reporter->createInvoker($this->createInvoker());
				$this->currentTest = $test;

				if($beforeEach){
					$beforeEach($this,$test);
				}

				$invoker->before($test);
				$invoker->invoke($test);
				$invoker->after($test);

				if($afterEach){
					$afterEach($this,$test);
				}
			}
		}

		if($started){
			$reporter->paintCaseEnd($this->getLabel());
		}

		unset($this->reporter);
		return $reporter->getStatus();
	}

	public function createInvoker(){
		$this->currentInvoker = new ItInvoker($this);
		return new SimpleErrorTrappingInvoker(
			new SimpleExceptionTrappingInvoker($this->currentInvoker));
	}

	/**
	 * @override
	 *
	 * Have a better guess at the assertion line.
	 */
	
	function getAssertionLine(){
		return ' "' . $this->currentTest->name . '" Expectation Number: ' . $this->currentInvoker->expectNumber;
	}

	/**
	 * A simple ish ignor test mecanism.
	 *
	 * $it->ignore("blah",function ...);
	 */

	function ignore($name,$test){
	}
}
?>
