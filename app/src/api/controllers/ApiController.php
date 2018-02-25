<?php

namespace Replanner\api\controllers;

class ApiController extends \Ophp\JsonController {
	
	public function __invoke() {
		return $this->newResponse()->body(['result' => 'ok']);
	}
}
