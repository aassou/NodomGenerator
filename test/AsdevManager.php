<?php
class AsdevManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Asdev $asdev){
    	$query = $this->_db->prepare(' INSERT INTO t_asdev (
		a,b)
		VALUES (:a,b)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':a', $asdev->a());
		$query->bindValue(':b', $asdev->b());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Asdev $asdev){
    	$query = $this->_db->prepare(' UPDATE t_asdev SET 
		a=:a,b=:b
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $asdev->id());
		$query->bindValue(':a', $asdev->a());
		$query->bindValue(':b', $asdev->b());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_asdev
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getAsdevById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_asdev
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Asdev($data);
	}

	public function getAsdevs(){
		$asdevs = array();
		$query = $this->_db->query('SELECT * FROM t_asdev
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$asdevs[] = new Asdev($data);
		}
		$query->closeCursor();
		return $asdevs;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_asdev
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}