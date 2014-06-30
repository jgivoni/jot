<?php

namespace Ophp;

class FirePhpPackage {
	public function __construct() {
		$this->bootstrap();
	}
	
	protected function bootstrap() {
		spl_autoload_register(function($class){
			$paths = array(
				'FirePHP' => 'FirePHP.class.php',
				'FB' => 'fb.php',
			);
			if (isset($paths[$class])) {
				require_once __DIR__.'/'.$paths[$class];
			}
		});
	}
}