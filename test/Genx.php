<?php
class Genx{

	//attributes
	private $_id;
	private $_montant;
	private $_designation;
	private $_numeroCheque;
	private $_idProjet;
	private $_dateLivraison;
	private $_status;

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
	public function setMontant($montant){
		$this->_montant = $montant;
   	}

	public function setDesignation($designation){
		$this->_designation = $designation;
   	}

	public function setNumeroCheque($numeroCheque){
		$this->_numeroCheque = $numeroCheque;
   	}

	public function setIdProjet($idProjet){
		$this->_idProjet = $idProjet;
   	}

	public function setDateLivraison($dateLivraison){
		$this->_dateLivraison = $dateLivraison;
   	}

	public function setStatus($status){
		$this->_status = $status;
   	}

	//getters
	public function id(){
    	return $this->_id;
    }
	public function montant(){
		return $this->_montant;
   	}

	public function designation(){
		return $this->_designation;
   	}

	public function numeroCheque(){
		return $this->_numeroCheque;
   	}

	public function idProjet(){
		return $this->_idProjet;
   	}

	public function dateLivraison(){
		return $this->_dateLivraison;
   	}

	public function status(){
		return $this->_status;
   	}

}