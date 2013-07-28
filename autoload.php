<?php
function __autoload($class)
{
	if (0 !== strpos($class, 'Twig')) {
		list($type) = explode('_', $class);
		$file = 'Classes/' . $type . '/' . $class . '.php';
	} else {
		$file = dirname(__FILE__).'/Twig/lib/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php';
	}


	require_once($file);
}


