<?php
abstract class AjaxController extends BaseController {
	protected function newResponse() {
		return new JsonResponse();
	}
}