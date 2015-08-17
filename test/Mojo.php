<?php
class Mojo{

	//attributes
	private $_id;
	private $_x;
	private $_y;

	//le constructeur
    public function __construct($data){
        $this->hydrate($data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
    public function hydrate($data){
        foreach ($data as $key => $value){
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }

	//setters
	public function setId($id){
    	$this->_id = $id;
    }
	public function setX($x){
		$this->_x = $x;
   	}

	public function setY($y){
		$this->_y = $y;
   	}

	//getters
	public function id(){
    	return $this->_id;
    }
	public function x(){
		return $this->_x;
   	}

	public function y(){
		return $this->_y;
   	}

}