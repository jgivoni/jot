<?php

namespace Replanner;

/**
 * 
 * An abstract base class for all controllers within this app
 */
abstract class BaseController extends \Ophp\Controller {

	/**
	 * @var View
	 */
	protected $baseView;
	protected $baseTemplate = 'base.html';

	/**
	 * List of shared data mappers
	 * @var array
	 */
	protected $dataMappers = array();

	/**
	 * Returns a new instance of the data mapper for $model
	 * 
	 * @param string $model Model name
	 * @return \Ophp\dataMapper
	 * @todo Wrap in factory - be more specific about return type
	 */
	protected function newDataMapper($model) {
		switch ($model) {
			case 'task':
				$dataMapper = new TaskMapper;
				break;
			case 'taskUser':
				$dataMapper = new TaskUserMapper;
				break;
			default:
				throw new \Exception('Unknown model');
		}
		$dataMapper->setDba($this->getDba());
		return $dataMapper;
	}

	/**
	 * Returns a shared instance of the data mapper for $model
	 * 
	 * @param string $model Model name
	 * @return \Ophp\dataMapper
	 */
	protected function getDataMapper($model) {
		return isset($this->dataMappers[$model]) ?
				$this->dataMappers[$model] :
				$this->dataMappers[$model] = $this->newDataMapper($model);
	}

	/**
	 * 
	 * @return TaskMapper
	 */
	protected function getTaskMapper() {
		return $this->getDataMapper('task');
	}
	
	/**
	 * 
	 * @return TaskUserMapper
	 */
	protected function getTaskUserMapper() {
		return $this->getDataMapper('taskUser');
	}


	/**
	 * Returns the full path and filename to the template specified
	 * @param string $template
	 * @return string
	 */
	protected function getFullTemplatePath($template) {
		return $this->getServer()->getAppRootPath() . '/views/' . $template . '.php';
	}
	
	protected function getTemplateBase() {
		return $this->getServer()->getAppRootPath() . '/views/';
	}

	protected function newView($template) {
		if (!$this->getRequest()->isAjax()) {
			$document = $this->newDocumentView();
			$view = $document->fragment($template);
			$document->assign(['content' => $view]);
		} else {
			$view = new \Ophp\View($template, $this->getTemplateBase());
		}
		return $view;
	}

	protected function newDocumentView() {
		$document = new \Ophp\HtmlDocumentView($this->baseTemplate, $this->getTemplateBase());
		$document->title = "Replanner";
		$document->url = $this->getServer()->getUrlHelper();
		$document->index = $document->fragment('task/list.html');
		$document->index->assign([
//			'tasks' => $this->getTaskMapper()->loadAllOrdered(),
			'tasks' => $this->getTaskUserMapper()->loadAllOrdered(),
		]);
		$document->notifications = 'Was it what you expected?';
		$document->addCssFile($this->getServer()->getUrlHelper()->staticAssets('task/form.css'));
		$document->addCssFile($this->getServer()->getUrlHelper()->staticAssets('task/view.css'));
		$document->addCssFile($this->getServer()->getUrlHelper()->staticAssets('task/list.css'));
		$document->addJsFile($this->getServer()->getUrlHelper()->staticAssets('task/tasks.js'));

		return $document;
	}

	/**
	 *
	 * @return SqlDatabaseAdapterInterface 
	 */
	protected function getDba() {
		return isset($this->dba) ? $this->dba :
				$this->dba = $this->getServer()->newMysqlDatabaseAdapter('replanner');
	}

	protected function newResponse(\Ophp\View $view = null) {
		$response = parent::newResponse();
		if (isset($view)) {
			$response->body($view->top());
		}
		return $response;
	}
}