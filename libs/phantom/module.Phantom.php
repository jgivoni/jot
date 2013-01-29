<?php 

class PhantomModule extends VesselModule
{
	var $file = __FILE__;
	var $name = "phantom";
	
	function setup()
	{
		$this->import_function("PhantomFilter");
		$this->import_function("PhantomModifier");
	}
}


?>