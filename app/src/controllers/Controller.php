<?php

namespace Replanner\controllers;

/**
 * 
 * An abstract base class for all controllers within this app
 */
abstract class Controller extends \Ophp\Controller {

	/**
	 * Id of the authenticated user
	 * @var int
	 */
	protected $currentUserId = 1;
	
	/**
	 * @var View
	 */
	protected $baseView;
	protected $baseTemplate = 'base.html';

	
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

	/**
	 * 
	 * @param string $template
	 * @return \Ophp\view
	 */
	protected function newView($template) {
		$document = $this->newDocumentView();
		$view = $document->fragment($template);
		$document->assign(['content' => $view]);
		return $document;
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
			'tasks' => [],
		]);
		$document->notifications = 'Was it what you expected?';
		$staticAssets = $this->getServer()->getUrlHelper()->staticAssets;
		
		$document->addCssFile($staticAssets('global.css'));
		$document->addCssFile($staticAssets('jquery-ui/css/humanity/jquery-ui-1.8.19.custom.css'));
		$document->addCssFile($staticAssets('chosen_v1.1.0/chosen.min.css'));
		
		$document->addJsFile($staticAssets('jquery-ui/js/jquery-1.7.2.min.js'));
		$document->addJsFile($staticAssets('jquery-ui/js/jquery-ui-1.8.19.custom.min.js'));
		$document->addJsFile($staticAssets('jquery-ui/js/jquery.history.js'));
		$document->addJsFile($staticAssets('chosen_v1.1.0/chosen.jquery.min.js'));
		$document->addJsFile($staticAssets('index.js'));
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
	
	protected function getApiResult($query) {
		$apiRequest = new \Ophp\requests\HttpRequest;
		$apiRequest->url = $query;
		$apiServer = new \Replanner\api\ApiServer;
		$apiResponse = $apiServer->getResponse($apiRequest);
		
		$result = $apiResponse->body['result'];
		return $result;
	}
}