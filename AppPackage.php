<?php

class AppPackage {
	public function __construct() {
		$this->bootstrap();
		new VesselPackage;
		new DbaPackage;
	}
	
	protected function bootstrap() {
		spl_autoload_register(function($class){
			$paths = array(
				'VesselPackage' => 'vessel/VesselPackage.php',

				'NotFoundController' => 'controllers/NotFoundController.php',
				'BaseController' => 'controllers/BaseController.php',
				'IndexController' => 'controllers/IndexController.php',
				'NewTaskController' => 'controllers/tasks/NewTaskController.php',
				'ViewTaskController' => 'controllers/tasks/ViewTaskController.php',
				'EditTaskController' => 'controllers/tasks/EditTaskController.php',
				'DeleteTaskController' => 'controllers/tasks/DeleteTaskController.php',
				'TaskListController' => 'controllers/tasks/TaskListController.php',
				
				'AjaxController' => 'controllers/tasks/ajax/AjaxController.php',
				'TaskChangePositionController' => 'controllers/tasks/ajax/TaskChangePositionController.php',
				'AjaxViewTaskController' => 'controllers/tasks/ajax/AjaxViewTaskController.php',

				'Model' => 'models/Model.php',
				'TaskModel' => 'models/TaskModel.php',
				'TaskMapper' => 'models/TaskMapper.php',
				'TaskForm' => 'models/forms/TaskForm.php',
				'TaskFilter' => 'models/TaskFilter.php',

				'HtmlView' => 'view/HtmlViewHelpers.php',
				
				/* engines */
				'DbaPackage' => 'libs/DatabaseAdapter/DbaPackage.php',

				/* 3rd party libraries */
			);
			if (isset($paths[$class])) {
				require_once __DIR__.'/'.$paths[$class];
			}
		});
	}
}