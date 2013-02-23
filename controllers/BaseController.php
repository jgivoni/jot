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
	 */
	protected function newDataMapper($model) {
		switch ($model) {
			case 'task':
				$dataMapper = new TaskMapper();
				break;
			default:
				throw new Exception('Unknown model');
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
	 * Returns the full path and filename to the template specified
	 * @param string $template
	 * @return string
	 */
	protected function getFullTemplatePath($template) {
		return $this->getServer()->getAppRootPath() . '/views/' . $template . '.php';
	}

	protected function newView($template) {
		// Make this dependent on ajax
		if (!$this->getRequest()->isAjax()) {
			$view = new \Ophp\ViewFragment($this->getFullTemplatePath($template));
			$view->attachToParent($this->newDocumentView(), 'content');
			return $view;
		} else {
			$view = new ViewDecorator(new View($this->getFullTemplatePath($template)));
			return $view;
		}
	}

	protected function newDocumentView() {
		$self = $this; // Fix for php 5.3
		$document = new \Ophp\HtmlDocumentView($this->getFullTemplatePath($this->baseTemplate), function($template) use ($self) {
					return $self->tmp_newView($template);
				});
		$document->title = "Replanner";
		$document->url = $this->getServer()->getUrlHelper();
		$document->index = new \Ophp\View($this->getFullTemplatePath('task/list.html'));
		$document->index->assign(array(
			'tasks' => $this->getDataMapper('task')->loadAll()
		));
		$document->notifications = 'Was it what you expected?';
		$document->addCssFile($this->getServer()->getUrlHelper()->staticAssets('task/form.css'));
		$document->addCssFile('/static-assets/task/list.css');

		return $document;
	}

	/**
	 * Temporary public wrapper for newView until moving to PHP 5.4
	 * @param type $template
	 * @return \View
	 */
	public function tmp_newView($template) {
		$view = new \Ophp\View($this->getFullTemplatePath($template));
		return $view;
	}

	/**
	 *
	 * @return SqlDatabaseAdapterInterface 
	 */
	protected function getDba() {
		return isset($this->dba) ? $this->dba :
				$this->dba = $this->getServer()->newMysqlDatabaseAdapter('replanner');
	}

}