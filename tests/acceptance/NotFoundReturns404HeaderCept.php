<?php

$I = new WebGuy($scenario);
$I->wantTo('ensure that the not found page returns 404 Not Found');
$I->amOnPage('/aaaaaaaaaaaaaaaabbbcccccccc');
$I->seeResponseCodeIs(404);