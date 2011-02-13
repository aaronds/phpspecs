<?php
$describe("A test integer increamented before and after each test",function($it){
	$testInteger = 0;
	$afterCase = false;

	$it->beforeEach(function($it,$test) use (&$testInteger) {
		$testInteger++;
	});

	$it->afterEach(function($it,$test) use (&$testInteger) {
		$testInteger++;
	});

	$it("be one",function($expect) use (&$testInteger){
		$expect($testInteger)->toEqual(1);
	});

	$it("be three",function($expect) use (&$testInteger){
		$expect($testInteger)->toEqual(3);
	})->after(function() use (&$afterCase){
		$afterCase = false;
	});

});

$describe("A integer incremented before and after an individual test",function($it){
	$testInt = 0;

	$it("dummy case",function($expect){
		$expect(true)->toBeTrue();
	})->before(function() use (&$testInt) {
		$testInt++;
	})->after(function() use (&$testInt){
		$testInt++;
	});

	$it("be 2",function($expect) use (&$testInt) {
		$expect($testInt)->toEqual(2);
	});
});
