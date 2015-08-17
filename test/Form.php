<?php
class Form{

	//attributes
	private $_id;
	private $_name;
	private $_params;
	private $_const;

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
	public function setName($name){
		$this->_name = $name;
   	}

	public function setParams($params){
		$this->_params = $params;
   	}

	public function setConst($const){
		$this->_const = $const;
   	}

	//getters
	public function id(){
    	return $this->_id;
    }
	public function name(){
		return $this->_name;
   	}

	public function params(){
		return $this->_params;
   	}

	public function const(){
		return $this->_const;
   	}

}