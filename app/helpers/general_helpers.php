<?php

/**
 * Collection of BASIC functions to help everyday development.
 * DO NOT put larger functions here that could be made into their own libraries.
 * Files in the helpers-folder are automatically loaded by Composer.
 */

/**
 * Give timestamp, receive it formatted differently.
 * @param  string $ts A timestamp
 * @return string     A differently-formatted timestamp
 */

function parseTimestamp($ts)
{
	return date('j.n.Y', strtotime($ts));
}

function activeLink()
{

}