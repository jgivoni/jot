<?php

namespace Replanner;

class AppPackage {
	public function __construct() {
		$this->bootstrap();
		new \Ophp\CorePackage;
		new \Ophp\DbaPackage;
	}
	
	public function getServer() {
		$server = new \Ophp\Server(__DIR__);
		new Routes($server);
		return $server;
	}
	
	public function run() {
		$this->getServer()->handleRequest();
	}
	
	protected function bootstrap() {
		spl_autoload_register(function($class){
			$paths = array(
				'Ophp\CorePackage' => '../ophp/CorePackage.php',

				__NAMESPACE__.'\Routes' => 'Routes.php',
				__NAMESPACE__.'\NotFoundController' => 'controllers/NotFoundController.php',
				__NAMESPACE__.'\TaskController' => 'controllers/TaskController.php',
				__NAMESPACE__.'\IndexController' => 'controllers/IndexController.php',
				__NAMESPACE__.'\NewTaskController' => 'controllers/tasks/NewTaskController.php',
				__NAMESPACE__.'\ViewTaskController' => 'controllers/tasks/ViewTaskController.php',
				__NAMESPACE__.'\EditTaskController' => 'controllers/tasks/EditTaskController.php',
				__NAMESPACE__.'\DeleteTaskController' => 'controllers/tasks/DeleteTaskController.php',
				__NAMESPACE__.'\ListTaskController' => 'controllers/tasks/ListTaskController.php',
				
				__NAMESPACE__.'\AjaxController' => 'controllers/tasks/ajax/AjaxController.php',
				__NAMESPACE__.'\TaskChangePositionController' => 'controllers/tasks/ajax/TaskChangePositionController.php',
				__NAMESPACE__.'\AjaxViewTaskController' => 'controllers/tasks/ajax/AjaxViewTaskController.php',

				__NAMESPACE__.'\TaskModel' => 'models/TaskModel.php',
				__NAMESPACE__.'\TaskMapper' => 'models/TaskMapper.php',
				__NAMESPACE__.'\TaskForm' => 'models/forms/TaskForm.php',
				__NAMESPACE__.'\TaskFilter' => 'models/TaskFilter.php',
				__NAMESPACE__.'\UserModel' => 'models/UserModel.php',
				__NAMESPACE__.'\UserMapper' => 'models/UserMapper.php',
				__NAMESPACE__.'\TaskUserModel' => 'models/TaskUserModel.php',
				__NAMESPACE__.'\TaskUserMapper' => 'models/TaskUserMapper.php',
				__NAMESPACE__.'\ParentUser' => 'models/ParentUser.php',
				__NAMESPACE__.'\JoinUser' => 'models/JoinUser.php',

				__NAMESPACE__.'\HtmlView' => 'view/HtmlViewHelpers.php',
				
				/* engines */
				'Ophp\DbaPackage' => 'libs/DatabaseAdapter/DbaPackage.php',
				'Ophp\FirePhpPackage' => 'libs/FirePHPCore/FirePhpPackage.php',
				
				/* Config */
				__NAMESPACE__.'\DevelopmentConfig' => 'config/DevelopmentConfig.php',
				'EnvironmentConfig' => apache_getenv('ophp.root_config'),
				/* 3rd party libraries */
			);
			if (isset($paths[$class])) {
				require_once __DIR__.'/'.$paths[$class];
			}
		});
	}
}