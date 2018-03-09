<?php

namespace Replanner\api\controllers;

class InsertController extends ApiController {

	protected $dba;
	protected $content;

	function __construct($content) {
		$this->content = $content;
		parent::__construct();
	}

	/**
	 * Creates a new item and links it to the creator identity
	 * 
	 * @return \Ophp\JsonResponse
	 */
	public function __invoke() {
		try {
			$identity = $this->getIdentity();
			if (!isset($identity)) {
				throw new ControllerException('Missing identity. Please provide the header: X-Jot-Identity = <your user ID>');
			}
			$item = $this->getItemMapper()->newModel();
			$item->setContent($this->content);
			$itemId = $this->getItemMapper()->save($item);
			if (isset($itemId)) {
				$identityItem = $this->getItemMapper()->loadByPrimaryKey($identity);
				if (isset($identityItem)) {
					$this->getItemMapper()->linkItems($item, $identityItem);
				} else {
					throw new ControllerException('Unknown identity. Please register at jothive.com');
				}
			} else {
				throw new ControllerException('Could not create new item');
			}
			$result = [
				'status' => 'success',
				'message' => 'Item inserted and linked to identity',
				'itemId' => $itemId,
			];
		} catch (ControllerException $e) {
			$result = [
				'status' => 'error',
				'message' => $e->getMessage(),
			];
		}
		return $this->newResponse()->body(['result' => $result]);
	}

}
