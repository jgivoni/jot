<?php

namespace Jot;

class CardsController extends TaskController {
	
	public function __invoke() {
		$content = $this->newView('task/cards.html');
		$content->top()->addCssFile($this->getServer()->getUrlHelper()->staticAssets('task/cards.css'));
		$content->top()->addJsFile($this->getServer()->getUrlHelper()->staticAssets('task/taphold.js'));
		$content->top()->addJsFile($this->getServer()->getUrlHelper()->staticAssets('task/cards.js'));
		$content->assign(['tasks' => $this->getTaskMapper()->loadAllOrdered()]);
		return $this->newResponse($content);
	}
}