<?php

namespace Ophp;

class DbaPackage {
	public function __construct() {
		$this->bootstrap();
	}
	
	protected function bootstrap() {
		spl_autoload_register(function($class){
			$paths = array(
				__NAMESPACE__.'\DatabaseAdapter' => 'DatabaseAdapter.php',
				__NAMESPACE__.'\CacheSqlDatabaseQueryDecorator' => 'CacheSqlDatabaseQueryDecorator.php',
				__NAMESPACE__.'\DebugSqlDatabaseQueryDecorator' => 'DebugSqlDatabaseQueryDecorator.php',
				__NAMESPACE__.'\DbQueryResult' => 'DbQueryResult.php',
				__NAMESPACE__.'\MysqlDatabaseAdapter' => 'MysqlDatabaseAdapter.php',
				__NAMESPACE__.'\SqlDatabaseAdapterInterface' => 'SqlDatabaseAdapterInterface.php',
				__NAMESPACE__.'\SqlDatabaseQuery' => 'SqlDatabaseQuery.php',
				__NAMESPACE__.'\SqlQueryBuilder' => 'SqlQueryBuilder.php',
				__NAMESPACE__.'\SqlQueryBuilder_Select' => 'SqlQueryBuilder.php',
				__NAMESPACE__.'\SqlQueryBuilder_Update' => 'SqlQueryBuilder.php',
				__NAMESPACE__.'\SqlQueryBuilder_Insert' => 'SqlQueryBuilder.php',
				__NAMESPACE__.'\SqlQueryBuilder_Delete' => 'SqlQueryBuilder.php',
			);
			if (isset($paths[$class])) {
				require_once __DIR__.'/'.$paths[$class];
			}
		});
	}
}