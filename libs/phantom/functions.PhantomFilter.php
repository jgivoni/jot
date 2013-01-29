<?php

function PhantomFilter_Variable($parameters, $data, $passthru, $f)
// $parameters: the filter string
// $data: the injected data
// $passthru: output from previous filter in chain
// $f: the current fragment
{
	if (is_array($passthru) && is_array($data))
	{
		$data = array_merge($data, $passthru);
	}
	$key = trim($parameters);
	if (isset($data[$key]))
	{
		$val = $data[$key];
	}
	elseif (strpos($key, "/") !== false)
	{
		list($key, $parameters) = explode("/", $key, 2);
		$val = isset($data[$key]) ? PhantomFilter_Variable($parameters, $data[$key], $passthru, $f) : null;
	}
	else
	{
		$val = null;
	}
	
	return $val;
}

function PhantomFilter_String($parameters, $data, $passthru, $f)
{
	return $parameters;
}

function PhantomFilter_Fragment($parameters, $data, $passthru, $f)
{
	$name = trim($parameters);
	if (!empty($passthru))
	{
		$data = $passthru;
	}
	return $f->doc->render_fragment($name, $data);		
}

function PhantomFilter_FragmentIterator($parameters, $data, $passthru, $f)
{
	$name = trim($parameters);
	if (!empty($passthru))
	{
		$data = $passthru;
	}
	$str = "";
	if (!is_array($data)){
		throw new VesselException("Data must be an array for FragmentIterator", null, null, array("data" => $data));
	}
	foreach ($data as $key => $value)
	{
		$str .= $f->doc->render_fragment($name, $value);
	}
	return $str;
}

function PhantomFilter_Iterator($parameters, $data, $passthru, $f)
{
	$name = trim($parameters);
	
	if (!is_array($passthru)){
		throw new VesselException("Passthru must be an array for PhantomFilter Iterator", null, null, array("passthru" => $passthru));
	}
	$str = "";
	$i = 0;
	foreach ($passthru as $key => $data)
	{
		$metadata = array(
			'_metadata' => true,
			'_i' => $i,
			'_n' => $i+1,
			'_key' => $key,
			'_value' => $data
		);
		
		$str .= $f->parse_tag($name, $metadata);
		++$i;
	}
	return $str;
}

function PhantomFilter_Conditional($parameters, $data, $passthru, $f)
{
	$parts = explode(":", $parameters, 2);
	
	if ($passthru)
	{
		return $f->parse_tag($parts[0], $data);
	}
	elseif (isset($parts[1])) 
	{
		return $f->parse_tag($parts[1], $data);
	}
}

function PhantomFilter_Parameters($parameters, $data, $passthru, $f)
{
	$parameters = preg_replace("/]\s*$/u", "", $parameters);
	parse_str($parameters, $data);
	return $data;
}

function PhantomFilter_NamedModifier($parameters, $data, $passthru, $f)
{
	if (mb_strpos($parameters, ":") !== false)
	{
		list($modifierName, $modifierParameters) = explode(":", $parameters, 2);
		parse_str($modifierParameters, $modifierParametersArray);
	}
	else 
	{
		$modifierName = $parameters;
		$modifierParametersArray = array();
	}
	$modifierFunction = "PhantomModifier_$modifierName";
	return $modifierFunction($modifierParametersArray, $passthru);
}

function PhantomFilter_Comment($parameters, $data, $passthru, $f)
{
	return "";
}

function PhantomFilter_Constant($parameters, $data, $passthru, $f)
{
	$key = trim($parameters);
	return $f->doc->phantom->const->get($key, CONFIGURATION_SETTING_GET_CLIENT);
}
?>