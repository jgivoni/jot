<?php

namespace Replanner\api\controllers;

class InsertController extends ApiController {

	protected $dba;
	protected $content;

	function __construct($content) {
		$this->content = $content;
		parent::__construct();
	}

	public function __invoke() {
		$item = $this->getItemMapper()->newModel();
		$item->setContent($this->content);
		$result = $this->getItemMapper()->save($item);
		
		return $this->newResponse()->body(['result' => $result]);
	}

}
