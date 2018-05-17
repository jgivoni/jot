<?php

namespace Jot\api\controllers;

class LoginController extends ApiController {

    protected $username;

    function __construct($username) {
		$this->username = $username;
		parent::__construct();
	}

	public function __invoke() {
		setcookie('Jot-Identity', $this->username, 0, '/');
        
		return $this->newResponse()->body(['result' => [
		    'status' => 'ok',
            'message' => 'cookie set',
        ]]);
	}

}
