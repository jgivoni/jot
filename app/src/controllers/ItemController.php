<?php

namespace Replanner\controllers;

/**
 * 
 * An abstract base class for all controllers within this app
 */
abstract class ItemController extends \Ophp\Controller {

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
		$dataMapper = new ItemMapper;
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
	protected function getItemMapper() {
		return $this->getDataMapper('item');
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

	/**
	 * Returns a new document
	 * @return \Ophp\HtmlDocumentView
	 */
	protected function newDocumentView() {
		$document = new \Ophp\HtmlDocumentView($this->baseTemplate, $this->getTemplateBase());
		$document->title = "Replanner";
		$document->url = $this->getServer()->getUrlHelper();
		$document->index = $document->fragment('task/list.html');
		$document->index->assign([
//			'tasks' => $this->getTaskUserMapper()->loadAllOrdered(),
			'tasks' => [],
		]);
		$document->notifications = 'Was it what you expected?';
		$staticAssets = $this->getServer()->getUrlHelper()->staticAssets;
		
		$document->addCssFile($staticAssets('global.css'));
		$document->addCssFile($staticAssets('task/view.css'));
		$document->addCssFile($staticAssets('task/form.css'));
		$document->addCssFile($staticAssets('task/list.css'));
		$document->addCssFile($staticAssets('jquery-ui/css/humanity/jquery-ui-1.8.19.custom.css'));
		$document->addCssFile($staticAssets('chosen_v1.1.0/chosen.min.css'));
		
		$document->addJsFile($staticAssets('jquery-ui/js/jquery-1.7.2.min.js'));
		$document->addJsFile($staticAssets('jquery-ui/js/jquery-ui-1.8.19.custom.min.js'));
		$document->addJsFile($staticAssets('jquery-ui/js/jquery.history.js'));
		$document->addJsFile($staticAssets('chosen_v1.1.0/chosen.jquery.min.js'));
		$document->addJsFile($staticAssets('task/tasks.js'));
		return $document;
	}

	/**
	 *
	 * @return SqlDatabaseAdapterInterface 
	 */
	protected function getDba() {
		return isset($this->dba) ? $this->dba :
			$this->dba = $this->getServer()->newDynamoDbDatabaseAdapter('replanner_item');
	}

	/**
	 * Returns a new response from the controller
	 * @param \Ophp\View $view
	 * @return \Ophp\HttpResponse
	 */
	protected function newResponse(\Ophp\View $view = null) {
		$response = parent::newResponse();
		if (isset($view)) {
			$response->body($view->top());
		}
		return $response;
	}
}