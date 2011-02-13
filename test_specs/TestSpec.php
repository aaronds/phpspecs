<?php
$describe("A Test",function($it){
	$it("should recognise true as true",function($expect){
		$expect(true)->toBeTrue();
	});
	$it->ignore("Should fail if false is expected to be true",function($expect){
		$expect(true)->toBeTrue();
		$expect(false)->toBeTrue();
	});
	$it("Should work with multi parameter matches",function($expect){
		$expect(10)->toEqual(10);
	});

	$it("Should work with some others as well",function($expect){
		$expect(10)->toBeWithinMargin(9,5);
	});
});
