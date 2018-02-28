<?php

namespace Replanner\controllers;

/**
 * 
 * An abstract base class for all controllers within this app
 */
class ItemController extends Controller {

	protected $itemId;

	function __construct($itemId) {
		$this->itemId = $itemId;
		parent::__construct();
	}

	public function __invoke() {
		$content = $this->getApiResult('/get/' . $this->itemId);
		
		$view = $this->newView('item.html');
		$view->content->itemContent = $content;
		
		return $this->newResponse()->body($view);
	}

}