<?php

class Case {

	private $torpilled   	  = false;	// bool 	Si la case est torpillé
	private $boat_orientation = null;	// bool 	Orientation du bateau, s'il y a un bout de bateau ici (true = orizontal | false = vertical)
	private $boat_size	 	  = null;	// string 	Nombre de case qu'utilise le bateau
	//private $indexCase 		 = 0;		// int 		index de la case par rapport au tableau
	
	function __construct(){
		/**
		 * Les différents types d'appels : 
		 * [vide] 			->   Créer un simple objet
		 * bool	  			->   Si case torpillé
		 * int, int 		->   boat_orientation, boat_size
		 * int, int, bool 	->   boat_orientation, boat_size, torpilled
		 */
		$args = func_get_args();
		switch(func_num_args())
		{
			case 1:
				$this->torpilled = true;
			break;
			case 2:
				$this->boat_orientation = $args[0];
				$this->boat_size		= $args[1];
			break;
			case 3:
				$this->boat_orientation = $args[0];
				$this->boat_size		= $args[1];
				$this->torpilled		= true;
			break;
		}
	}
	
	public function setTorpilled(){
		$this->torpilled = true;
	}
	
	public function addBoat($size, $orientation){
		$this->boat_size = $size;
		$this->boat_orientation = $orientation;
	}
	
	public function genHTML(){
		return "";
	}
}
