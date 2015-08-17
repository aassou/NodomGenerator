<?php
class AzerManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Azer $azer){
    	$query = $this->_db->prepare(' INSERT INTO t_azer (
		a,b)
		VALUES (:a,b)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':a', $azer->a());
		$query->bindValue(':b', $azer->b());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Azer $azer){
    	$query = $this->_db->prepare(' UPDATE t_azer SET 
		a=:a,b=:b
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $azer->id());
		$query->bindValue(':a', $azer->a());
		$query->bindValue(':b', $azer->b());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_azer
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getAzerById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_azer
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Azer($data);
	}

	public function getAzers(){
		$azers = array();
		$query = $this->_db->query('SELECT * FROM t_azer
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$azer[] = new Azer($data);
		}
		$query->closeCursor();
		return $azer;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_azer
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}