<?php
class PhantomFragment
{
	var $doc; // The PhantomDocument (template) this fragment is part of
	var $name = "";
	var $content = "";
	var $params = array();
	var $preparsed = false;
	
	function __construct($fragment_content)
	{
		// Parse fragment name and parameters
		preg_match("/([^\[:]*)(?:\[([^\]]*)\])?:\s*(?:\n|$)(.*)$/us", $fragment_content, $matches);
		
		if (!isset($matches[0]))
		{
			$this->content = $fragment_content;
			$this->name = PhantomDocument::ROOT_FRAGMENT_ALIAS;
			$this->params = array();
		}
		else 
		{
			$this->name = isset($matches[1]) ? $matches[1] : '';
			parse_str(isset($matches[2]) ? $matches[2] : '', $this->params);
			$this->content = isset($matches[3]) ? $matches[3] : '';
		}
	}
	
	function preparse()
	# Pre-parse things the first time the fragment is rendered
	{
		// Replace tag-open and tag-close character sequences with placeholders
		$this->content = $this->doc->tokenizer->convertToPlaceholders($this->content, 
			array('tag-open', 'tag-close'));
		$this->preparsed = true;
	}
	
	function render($data = array())
	{
		if (!$this->preparsed) {
			$this->preparse();
		}
		
		$d2 = array();
		if (isset($this->params["var"]))
		{
			$d2[$this->params["var"]] = isset($data['_metadata']) ? $data['_value'] : $data;
			if (isset($this->params["key"]))
			{
				$d2[$this->params["key"]] = isset($data['_metadata']) ? $data['_key'] : '';
			} 
		}
		elseif (isset($data['_metadata']))
		{
			$d2 = $data['_value'];
		}
		else
		{
			$d2 = $data;
		}
		$data = $d2;
		if (isset($this->params["run"]))
		// Run code behind to preprocess data
		{
			$function_name = !empty($this->params["run"]) ? $this->params["run"] : $this->name;
			include dirname($this->doc->template) . "/" . Path::get_basename($this->doc->template) . ".php";
			${$function_name}($data);
		}
		$fragment_content = $this->content;
		
		if (!isset($this->params["noparse"]))
		{
			$r = $this->doc->tag_placeholder_regex;
			do 
			{
				$fragment = $this;
				$fragment_content = preg_replace_callback("/$r/u",
					function($match) use ($fragment, $data){
						$tag_content = $fragment->parse_tag($match[1], $data);
						return (string)$tag_content;
					}, $fragment_content, -1, $replacements
				);

			} 
			while ($replacements > 0);
		}
		else 
		{
			$fragment_content = preg_replace("/\{/u", "&#123;", $fragment_content);
		}
		
		// Replace any remaining placeholders with their originals
		$fragment_content = $this->doc->tokenizer->convertFromPlaceholders($fragment_content, 
			array('tag-open', 'tag-close'));
			
		return $fragment_content;
	}
	
	function parse_tag($tag, $data)
	// Parses the filter chain within a template
	{
		$tag = trim($tag);
		
		$passthru = null;
		while (mb_strlen($tag) > 0)
		{
			$fragment = $this;
			$tag = preg_replace_callback("/^(.)([^|]*)(?:\|\s*|$)/u", 
				function($match) use ($fragment, $data, &$passthru){
					return $fragment->parse_filter($match[1], trim($match[2]), $data, $passthru);
				}, $tag);
		}
		return $passthru;
	}
	
	function parse_filter($filter, $parameters, $data, &$passthru)
	// Parses a template tag filter
	// A template tag filter is an element in a chain of filters inside a template tag
	{
		foreach ($this->doc->phantom->filters as $filter_function)
		{
			if ($filter_function["filter"] == $filter)
			{
				try
				{
					$func = "PhantomFilter_{$filter_function["function"]}";
					$passthru = $func($parameters, $data, $passthru, $this);
					return "";
				}
				catch (Exception $e)
				{
					throw new VesselException("Failed parsing filter", null, $e, array("filter" => $filter, "parameters" => $parameters, "fragment" => $this->name, "template" => $this->doc->template));
				}
			}
		}
		throw new VesselException("Filter not registered", null, null, array("filter" => $filter, "parameters" => $parameters, "fragment" => $this->name, "template" => $this->doc->template));
	}
}
?>