<?php

function PhantomModifier_isArray($parameters, $passthru)
{
	return is_array($passthru);
}

function PhantomModifier_is($parameters, $passthru)
{
	if (isset($parameters["gt"]) && !($passthru > $parameters["gt"]))
	{
		return false;
	}
	if (isset($parameters["lt"]) && !($passthru < $parameters["lt"]))
	{
		return false;
	}
	if (isset($parameters["eq"]) && !($passthru == $parameters["eq"]))
	{
		return false;
	}
	return true;
}

function PhantomModifier_json($parameters, $passthru)
{
	return json_encode($passthru);
}

function PhantomModifier_context($parameters, $passthru)
{
	if (isset($parameters["xmlLiteral"]))
	// Quoted xml data (all symbols ampersand encoded)
	{
		$passthru = PhantomModifier_ampEncode($passthru, "all");
		return $passthru;
	}
	elseif (isset($parameters["xmlChData"]))
	// Character data; only characters, no markup
	{
		$passthru = PhantomModifier_context($passthru, "xmlBlock"); // Make sure it's a valid xml block
		$passthru = PhantomModifier_stripTags($passthru, "all"); // Strip all tags
		return $passthru;
	}
	elseif (isset($parameters["xmlBlock"]))
	// One or more blocks of valid xml
	{
		// If it's already a valid xml block, we assume all markup is really markup and not literal text
		// If it's NOT a valid xml block, we assume all markup is literal text
		if (!is_valid_xml($passthru))
		// Convert to valid xml block by encoding all non valid characters to html entities and wrap it in a block element
		{
			$passthru = PhantomModifier_context($passthru, "xmlLiteral");
			$passthru = "<div>$passthru</div>";
		}
		$passthru = PhantomModifier_utf8Encode($passthru, "safe");
		return $passthru;
	}
	elseif (isset($parameters["xmlInline"]))
	// Character data and inline elements
	{
		$passthru = PhantomModifier_context($passthru, "xmlBlock"); // Make sure it's a valid xml block
		$passthru = PhantomModifier_stripTags($passthru, "keepInline"); // Strip all non-inline tags
		return $passthru;
	}
	elseif (isset($parameters["xmlAttrVal"]))
	// Text suitable for attribute values. Character data with quotes escaped (amp-encoded)
	{
		$passthru = PhantomModifier_context($passthru, "xmlChData");
		$passthru = PhantomModifier_ampEncode($passthru, "quotes"); // Escape all quotes
		return $passthru;
	}
	elseif (isset($parameters["emailSubject"]))
	// No xml encoding of characters
	{
		$passthru = PhantomModifier_context($passthru, "xmlNone");
		return $passthru;
	}
	elseif (isset($parameters["xmlNone"]))
	// Not part of an xml document, just plain readable utf8 encoded text
	// Useful for email subjects, url paths and other parts that won't be processed through an html decoder before viewed
	{
		$passthru = PhantomModifier_context($passthru, "xmlChData");
		$passthru = PhantomModifier_utf8Encode($passthru, "all");
		return $passthru;
	}
	elseif (isset($parameters["utf8PlainText"]))
	{
		$passthru = PhantomModifier_context($passthru, "xmlNone");
		return $passthru;
	}
	elseif (isset($parameters["icalValue"]))
	// Formatted for use in ics iCal file, ",", ";" and "\" escaped
	{
		$passthru = PhantomModifier_context($passthru, "utf8PlainText");
		$passthru = preg_replace("/([,;\\\\])/u", "\\\\$1", $passthru);
		$passthru = preg_replace("/(\\n)/u", "\\n", $passthru);
		return $passthru;
	}
	elseif (isset($parameters["urlQueryVal"]))
	{
		return rawurlencode($passthru);
	}
}
?>