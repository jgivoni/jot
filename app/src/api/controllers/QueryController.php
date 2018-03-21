<?php

namespace Jot\api\controllers;

class QueryController extends ApiController {

	const ITEM_IDS = [
		'~system' => '6gyws1cwd1ooc',
		'~project' => '34q5k5alkcu8k',
		'~tag' => 'hni692lcidc08',
		'~me' => 'l48rlduz85c0g',
	];

	protected $dba;
	protected $query;

	function __construct($query) {
		$this->query = rawurldecode($query);
		parent::__construct();
	}

	public function __invoke() {
		try {
			$items = $this->getItemsMatchingQuery($this->query);
			$result = $items;
		} catch (\Exception $e) {
			$result = 'Malformed query - ' . $e->getMessage();
		}
		return $this->newResponse()->body(['result' => $result]);
	}

	protected function getItemsMatchingQuery(string $query) {
		$tokens = $this->getTokensFromQuery($query);
		$postfix = $this->getPostfixNotationQuery($tokens);
		$items = $this->parsePostfixNotationQuery($postfix);
		return $items;
	}

	protected function getTokensFromQuery(string $query) {
		preg_match_all('/([a-z0-9~\*\:]+|->|<-|\(|\)|,|\|)/i', $query, $matches);
		return $matches[0];
	}

	protected function getPostfixNotationQuery($tokens) {
		$output = [];
		$operators = [];
		foreach ($tokens as $token) {
			if (preg_match('/^[a-z0-9~\*\:]+$/i', $token)) {
				if (strpos($token, '~') === 0) {
					$output[] = [self::ITEM_IDS[$token]];
				} elseif (strpos($token, ':') === 0) {
					$output[] = [substr($token, 1)];
				} else {
					$output[] = function($items) use ($token) {
						return array_filter($items, function($item) use ($token) {
							return fnmatch($token, $item->content);
						});
					};
				}
			} elseif (preg_match('/^(->|<-|\(|,|\|)$/i', $token)) {
				$operators[] = $token;
			} elseif ($token === ')') {
				while (true) {
					$operator = array_pop($operators);
					if ($operator === '(') {
						break;
					} else {
						$output[] = $operator;
					}
				}
			}
		}
		while (count($operators) > 0) {
			$output[] = array_pop($operators);
		}
		return $output;
	}

	protected function parsePostfixNotationQuery($tokenStack) {
		$operandStack = [];
		foreach ($tokenStack as $token) {
			if (is_array($token) || is_callable($token)) {
				$operandStack[] = $token;
			} else {
				$operand2 = array_pop($operandStack);
				$operand1 = array_pop($operandStack);
				$result = $this->calculateOperation($token, $operand1, $operand2);
				$operandStack[] = $result;
			}
		}
		return array_pop($operandStack);
	}

	protected function calculateOperation($token, $operand1, $operand2) {
		if ($token === '->') {
			$result = $this->getItemsLinkedToItems($operand1, $operand2);
		} elseif ($token === '<-') {
			$result = $this->getItemsLinkedFromItems($operand1, $operand2);
		} elseif ($token === ',') {
			$result = $this->getIntersectionOfItems($operand1, $operand2);
		} elseif ($token === '|') {
			$result = $this->getUnionOfItems($operand1, $operand2);
		}
		return $result;
	}

	protected function getItemsLinkedToItems(\Closure $children, array $parents) {
		$itemIds = [];
		foreach ($parents as $parentItemId) {
			$parentItem = $this->getItemMapper()->loadByPrimaryKey($parentItemId);
			$itemIds = array_unique(array_merge($itemIds, (array) $parentItem->linkFrom));
		}
		$items = [];
		foreach ($itemIds as $itemId) {
			$items[] = $this->getItemMapper()->loadByPrimaryKey($itemId);
		}
		$items = $children($items);
		return array_map(function(\Jot\models\Item $item) {
			return $item->itemId;
		}, $items);
	}
	
	protected function getItemsLinkedFromItems(\Closure $parents, array $children) {
		$itemIds = [];
		foreach ($children as $childItemId) {
			$childItem = $this->getItemMapper()->loadByPrimaryKey($childItemId);
			$itemIds = array_unique(array_merge($itemIds, (array) $childItem->linkTo));
		}
		$items = [];
		foreach ($itemIds as $itemId) {
			$items[] = $this->getItemMapper()->loadByPrimaryKey($itemId);
		}
		$items = $parents($items);
		return array_map(function(\Jot\models\Item $item) {
			return $item->itemId;
		}, $items);
	}

	protected function getIntersectionOfItems(array $set1, array $set2) {
		return array_intersect($set1, $set2);
	}
	
	protected function getUnionOfItems(array $set1, array $set2) {
		return array_unique(array_merge($set1, $set2));
	}
}
