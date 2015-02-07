<?php

namespace Replanner;

class AppPackage {
	public function __construct() {
		$this->bootstrap();
		new \Ophp\CorePackage;
		new \Ophp\DbaPackage;
		new \Ophp\FilterPackage;
	}
	
	protected function bootstrap() {
		$localPaths = array(
			'AppServer' => 'AppServer.php',
			'AppRouter' => 'AppRouter.php',

			'NotFoundController' => 'controllers/NotFoundController.php',
			'TaskController' => 'controllers/TaskController.php',
			'IndexController' => 'controllers/IndexController.php',
			'NewTaskController' => 'controllers/tasks/NewTaskController.php',
			'ViewTaskController' => 'controllers/tasks/ViewTaskController.php',
			'EditTaskController' => 'controllers/tasks/EditTaskController.php',
			'DeleteTaskController' => 'controllers/tasks/DeleteTaskController.php',
			'ListTaskController' => 'controllers/tasks/ListTaskController.php',

			'AjaxController' => 'controllers/tasks/ajax/AjaxController.php',
			'TaskChangePositionController' => 'controllers/tasks/ajax/TaskChangePositionController.php',
			'AjaxViewTaskController' => 'controllers/tasks/ajax/AjaxViewTaskController.php',

			'TaskModel' => 'models/TaskModel.php',
			'TaskMapper' => 'models/TaskMapper.php',
			'TaskForm' => 'models/forms/TaskForm.php',
			'TaskFilter' => 'models/TaskFilter.php',
			'UserModel' => 'models/UserModel.php',
			'UserMapper' => 'models/UserMapper.php',
			'TaskUserModel' => 'models/TaskUserModel.php',
			'TaskUserMapper' => 'models/TaskUserMapper.php',
			'ParentUser' => 'models/ParentUser.php',
			'JoinUser' => 'models/JoinUser.php',
			'JoinUserTask' => 'models/JoinUserTask.php',

			'HtmlView' => 'view/HtmlViewHelpers.php',

			/* Config */
			'DevelopmentConfig' => 'config/DevelopmentConfig.php',
		);

		$paths = [];
		foreach ($localPaths as $class => $path) {
			$path = __DIR__ . '/' . $path;
			$class = __NAMESPACE__ . '\\' . $class; 
			$paths[$class] = $path;
		}
		$paths['Ophp\CorePackage'] = apache_getenv('ophp.path') . 'CorePackage.php';
		$paths['FirePhp\FirePhpPackage'] = 'libs/FirePHPCore/FirePhpPackage.php';
		$paths[__NAMESPACE__.'\EnvironmentConfig'] = apache_getenv('ophp.root_config');

		spl_autoload_register(function($class) use ($paths) {
			if (isset($paths[$class])) {
				require_once $paths[$class];
			}
		});
	}
}
