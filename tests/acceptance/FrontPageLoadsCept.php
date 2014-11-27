<?php

$I = new WebGuy($scenario);
$I->wantTo('ensure that the frontpage returns 200 OK');
$I->amOnPage('/');
$I->seeResponseCodeIs(200);