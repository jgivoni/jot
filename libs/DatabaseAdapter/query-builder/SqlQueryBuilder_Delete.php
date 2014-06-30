<?php

namespace Ophp;

class SqlQueryBuilder_Delete extends SqlQueryBuilder {
	protected function compileQuery()
	{
		$delete = $this->getDeletePart();
		$from	= $this->getFromPart();
		$where	= $this->getWherePart();
		$limit	= $this->getLimitPart();
		$query 	= "$delete\n$from\n$where\n$limit";

		$this->setCompiledQuery($query);
		return $query;
	}
	
	protected function getDeletePart()
	{
		return "DELETE";
	}
}
