<?php


class DbaPackage {
	public function __construct() {
		$this->bootstrap();
	}
	
	protected function bootstrap() {
		spl_autoload_register(function($class){
			$paths = array(
				'DatabaseAdapter' => 'DatabaseAdapter.php',
				'CacheSqlDatabaseQueryDecorator' => 'CacheSqlDatabaseQueryDecorator.php',
				'DebugSqlDatabaseQueryDecorator' => 'DebugSqlDatabaseQueryDecorator.php',
				'DbQueryResult' => 'DbQueryResult.php',
				'MysqlDatabaseAdapter' => 'MysqlDatabaseAdapter.php',
				'SqlDatabaseAdapterInterface' => 'SqlDatabaseAdapterInterface.php',
				'SqlDatabaseQuery' => 'SqlDatabaseQuery.php',
				'SqlQueryBuilder' => 'SqlQueryBuilder.php',
				'SqlQueryBuilder_Select' => 'SqlQueryBuilder.php',
				'SqlQueryBuilder_Update' => 'SqlQueryBuilder.php',
				'SqlQueryBuilder_Delete' => 'SqlQueryBuilder.php',
			);
			if (isset($paths[$class])) {
				require_once __DIR__.'/'.$paths[$class];
			}
		});
	}
}