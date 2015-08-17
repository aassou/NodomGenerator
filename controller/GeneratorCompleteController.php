<?php
session_start();

$codeModel = "";
$codeModelManager = "";
$codeSql = "";
$attributes = array();
$attributesTypes = array();

if(isset($_POST['attributes']) and !empty($_POST['attributes'])){
	foreach($_POST['attributes'] as $attribute){
		$attributes[] = $attribute;
	}
	
	foreach($_POST['attributesTypes'] as $attributeType){
		$attributesTypes[] = $attributeType;
	}
	
	//get files names
	$componentName = $_SESSION['componentName'];
	$componentModel = ucfirst($componentName).".php";
	$componentModelManager = ucfirst($componentName)."Manager.php";
	$componentSql = "t_".$componentName.".sql";
	
	/************************************************************************************
	 ********* 		        		ComponentModel Creation                     *********           
	 ************************************************************************************/
	//componentLocation
	$componentModelLocation = $_SESSION['componentLocation']."/".$componentModel;
	$componentModelManagerLocation = $_SESSION['componentLocation']."/".$componentModelManager;
	$componentSqlLocation = $_SESSION['componentLocation']."/".$componentSql;
	//complete processing
	
	//create class name
	$codeModel = "<?php\nclass ".ucfirst($componentName)."{\n\n";
	
	//create attributes
	$codeModel .= "\t//attributes\n";
	$codeModel .= "\tprivate \$_id;\n";
	foreach($attributes as $attribute){
		$codeModel .= "\tprivate \$_".$attribute.";\n";
	}
	
	//create constructor and hydrate method
	$codeModel .= "\n\t//le constructeur
    public function __construct(\$data){
        \$this->hydrate(\$data);
    }
    
    //la focntion hydrate sert à attribuer les valeurs en utilisant les setters d\'une façon dynamique!
    public function hydrate(\$data){
        foreach (\$data as \$key => \$value){
            \$method = 'set'.ucfirst(\$key);
            
            if (method_exists(\$this, \$method)){
                \$this->\$method(\$value);
            }
        }
    }\n\n\t//setters\n";
	
	//create setters
	$codeModel .= "\tpublic function setId(\$id){
    	\$this->_id = \$id;
    }\n";
	foreach($attributes as $attribute){
		$codeModel .= "\tpublic function set".ucfirst($attribute)."(\$".$attribute."){
		\$this->_".$attribute." = \$".$attribute.";
   	}\n\n";
	}
	
	//create getters
	$codeModel .= "\t//getters\n";
	$codeModel .= "\tpublic function id(){
    	return \$this->_id;
    }\n";
	foreach($attributes as $attribute){
		$codeModel .= "\tpublic function ".$attribute."(){
		return \$this->_".$attribute.";
   	}\n\n";
	}
	//end of class
	$codeModel .= "}";
	
	//process complete
	$ressourceModel = fopen($componentModelLocation, "w");
	fwrite($ressourceModel, $codeModel);
	fclose($ressourceModel);
	/************************************************************************************
	 ********* 		   		ComponentModelManager Creation                      *********           
	 ************************************************************************************/
	$componentModelLocation = $_SESSION['componentLocation']."/".$componentModelManager;
	
	//complete processing
	
	//create class name
	$codeModelManager = "<?php\nclass ".ucfirst($componentName."Manager")."{\n\n";
	
	//create attributes
	$codeModelManager .= "\t//attributes\n";
	$codeModelManager .= "\tprivate \$_db;\n";
	
	//create constructor
	$codeModelManager .= "\n\t//le constructeur
    public function __construct(\$db){
        \$this->_db = \$db;
    }\n\n\t//BAISC CRUD OPERATIONS\n";
	
	//create BASIC CRUD OPERATIONS
	
    /**
	 * create add method
	 */
	$codeModelManager .= "\tpublic function add(".ucfirst($componentName)." \$".$componentName."){
    	\$query = \$this->_db->prepare(' INSERT INTO t_".$componentName." (\n\t\t";
	$codeModelManager .= implode(",", $attributes);
	$codeModelManager .= ")";
	$codeModelManager .= "\n\t\tVALUES (";
	$codeModelManager .= ":".implode(",", $attributes);
	$codeModelManager .= ")')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	foreach($attributes as $attribute){
		$codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->".$attribute."());\n";	
	}
	$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";
	/**
	 * create update method
	 */
	$codeModelManager .= "\tpublic function update(".ucfirst($componentName)." \$".$componentName."){
    	\$query = \$this->_db->prepare(' UPDATE t_".$componentName." SET \n\t\t";
	$attributes2 = array();
	$attributes2 = $attributes;
	for($i=0; $i<count($attributes2); $i++){
		$attributes2[$i] .= "=:".$attributes[$i]; 
	}
	$codeModelManager .= implode(",", $attributes2);
	$codeModelManager .= "\n\t\tWHERE id=:id";
	$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	$codeModelManager .= "\t\t\$query->bindValue(':id', \$".$componentName."->id());\n";
	foreach($attributes as $attribute){
		$codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->".$attribute."());\n";	
	}
	$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";
	/**
	 * create delete method
	 */
	$codeModelManager .= "\tpublic function delete(\$id){
    	\$query = \$this->_db->prepare(' DELETE FROM t_".$componentName;
	$codeModelManager .= "\n\t\tWHERE id=:id";
	$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	$codeModelManager .= "\t\t\$query->bindValue(':id', \$id);\n";
	$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";
	/**
	 * create getComponentByID method
	 */
	$codeModelManager .= "\tpublic function get".ucfirst($componentName)."ById(\$id){
    	\$query = \$this->_db->prepare(' SELECT * FROM t_".$componentName;
	$codeModelManager .= "\n\t\tWHERE id=:id";
	$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	$codeModelManager .= "\t\t\$query->bindValue(':id', \$id);\n";
	$codeModelManager .= "\t\t\$query->execute();\t\t\n";
	$codeModelManager .= "\t\t\$data = \$query->fetch(PDO::FETCH_ASSOC);\n";
	$codeModelManager .= "\t\t\$query->closeCursor();\n";
	$codeModelManager .= "\t\treturn new ".ucfirst($componentName)."(\$data);\n\t}\n\n";
	/**
	 * create getComponents method
	 */
	$codeModelManager .= "\tpublic function get".ucfirst($componentName)."s(){
		\$".$componentName."s = array();\n";
	$codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName."
		ORDER BY id DESC');\n";
	$codeModelManager .= "\t\twhile(\$data = \$query->fetch(PDO::FETCH_ASSOC)){\n";
	$codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
	$codeModelManager .= "\t\t}\n\t\t\$query->closeCursor();\n\t\treturn \$".$componentName."s;\n\t}\n";
	/**
	 * create getComponentsByLimits method
	 */
	$codeModelManager .= "\tpublic function get".ucfirst($componentName)."sByLimits(\$begin, \$end){
		\$".$componentName."s = array();\n";
	$codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName."
		ORDER BY id DESC LIMIT '.\$begin.', '.\$end);\n";
	$codeModelManager .= "\t\twhile(\$data = \$query->fetch(PDO::FETCH_ASSOC)){\n";
	$codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
	$codeModelManager .= "\t\t}\n\t\t\$query->closeCursor();\n\t\treturn \$".$componentName."s;\n\t}\n";
	/**
	 * create getLastID method
	 */
	$codeModelManager .= "\tpublic function getLastId(){
    	\$query = \$this->_db->query(' SELECT id AS last_id FROM t_".$componentName;
	$codeModelManager .= "\n\t\tORDER BY id DESC LIMIT 0, 1');\n";
	$codeModelManager .= "\t\t\$data = \$query->fetch(PDO::FETCH_ASSOC);\n";
	$codeModelManager .= "\t\t\$id = \$data['last_id'];\n";
	$codeModelManager .= "\t\treturn \$id;\n\t}\n\n";
	//end of class
	$codeModelManager .= "}";
	
	//process complete
	$ressourceModelManager = fopen($componentModelLocation, "w");
	fwrite($ressourceModelManager, $codeModelManager);
	fclose($ressourceModelManager);
	/************************************************************************************
	 ********* 		        		ComponentSql Creation                     *********           
	 ************************************************************************************/
	//begin processing
	$codeSql = "CREATE TABLE IF NOT EXISTS t_".$componentName." (\n";
	$codeSql .= "\tid INT(11) NOT NULL AUTO_INCREMENT,\n";
	$tableData = array();
	for($i=0; $i<count($attributes); $i++){
		$codeSql .= "\t".$attributes[$i]." ".$attributesTypes[$i]." DEFAULT NULL,\n";
	}
	$codeSql .= "\tPRIMARY KEY (id)\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	//process complete
	$ressourceSql = fopen($componentSqlLocation, "w");
	fwrite($ressourceSql, $codeSql);
	fclose($ressourceSql);
	
	$_SESSION['generator-success'] = "Components creation complete.";
	header("Location:../index.php");	
}