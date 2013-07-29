<?php

class Coordinate extends AppModel {

	private $id;
	private $name;
	private $x_coord;
	private $y_coord;
	private $continent;

	public function name () {
		return $this->$name;
	}

	public function x_coord () {
		return $this->$x_coord;
	}

	public function y_coord () {
		return $this->$y_coord;
	}

	public function continent () {
		return $this->$continent;
	}
}

?>