<?php
class PhantomController
// The object that controls the documents
{
	var $const; // Configuration object ($cfg from PhantomModule)
	var $language;
	var $available_languages = array();
	var $start_tag = "{";
	var $end_tag = "}";
	var $start_tag_quoted, $end_tag_quoted;
	var $tag_regex;
	var $encoding = "UTF8";
	var	$default_template = "{%currentScript}.tpl";
	var $filters = array();
	var $lazyLoader;
	
	function __construct($parameters = array())
	{
		$this->configure($parameters);
		
		$s = $this->start_tag_quoted = preg_quote($this->start_tag);
		$e = $this->end_tag_quoted = preg_quote($this->end_tag);
		$this->tag_regex = "$s([^$s$e\n]*)$e";
	}
	
	function resolve_constants($str)
	{
		$s = $this->start_tag_quoted;
		$e = $this->end_tag_quoted;
		$const = $this->const;
		do
		{
			$str = preg_replace_callback("/$s%([^$s$e\|]+)$e/u",
				function($match) use ($const) { 
					return $const->get($match[1]);
				}, 
				$str, -1, $replacements);
		}
		while ($replacements > 0);
		return $str;
	}
	
	private function configure($parameters = array())
	{
		foreach ($parameters as $key => $val)
		{
			if (property_exists($this, $key))
			{
				$this->$key = $val;
			}
		}
	}
	
	function new_document($template = "", $data = array())
	// Returns a new PhantomDocument object
	{
		if (empty($template))
		{
			$template = $this->default_template;
		}
		$doc = new PhantomDocument($template, $data);
		$doc->phantom = $this;
		$doc->preparse();
		return $doc;
	}
	
	function new_string(){}
	
	function register_tag(){}
	
	function register_filter($filter, $function)
	{
		array_push($this->filters, array("filter" => $filter, "function" => $function));
	}
	
	function register_modifier(){}
}

?>