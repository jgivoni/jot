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
				__NAMESPACE__.'\DbaDebugDecorator' => 'DbaDebugDecorator.php',
				__NAMESPACE__.'\SqlDatabaseAdapterInterface' => 'SqlDatabaseAdapterInterface.php',
				__NAMESPACE__.'\SqlDatabaseQuery' => 'SqlDatabaseQuery.php',
				__NAMESPACE__.'\SqlQueryBuilder' => 'query-builder/SqlQueryBuilder.php',
				__NAMESPACE__.'\SqlQueryBuilder_Select' => 'query-builder/SqlQueryBuilder_Select.php',
				__NAMESPACE__.'\SqlQueryBuilder_Update' => 'query-builder/SqlQueryBuilder_Update.php',
				__NAMESPACE__.'\SqlQueryBuilder_Insert' => 'query-builder/SqlQueryBuilder_Insert.php',
				__NAMESPACE__.'\SqlQueryBuilder_Delete' => 'query-builder/SqlQueryBuilder_Delete.php',
				__NAMESPACE__.'\SqlCriteriaBuilder' => 'query-builder/SqlCriteriaBuilder.php',
				__NAMESPACE__.'\SqlCriteriaNode' => 'query-builder/SqlCriteriaNode.php',
				__NAMESPACE__.'\SqlField' => 'query-builder/SqlField.php',
				__NAMESPACE__.'\SqlValue' => 'query-builder/SqlValue.php',
				__NAMESPACE__.'\SqlExpression' => 'query-builder/SqlExpression.php',
				__NAMESPACE__.'\SqlCriteriaNodeGroup' => 'query-builder/SqlCriteriaNodeGroup.php',
				__NAMESPACE__.'\SqlCriteriaNodeInverse' => 'query-builder/SqlCriteriaNodeInverse.php',
				__NAMESPACE__.'\SqlCriteriaNodeCompare' => 'query-builder/SqlCriteriaNodeCompare.php',
				__NAMESPACE__.'\SqlCriteriaAssembler' => 'query-builder/SqlCriteriaAssembler.php',
				
			);
			if (isset($paths[$class])) {
				require_once __DIR__.'/'.$paths[$class];
			}
		});
	}
}