<?php

namespace Jot\models;

/**
 * @property string $itemId
 * @property string $content
 * @property array $linkTo
 * @property array $linkFrom
 */
class Item extends \Ophp\Model {

	protected $itemId;
	protected $content;
	protected $linkTo;
	protected $linkFrom;

	public function setItemId($itemId) {
		$this->itemId = (string) $itemId;
	}

	public function getItemId() {
		return $this->itemId;
	}

	public function setContent($content) {
		$this->content = (string) $content;
	}

	public function getContent() {
		return $this->content;
	}

	public function setLinkTo(array $linkTo = []) {
		$this->linkTo = [];
		foreach ($linkTo as $link) {
			$this->linkTo[] = (string) $link;
		}
	}

	public function getLinkTo() {
		return $this->linkTo;
	}

	public function setLinkFrom(array $linkFrom = []) {
		$this->linkFrom = [];
		foreach ($linkFrom as $link) {
			$this->linkFrom[] = (string) $link;
		}
	}

	public function getLinkFrom() {
		return $this->linkFrom;
	}
	
	public function toArray() {
		return [
			'itemId' => $this->itemId,
		];
	}

}
