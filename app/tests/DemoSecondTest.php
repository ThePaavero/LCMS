<?php

use Way\Tests\Assert;
use Way\Tests\Should;

class DemoSecondTest extends TestCase {

	public function testDemoSecond()
	{
		$arg = "goodbye";

		$demoSecond = DemoSecond::demonstrate($arg);
		$returnedString = "You said: " . $arg;

		Assert::equals($returnedString, $demoSecond);
	}

}