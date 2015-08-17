<?php
class Azer{

	//attributes
	private $_id;
	private $_a;
	private $_b;

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
	public function setA($a){
		$this->_a = $a;
   	}

	public function setB($b){
		$this->_b = $b;
   	}

	//getters
	public function id(){
    	return $this->_id;
    }
	public function a(){
		return $this->_a;
   	}

	public function b(){
		return $this->_b;
   	}

}