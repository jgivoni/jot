<?php

namespace Replanner\controllers;

class NotFoundController extends TaskController {
	public function __invoke() {
		$response = $this->newResponse()
				->body('Page not found: ' . $this->getRequest()->url)
				->status(\Ophp\HtmlResponse::STATUS_NOT_FOUND);
		return $response;
	}
}