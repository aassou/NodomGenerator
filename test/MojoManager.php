<?php
class MojoManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Mojo $mojo){
    	$query = $this->_db->prepare(' INSERT INTO t_mojo (
		x,y)
		VALUES (:x,y)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':x', $mojo->x());
		$query->bindValue(':y', $mojo->y());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Mojo $mojo){
    	$query = $this->_db->prepare(' UPDATE t_mojo SET 
		x=:x,y=:y
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $mojo->id());
		$query->bindValue(':x', $mojo->x());
		$query->bindValue(':y', $mojo->y());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_mojo
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getMojoById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_mojo
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Mojo($data);
	}

	public function getMojos(){
		$mojos = array();
$query = $this->_db->query('SELECT * FROM t_mojo
	ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$mojo[] = new Mojo($data);
		}
$query->closeCursor();
return $mojo;
}	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_mojo
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}