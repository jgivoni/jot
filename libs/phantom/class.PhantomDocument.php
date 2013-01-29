<?php
class PhantomDocument
// The object that holds a document template
{
	var $phantom; // The parser controller
	var $template; // The filename of the template
	var $data = array(); // Injected data
	var $parent; // A PhantomDocument that this document extends
	var $child; // The PhantomDocument that extended this document
	
	var $imports = array(); // Imported PhantomDocuments
	var $fragments = array(); // Fragments in this template array of PhantomFragments

	var $docdef; // Configuration object holding parsing and encoding information about the current document
	var $tokenizer; // Tokenizer object, which will help us parse tags into placeholders
	var $tag_placeholder_regex; // Regular expression used for parsing template tags after placeholder conversion
	var $preparsed = false;
	
	const ROOT_FRAGMENT_ALIAS = '__ROOT__'; 
	
	function __construct($template)
    // $template: Full path to template file 
	{
		$this->template = $template;
		$this->docdef = new Configuration;
		$this->merge_docdef(__DIR__.'/docdef.ini');
	}
	
	// Top returns the topmost document template, by recursing up
	function top(){
		return isset($this->child) ? $this->child->top() : $this;
	}
	
	private function merge_docdef($file){
		$docdef = parse_ini_file($file);
		foreach ($docdef as $key => $value) {
			$this->docdef->set($key, $value);
		}
	}
	
	function preparse()
	{
		if ($this->preparsed) return;
		
		$template = $this->template;
		
		// Load template content
		if (file_exists($template)) {
			$template_content = file_get_contents($template);
		} else {
			throw new VesselException("Template not found", null, null, array("template" => $template));
		}
		
		// Resolve constants
		$this->phantom->const->set('%dir', dirname($this->template));
		$template_content = $this->phantom->resolve_constants($template_content);
		
		// Parse system tags (extends and imports) and remove from content
		$template_content = $this->parse_system_tags($template_content);
		
		// Prepare tokenizer
		$this->tokenizer = new Tokenizer(array(
			'tag-open' => $this->docdef->get('tag-open'),
			'tag-close' => $this->docdef->get('tag-close')
		));
		$s = $this->tokenizer->getPlaceholderRegex('tag-open');
		$e = $this->tokenizer->getPlaceholderRegex('tag-close');
		$this->tag_placeholder_regex = "$s([^$s$e\n]*)$e";
		
		// Split into fragments
		// TODO: Let this be configured in docdef as well
		$fragments = preg_split("/(^|\n)\s*##(?=[^:\n]*:\s*(\n|$))/su", $template_content);
		
		foreach ($fragments as $fragment) {
			if (trim($fragment)) {
				$f = $this->new_fragment($fragment);
				$name = !empty($f->name) ? $f->name : PhantomDocument::ROOT_FRAGMENT_ALIAS;
				$this->fragments[$name] = $f;
			}
		}
		
		$this->preparsed = true;
	}
	
	function new_fragment($fragment_content)
	// Creates a new PhantomFragment object
	// fragment_content is the whole block - the object will parse out name and parameters
	{
		$f = new PhantomFragment($fragment_content);
		$f->doc = &$this;
		return $f;
	}
	
	function render($data = array())
	// Renders the template with injected data
	{		
		// TODO: Preparse data (replace tokens with placeholders)
		$this->data = $data;
		
		// Rendering first fragment
		try	{
			$doc = $this->render_fragment(PhantomDocument::ROOT_FRAGMENT_ALIAS, $data);
		} catch (Exception $e) {
			throw new VesselException("Failed rendering template", null, $e, array("template" => $this->template));
		}
			
		return $doc;
	}	
	
	function render_fragment($name, $data)
	/* Calls a fragment filter. This involves rendering the fragment one or more times in various documents */
	// Renders the fragment identified by $name with injected $data
	/* Possible naming patterns:
			{#fragment} (fragment in top template)
			{#.fragment} (fragment in this template)
			{#:fragment} (fragment in parent template)
			{#import.fragment} (fragment in imported template)
			{#*.fragment} (fragment in all imported templates (not this))
	*/
	{	
		$name = !empty($name) ? $name : PhantomDocument::ROOT_FRAGMENT_ALIAS;
		if (mb_strpos($name, ":") === 0) {
			$name = mb_substr($name, 1);
			$f = $this->render_fragment_parent($name, $data);
		} elseif (mb_strpos($name, ".") !== false) {
			$f = $this->render_fragment_import($name, $data);
		} else {
			$f = $this->render_fragment_top($name, $data);
		}	
		return $f;
	}
	
	function render_fragment_here($name, $data) 
	{
		$this->preparse();
		if (isset($this->fragments[$name])) {
			$f = $this->fragments[$name]->render($data);
		} else {
			$f = $this->render_fragment_parent($name, $data);
		}
		return $f;		
	}
	
	function render_fragment_top($name, $data)
	// Renders the fragment by name in the top document template
	// {#fragment} Default behavior when fragment name is not preceded by any notation
	{
		$this->preparse();
		$f = $this->top()->render_fragment_here($name, $data);
		return $f;
	}
	
	function render_fragment_import($name, $data)
	// Renders the fragment by name in this or some importet document template
	// {#.fragment} {#*.fragment} {#import.fragment}
	{
		$this->preparse();
		list($import, $fragment) = explode(".", $name, 2);
			
		if (empty($import))	{
			$f = $this->fragments[$fragment]->render($data);
		} elseif ($import == "*") {
			$f = "";
			try	{
				foreach ($this->imports as $import)	{
					$f .= $import->render_fragment($fragment, $data);
				}
			} catch(Exception $e) {
				// That's ok, no need to throw an error
			}
		} elseif (isset($this->imports[$import])) {
			$f = $this->imports[$import]->render_fragment($fragment, $data);
		} else {
			throw new VesselException("Template not imported", null, null, array("import" => $import, 
				'fragment' => $name, "template" => $this->template));
		}
		return $f;
	}
	
	function render_fragment_parent($name, $data)
	// Renders the fragment by name in the parent document template
	// {#:fragment}
	{
		$this->preparse();
		if (isset($this->parent)) {
			$f = $this->parent->render_fragment_here($name, $data);
		} else {
			throw new VesselException("This template doesn't have any parent", null, null, array("template" => $this->template));
		}
		return $f;
	}
	
	function parse_system_tags($template_content)
	// System tags are the extend and import tags
	// {!extend...} {!import...as...} which has to appear at the beginning of the document
	// {!docdef...}
	// They will be parsed and replaced by empty strings, before content is returned
	{
		do {	
			$doc = $this;
			$template_content = preg_replace_callback("/^\s*\{!([^\s]+)\s+([^{}]*)\}/u", 
				function($match) use ($doc){
					return $doc->parse_system_tag($match[1], $match[2]);
				}, 
				$template_content, 1, $replacements);
		} 
		while ($replacements > 0);
		return $template_content;
	}
	
	function parse_system_tag($tag, $parameters)
	{
		$tag = strtolower($tag);
		if ($tag == "extend") {
			if (!isset($this->parent)) {
				$this->parent = $this->phantom->new_document($parameters);
				$this->parent->child = $this;
				$d = $this;
				$this->parent->docdef->for_each(function($key)use($d){
					if ($d->docdef->get($key) === null) {
						$d->docdef->set($key, $d->parent->docdef->get($key));
					}
				});
			} else {
				throw new VesselException("Only one extend allowed", null, null, array("template" => $parameters));
			}
		}
		elseif ($tag == "import")
		{
			list($document, $import_name) = explode(" as ", $parameters);
			$this->imports[$import_name] = $this->phantom->new_document($document);
		}
		elseif ($tag == "docdef")
		{
			// Get parser rules from ini file
			$filename = $parameters;
			if (file_exists($filename)) {
				$docdef = parse_ini_file($filename);
				foreach ($docdef as $key => $value) {
					$this->docdef->set($key, $value);
				}
			} else {
				throw new VesselException("Docoment definition file not found", null, null, array("docdef" => $filename,
					'template' => $this->template));
			}
		}
		else 
		{
			throw new VesselException("System tag not understood", null, null, array("tag" => $tag,
				'template' => $this->template));
		}
		return "";
	}	
}
?>