<?php

/**
 * Bridge/adaptor(?) between controller and view
 */
class SmartyViewEngine {

	protected $template_dir, $cache_dir;
	
	function __construct($template_dir, $cache_dir) {
		$this->template_dir = $template_dir;
		$this->cache_dir = $cache_dir;
	}

	/**
     *  Parses a template using Smarty engine
     */
	public function render($template, $data = array()) {
	
		$smarty = new Smarty;
		
		$smarty->template_dir = $this->template_dir;
		$smarty->compile_dir = $this->cache_dir;
		$smarty->caching = 0;
		$smarty->force_compile = 1;
		$smarty->compile_check = true;

        $smarty->assign($data);
        
        $output = $smarty->fetch($template);
        
        return $output;
    }
}