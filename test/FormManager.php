<?php
class FormManager{

	//attributes
	private $_db;

	//le constructeur
    public function __construct($db){
        $this->_db = $db;
    }

	//BAISC CRUD OPERATIONS
	public function add(Form $Form){
    	$query = $this->_db->prepare(' INSERT INTO t_Form (
		name,params,const)
		VALUES (:name,params,const)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':name', $Form->name());
		$query->bindValue(':params', $Form->params());
		$query->bindValue(':const', $Form->const());
		$query->execute();
		$query->closeCursor();
	}

	public function update(Form $Form){
    	$query = $this->_db->prepare(' UPDATE t_Form SET 
		name=:name,params=:params,const=:const
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $Form->id());
		$query->bindValue(':name', $Form->name());
		$query->bindValue(':params', $Form->params());
		$query->bindValue(':const', $Form->const());
		$query->execute();
		$query->closeCursor();
	}

	public function delete($id){
    	$query = $this->_db->prepare(' DELETE FROM t_Form
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();
		$query->closeCursor();
	}

	public function getFormById($id){
    	$query = $this->_db->prepare(' SELECT * FROM t_Form
		WHERE id=:id)')
		or die (print_r($this->_db->errorInfo()));
		$query->bindValue(':id', $id);
		$query->execute();		
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$query->closeCursor();
		return new Form($data);
	}

	public function getForms(){
		$Forms = array();
		$query = $this->_db->query('SELECT * FROM t_Form
		ORDER BY id DESC');
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$Forms[] = new Form($data);
		}
		$query->closeCursor();
		return $Forms;
	}
	public function getForms($begin, $end){
		$Forms = array();
		$query = $this->_db->query('SELECT * FROM t_Form
		ORDER BY id DESC LIMIT '.$begin.', '.$end);
		while($data = $query->fetch(PDO::FETCH_ASSOC)){
			$Forms[] = new Form($data);
		}
		$query->closeCursor();
		return $Forms;
	}
	public function getLastId(){
    	$query = $this->_db->query(' SELECT id AS last_id FROM t_Form
		ORDER BY id DESC LIMIT 0, 1');
		$data = $query->fetch(PDO::FETCH_ASSOC);
		$id = $data['last_id'];
		return $id;
	}

}