<?php

namespace Ophp;

class SqlQueryBuilder_Insert extends SqlQueryBuilder {
	protected $into = array();
	protected $set = array();
		
	protected function compileQuery()
	{
		$comments = $this->getCommentsPart();
		$into = $this->getIntoPart();
		$set	= $this->getSetPart();
		$query 	= "$comments\nINSERT $into\n$set";

		$this->setCompiledQuery($query);
		return $query;
	}
	
	public function into($part)
	{
		$this->into[] = $part;
		return $this;
	}
	
	protected function getIntoPart()
	{
		$str = implode("\n", $this->into);
		if (empty($str)) {
			throw new Exception('Into part missing');
		}
		return "INTO $str";
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
