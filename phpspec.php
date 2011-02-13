<?php
/**
 * Run the specs from the command line.
 *
 * E.g:
 *
 * php phpspec.php path/to/dir/with/tests
 *
 * If no path is specified the current directory is assumed.
 *
 * Make sure simpletest is installed in the 'simpletest' directory relative to this file.
 */

require_once dirname(__FILE__) . '/simpletest/unit_tester.php';
require_once dirname(__FILE__) . '/simpletest/mock_objects.php';
require_once dirname(__FILE__) . '/simpletest/collector.php';
require_once dirname(__FILE__) . '/simpletest/default_reporter.php';

require_once dirname(__FILE__) . "/classes/ItExpectation.php";
require_once dirname(__FILE__) . "/classes/ItInvoker.php";
require_once dirname(__FILE__) . "/classes/ItCase.php";
require_once dirname(__FILE__) . "/classes/DescribeTest.php";

if(count($argv) > 1){
	$path = $argv[1];
}else{
	$path = ".";
}

$suite = new TestSuite();

/*
 * Describe our tests.
 */

$describe = function($name,$description) use (&$suite) {
	$suite->add(new DescribeTest($name,$description));
};

/*
 * Find all the *Spec.php files.
 */

$specs = new RegexIterator(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)),'/^.+Spec\.php$/', RecursiveRegexIterator::GET_MATCH);

foreach($specs as $specFile){
	include($specFile[0]);
}

$suite->run(new DefaultReporter());
