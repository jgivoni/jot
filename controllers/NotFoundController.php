<?php

class NotFoundController extends BaseController {
	public function __invoke() {
		$res = $this->newResponse();
		$res->headers[] = 'HTTP/1.1 404 Not Found';
		$res->body = 'Page not found: ' . $this->getRequest()->url;
		return $res;
	}
}