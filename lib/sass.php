<?php

	@ini_set('display_errors', 'off');

	define('DOCROOT', rtrim(realpath(dirname(__FILE__) . '/../../../'), '/'));
	define('DOMAIN', rtrim(rtrim($_SERVER['HTTP_HOST'], '/') . str_replace('/extensions/sass_compiler/lib', NULL, dirname($_SERVER['PHP_SELF'])), '/'));

	// Include some parts of the engine
	require_once(DOCROOT . '/symphony/lib/boot/bundle.php');
	require_once(CONFIG);
	
	require_once('dist/SassParser.php');
	
	function processParams($string){
		$param = (object)array(
			'file' => 0
		);

		if(preg_match_all('/^(.+)$/i', $string, $matches, PREG_SET_ORDER)){
			$param->file = $matches[0][1];
		}
		
		return $param;
	}
	
	$param = processParams($_GET['param']);

	$mode = "scss";
	if($_GET['mode'] == "sass")
		$mode = "sass";
	
	header('Content-type: text/css');

	$options = array(
			'style' => 'nested',
			'cache' => FALSE,
			'syntax' => $mode,
			'debug' => FALSE,
			'callbacks' => array(
				'warn' => 'cb_warn',
				'debug' => 'cb_debug',
				),
			);

	$parser = new SassParser($options);
	$css = $parser->toCss(WORKSPACE . '/' . $param->file);
	
	$filename = pathinfo($param->file);
	$filename = $filename['filename'];
	
	file_put_contents(CACHE . '/sass_compiler/' . $filename . '.css', $css);
	
	echo $css;
	
	exit;
