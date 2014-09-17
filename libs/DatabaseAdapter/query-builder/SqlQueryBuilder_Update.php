<?php

namespace Ophp;

class SqlQueryBuilder_Update extends SqlQueryBuilder {
	protected $update = array();
	protected $set = array();
		
	protected function compileQuery()
	{
		$update = $this->getUpdatePart();
		$set	= $this->getSetPart();
		$where 	= $this->getWherePart();
		$limit 	= $this->getLimitPart();
		$query 	= "$update\n$set\n$where\n$limit";

		$this->setCompiledQuery($query);
		return $query;
	}
	
	public function update($part)
	{
		$this->update[] = $part;
		return $this;
	}
	
	protected function getUpdatePart()
	{
		$str = implode("\n", $this->update);
		if (empty($str)) {
			throw new Exception('Update part missing');
		}
		return "UPDATE $str";
	}
	
	public function set($part)
	{
		if (!empty($part)) {
			if ($part instanceof SqlExpression) {
				$part = $part->acceptAssembler($this->queryAssembler);
			}
			$this->set[] = $part;
		}
		return $this;
	}
	
	protected function getSetPart()
	{
		$str = implode(",\n", $this->set);
		if (empty($str)) {
			throw new Exception('Set part missing');
		}
		return "SET $str";
	}
}
