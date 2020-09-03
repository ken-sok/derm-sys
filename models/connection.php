<?php

class Connection{

	public function connect(){

		$link = new PDO("mysql:host=localhost;dbname=derm-clinic", "root", "");

		$link -> exec("set names utf8");

		return $link;
	}

}