<?php

class PagesController extends Controller {
	
	public function index() {
		$this->setVar('test', 'It is working!');
	}
	
}
