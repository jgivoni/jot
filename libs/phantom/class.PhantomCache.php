<?php

class PhantomCache
{
	function preload($document_hash)
	// Preloads the phantom cache fragments associated with the document_hash
	{	
		if (!PHANTOM_CACHE_USE_APC)
		{	
			$usage = new PhantomCache_DocumentFragments();
			$usage->add_criteria("document_hash", " = '$document_hash'");
			$usage->add_criteria("expiry", "> '" . date("Y-m-d H:i:s") ."'");
			$usage->load_set(0, 0);
			while ($usage->loop())
			{
				PhantomCache::set($usage->get_record());
			}
		}
	}
	
	function remove($document_hash)
	// Removes the current document_hash association entries
	{
		if (!PHANTOM_CACHE_USE_APC)
		{
			$sql = "DELETE FROM " . ATLAS_CFG_DB_PREFIX . "PhantomCache_DocumentFragments WHERE document_hash = '$document_hash'";
			AtlasObj::query($sql);
		}
		else 
		{
			apc_clear_cache("user");
		}
	}
	
	function store($document_hash)
	// Stores all unsaved fragments in the database
	{
		if (!PHANTOM_CACHE_USE_APC)
		{
			$phantom_cache = PhantomCache::set(null, "getall");
			$phantom_cache = rows::sort_by($phantom_cache, "parse_time", true);
	
			$i = 0;
			foreach ($phantom_cache as $row)
			{
				if (!empty($row["unsaved"]))
				{
					// Check if transformation has been saved (by another template file) and updates or inserts it
					$fragment = new PhantomCache_Fragment();
					$fragment->load_by_multiple(array("fragment_location" => $row["fragment_location"],
													"dependencies_hash" => $row["dependencies_hash"]));
					$fragment->set_record($row);
					$fragment->commit();
					
					$usage = new PhantomCache_DocumentFragments();
					if (!$usage->load_by_multiple(array("document_hash" => $document_hash,
														"fragment_id" => $fragment->id())))
					{
						$usage->set("document_hash", $document_hash);
						$usage->set("fragment_id", $fragment->id());
						$usage->register();
					}
					$row["unsaved"] = null;
				}
				$i++;
				if ($i > 10) break;
			}
		}
	}
				
	function set($fragment, $mode = "set")
	{
		global $ses;
		if (empty($ses->cfg["phantom_use_db_cache"]))
			return;
		$fragment_location = $fragment["fragment_location"];
		$dependencies_hash = $fragment["dependencies_hash"];
		$entry = $fragment_location . $dependencies_hash;

		if (PHANTOM_CACHE_USE_APC)
		{
			$ttl = strtotime($fragment["expiry"]) - time(); // Time-to-live
			apc_store("PHANTOM_CACHE_FRAGMENT_$entry", $fragment, $ttl);
		}
		else 
		{
			static $phantom_cache = array();
			
			if ($mode == "getall")
				return $phantom_cache;
			
			if ($mode == "set")
				$phantom_cache[$entry] = $fragment;
			elseif ($mode == "get")
				return isset($phantom_cache["$fragment_location#$dependencies_hash"]) ? $phantom_cache["$fragment_location#$dependencies_hash"] : null;
		}
	}
	
	function get($fragment_location, $dependencies_hash)
	{
		global $ses;
		if (empty($ses->cfg["phantom_use_db_cache"]))
			return null;

		if (PHANTOM_CACHE_USE_APC)
		{
			$entry = $fragment_location . $dependencies_hash;
			$fragment = apc_fetch("PHANTOM_CACHE_FRAGMENT_$entry");
			//print_r($fragment);
			return $fragment;
		}
		else
			return PhantomCache::set(array("fragment_location" => $fragment_location, "dependencies_hash" => $dependencies_hash), "get");
	}
}
				
class PhantomCache_DocumentFragments extends AtlasRecordSet 
{
	function PhantomCache_DocumentFragments($table = "PhantomCache_DocumentFragments")
	{
		$this->__call_parent(__CLASS__, __FUNCTION__, array("table" => $table));
	}
	
}

class PhantomCache_Fragment extends AtlasRecordSet 
{
	function PhantomCache_Fragment($table = "PhantomCache_Fragment")
	{
		$this->__call_parent(__CLASS__, __FUNCTION__, array("table" => $table));
	}
	
}

define("PHANTOM_HEADER_EXPIRES_DEFAULT", 1440); // Default time to live in minutes (1440m = 60 * 24 = 24h)
define("PHANTOM_CACHE_USE_APC", apc_cache_info() ? true : false);
?>