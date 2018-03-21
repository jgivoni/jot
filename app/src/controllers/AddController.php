<?php

namespace Jot\controllers;

class AddController extends Controller {

	protected $content;

	/**
	 * Returns a response with a list of important tasks
	 * @return \Ophp\HttpResponse
	 */
	public function __invoke() {
		$content = $this->getRequest()->getPostParam('content');
		
		$itemId = $this->getApiResult('/insert/' . $content);
		
		if (isset($itemId)) {
			$response = $this->newResponse()->redirect('/item/' . $itemId);
		} else {
			$response = $this->newResponse()->redirect('/error');
		}
			
		return $response;
	}

}
