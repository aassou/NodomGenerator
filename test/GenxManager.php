<?php
class GenxManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Genx $genx){
    	$query = $this->_db->prepare(' INSERT INTO t_genx (
		montant,designation,numeroCheque,idProjet,dateLivraison,status)
		VALUES (:montant,designation,numeroCheque,idProjet,dateLivraison,status)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':montant', $genx->montant());
		$query->bindValue(':designation', $genx->designation());
		$query->bindValue(':numeroCheque', $genx->numeroCheque());
		$query->bindValue(':idProjet', $genx->idProjet());
		$query->bindValue(':dateLivraison', $genx->dateLivraison());
		$query->bindValue(':status', $genx->status());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Genx $genx){
    	$query = $this->_db->prepare(' UPDATE t_genx SET 
		montant=:montant,designation=:designation,numeroCheque=:numeroCheque,idProjet=:idProjet,dateLivraison=:dateLivraison,status=:status
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $genx->id());
		$query->bindValue(':montant', $genx->montant());
		$query->bindValue(':designation', $genx->designation());
		$query->bindValue(':numeroCheque', $genx->numeroCheque());
		$query->bindValue(':idProjet', $genx->idProjet());
		$query->bindValue(':dateLivraison', $genx->dateLivraison());
		$query->bindValue(':status', $genx->status());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_genx
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getGenxById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_genx
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Genx($data);
	}

	public function getGenxs(){
		$genxs = array();
		$query = $this->_db->query('SELECT * FROM t_genx
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$genxs[] = new Genx($data);
		}
		$query->closeCursor();
		return $genxs;
	}
	public function getGenxsByLimits($begin, $end){
		$genxs = array();
		$query = $this->_db->query('SELECT * FROM t_genx
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$genxs[] = new Genx($data);
		}
		$query->closeCursor();
		return $genxs;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_genx
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}