<?php
abstract class BaseController extends Controller {
	
	/**
	 * @var View
	 */
	protected $baseView;
	protected $baseTemplate = 'base.html';

	/**
	 * Returns a new instance of the data mapper for $model
	 * 
	 * @param string $model Model name
	 * @return dataMapper
	 */
	protected function newDataMapper($model) {
		$dataMapperClass = ucfirst($model).'Mapper';
		$dataMapper = new $dataMapperClass;
		$dataMapper->setDba($this->getDba());
		return $dataMapper;
	}
	
	/**
	 * Returns a shared instance of the data mapper for $model
	 * 
	 * @param string $model Model name
	 * @return dataMapper
	 */
	protected function getDataMapper($model) {
		return isset($this->dataMappers[$model]) ? 
			$this->dataMappers[$model] :
			$this->dataMappers[$model] = $this->newDataMapper($model);
	}


	protected function newResponse() {
		$res = !$this->isAjaxRequest() ? new HtmlResponse() : new JsonResponse;
		return $res;
	}

	protected function newSmartyView() {
		$view = new SmartyViewEngine($this->getServer()->base_path . '/views', $this->getServer()->base_path . '/cache');
		return $view;
	}
	
	protected function getFullTemplatePath($template) {
		return $this->getServer()->base_path . '/views/'.$template.'.php';
	}
	
	protected function newView($template) {
		// Make this dependent on ajax
		if (!$this->isAjaxRequest()) {
			$view = new PartialView($this->getFullTemplatePath($template));
			$view->attachToParent($this->newDocumentView(), 'content');
			return $view;
		} else {
			$view = new ViewDecorator(new View($this->getFullTemplatePath($template)));
			return $view;
		}
	}
	
	protected function newDocumentView() {
		$self = $this; // Fix for php 5.3
		$document = new HtmlDocumentView($this->getFullTemplatePath($this->baseTemplate), function($template) use ($self) {
			return $self->tmp_newView($template);
		});
		$document->url = $this->getServer()->getUrlHelper();
		$document->index = new View($this->getFullTemplatePath('task/list.html'));
		$document->index->assign(array(
			'tasks' => $this->getDataMapper('task')->loadAll()
		));
		$document->notifications = 'Was it what you expected?';
		$document->addCssFile('/static-assets/task/form.css');
		$document->addCssFile('/static-assets/task/list.css');
		
		return $document;
	}

	/**
	 * Temporary public wrapper for newView until moving to PHP 5.4
	 * @param type $template
	 * @return \View
	 */
	public function tmp_newView($template) {
		$view = new View($this->getFullTemplatePath($template));
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
	
	protected function isAjaxRequest()
	{
		return $this->getRequest()->isAjax();
	}
	
}