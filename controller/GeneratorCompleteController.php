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
    $componentActionController = ucfirst($componentName)."ActionController.php";
	
    //componentLocation
    $componentModelLocation = $_SESSION['componentLocation']."/model/".$componentModel;
    $componentModelManagerLocation = $_SESSION['componentLocation']."/model/".$componentModelManager;
    $componentSqlLocation = $_SESSION['componentLocation']."/db/".$componentSql;
    $componentActionControllerLocation = $_SESSION['componentLocation']."/controller/".$componentActionController;
	/************************************************************************************
	 ********* 		        		ComponentModel Creation                     *********           
	 ************************************************************************************/
	//complete processing
	
	//create class name
    $componentNameUpperCase = ucfirst($componentName);
	$codeModel = "<?php\nclass ".$componentNameUpperCase."{\n\n";
	
	//create attributes
	$codeModel .= "\t//attributes\n";
	$codeModel .= "\tprivate \$_id;\n";
	foreach($attributes as $attribute){
		$codeModel .= "\tprivate \$_".$attribute.";\n";
	}
    $codeModel .= "\tprivate \$_created;\n";
	$codeModel .= "\tprivate \$_createdBy;\n";
    $codeModel .= "\tprivate \$_updated;\n";
    $codeModel .= "\tprivate \$_updatedBy;\n";
    
	//create constructor and hydrate method
	$codeModel .= "\n\t
    /**
     * $componentNameUpperCase constructor.
     * @param \$data
     */
    public function __construct(\$data){
        \$this->hydrate(\$data);
    }
    
    
    /**
     * @param \$data
     */
    public function hydrate(\$data){
        foreach (\$data as \$key => \$value){
            \$method = 'set'.ucfirst(\$key);
            
            if (method_exists(\$this, \$method)){
                \$this->\$method(\$value);
            }
        }
    }\n\n\n";

	$codeModel .= "\tpublic function setId(\$id) {
    	\$this->_id = \$id;
    }\n";
	foreach ($attributes as $attribute) {
		$codeModel .= "\tpublic function set".ucfirst($attribute)."(\$".$attribute.") {
		\$this->_".$attribute." = \$".$attribute.";
   	}\n\n";
	}
    $codeModel .= "\tpublic function setCreated(\$created) {
        \$this->_created = \$created;
    }\n\n";
	$codeModel .= "\tpublic function setCreatedBy(\$createdBy) {
        \$this->_createdBy = \$createdBy;
    }\n\n";
    $codeModel .= "\tpublic function setUpdated(\$updated) {
        \$this->_updated = \$updated;
    }\n\n";
    $codeModel .= "\tpublic function setUpdatedBy(\$updatedBy) {
        \$this->_updatedBy = \$updatedBy;
    }\n\n";
    

	$codeModel .= "\tpublic function id() {
    	return \$this->_id;
    }\n";
	foreach ($attributes as $attribute) {
		$codeModel .= "\tpublic function get".ucfirst($attribute)."() {
		return \$this->_".$attribute.";
   	}\n\n";
	}
    $codeModel .= "\tpublic function getCreated() {
        return \$this->_created;
    }\n\n";
    $codeModel .= "\tpublic function getCreatedBy() {
        return \$this->_createdBy;
    }\n\n";
    $codeModel .= "\tpublic function getUpdated() {
        return \$this->_updated;
    }\n\n";
    $codeModel .= "\tpublic function getUpdatedBy() {
        return \$this->_updatedBy;
    }\n\n";
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
	$codeModelManager .= "\n
    public function __construct(\$db) {
        \$this->_db = \$db;
    }\n\n\n";
	
	//create BASIC CRUD OPERATIONS
	
    /**
	 * create add method
	 */
	$codeModelManager .= "\tpublic function add(".ucfirst($componentName)." \$".$componentName.") {
    	\$query = \$this->_db->prepare('INSERT INTO t_".$componentName." (\n\t\t";
	$codeModelManager .= implode(", ", $attributes);
	$codeModelManager .= ", created, createdBy)";
	$codeModelManager .= "\n\t\tVALUES (";
	$codeModelManager .= ":".implode(", :", $attributes);
	$codeModelManager .= ", :created, :createdBy)')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	foreach($attributes as $attribute){
		$codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->get".ucfirst($attribute)."());\n";
	}
    $codeModelManager .= "\t\t\$query->bindValue(':created', \$".$componentName."->getCreated());\n";
    $codeModelManager .= "\t\t\$query->bindValue(':createdBy', \$".$componentName."->getCreatedBy());\n";
	$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";
	/**
	 * create update method
	 */
	$codeModelManager .= "\tpublic function update(".ucfirst($componentName)." \$".$componentName.") {
    	\$query = \$this->_db->prepare('UPDATE t_".$componentName." SET \n\t\t";
	$attributes2 = array();
	$attributes2 = $attributes;

	for ($i=0; $i < count($attributes2); $i++) {
		$attributes2[$i] .= "=:".$attributes[$i]; 
	}
	$codeModelManager .= implode(", ", $attributes2);
	$codeModelManager .= ", updated=:updated, updatedBy=:updatedBy";
	$codeModelManager .= "\n\t\tWHERE id=:id";
	$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	$codeModelManager .= "\t\t\$query->bindValue(':id', \$".$componentName."->getId());\n";
	foreach($attributes as $attribute){
		$codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->get".ucfirst($attribute)."());\n";
	}
	$codeModelManager .= "\t\t\$query->bindValue(':updated', \$".$componentName."->getUpdated());\n";
    $codeModelManager .= "\t\t\$query->bindValue(':updatedBy', \$".$componentName."->getUpdatedBy());\n";
	$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";
	/**
	 * create delete method
	 */
	$codeModelManager .= "\tpublic function delete(\$id) {
    	\$query = \$this->_db->prepare('DELETE FROM t_".$componentName;
	$codeModelManager .= "\n\t\tWHERE id=:id";
	$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
	$codeModelManager .= "\t\t\$query->bindValue(':id', \$id);\n";
	$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";
	/**
	 * create getComponentByID method
	 */
	$codeModelManager .= "\tpublic function get".ucfirst($componentName)."ById(\$id) {
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
	$codeModelManager .= "\tpublic function get".ucfirst($componentName)."s() {
		\$".$componentName."s = array();\n";
	$codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName."
		ORDER BY id DESC');\n";
	$codeModelManager .= "\t\twhile (\$data = \$query->fetch(PDO::FETCH_ASSOC)) {\n";
	$codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
	$codeModelManager .= "\t\t}\n\t\t\$query->closeCursor();\n\t\treturn \$".$componentName."s;\n\t}\n\n";
	/**
	 * create getComponentsByLimits method
	 */
	$codeModelManager .= "\tpublic function get".ucfirst($componentName)."sByLimits(\$begin, \$end) {
		\$".$componentName."s = array();\n";
	$codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName."
		ORDER BY id DESC LIMIT '.\$begin.', '.\$end);\n";
	$codeModelManager .= "\t\twhile (\$data = \$query->fetch(PDO::FETCH_ASSOC)) {\n";
	$codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
	$codeModelManager .= "\t\t}\n\t\t\$query->closeCursor();\n\t\treturn \$".$componentName."s;\n\t}\n\n";
	/**
	 * create getLastID method
	 */
	$codeModelManager .= "\tpublic function getLastId() {
    	\$query = \$this->_db->query(' SELECT id AS last_id FROM t_".$componentName;
	$codeModelManager .= "\n\t\tORDER BY id DESC LIMIT 0, 1');\n";
	$codeModelManager .= "\t\t\$data = \$query->fetch(PDO::FETCH_ASSOC);\n";
	$codeModelManager .= "\t\t\$id = \$data['last_id'];\n";
	$codeModelManager .= "\t\treturn \$id;\n\t}\n\n";
	//end of class
	$codeModelManager .= "}";
	
	//process complete
	$ressourceModelManager = fopen($componentModelManagerLocation, "w");
	fwrite($ressourceModelManager, $codeModelManager);
	fclose($ressourceModelManager);
	/************************************************************************************
	 ********* 		        		ComponentSql Creation                     *********           
	 ************************************************************************************/
	//begin processing
	$codeSql = "CREATE TABLE IF NOT EXISTS t_".$componentName." (\n";
	$codeSql .= "\tid INT(11) NOT NULL AUTO_INCREMENT,\n";
	$tableData = array();

	for ($i=0; $i<count($attributes); $i++) {
		$codeSql .= "\t".$attributes[$i]." ".$attributesTypes[$i]." DEFAULT NULL,\n";
	}

    $codeSql .= "\tcreated DATETIME DEFAULT NULL,\n";
    $codeSql .= "\tcreatedBy VARCHAR(50) DEFAULT NULL,\n";
    $codeSql .= "\tupdated DATETIME DEFAULT NULL,\n";
    $codeSql .= "\tupdatedBy VARCHAR(50) DEFAULT NULL,\n";
	$codeSql .= "\tPRIMARY KEY (id)\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	//process complete
	$ressourceSql = fopen($componentSqlLocation, "w");
	fwrite($ressourceSql, $codeSql);
	fclose($ressourceSql);
	
    /************************************************************************************
     *********                      ComponentActionController Creation                     *********           
     ************************************************************************************/
    //begin processing
    $codeActionController = "<?php\n
    //classes loading begin
    function classLoad (\$myClass) {
        if(file_exists('../model/'.\$myClass.'.php')){
            include('../model/'.\$myClass.'.php');
        }
        elseif(file_exists('../controller/'.\$myClass.'.php')){
            include('../controller/'.\$myClass.'.php');
        }
    }
    spl_autoload_register(\"classLoad\"); 
    include('../config.php');  
    include('../lib/image-processing.php');
    //classes loading end
    session_start();
    
    //post input processing
    \$action = htmlentities(\$_POST['action']);
    //This var contains result message of CRUD action
    \$actionMessage = \"\";
    \$typeMessage = \"\";\n
    //Component Class Manager\n
    \$".$componentName."Manager = new ".ucfirst($componentName)."Manager(\$pdo);\n";
    
    $codeActionController .=
    "\t//Action Add Processing Begin
    \tif(\$action == \"add\"){
        if( !empty(\$_POST['".$attributes[0]."']) ){\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$_POST['".$attribute."']);\n";
            }
            $codeActionController .= "\t\t\t\$createdBy = \$_SESSION['userMerlaTrav']->login();
            \$created = date('Y-m-d h:i:s');
            //create object
            \$".$componentName." = new ".ucfirst($componentName)."(array(\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
            }
            $codeActionController .= "\t\t\t\t'created' => \$created,
            \t'createdBy' => \$createdBy\n";
            $codeActionController .= "\t\t\t));
            //add it to db
            \$".$componentName."Manager->add(\$".$componentName.");
            \$actionMessage = \"Gültige Aktion : ".ucfirst($componentName)." Ajouté(e) avec succès.\";  
            \$typeMessage = \"success\";
        }
        else{
            \$actionMessage = \"Erreur Ajout ".$componentName." : Füllen Sie die erforderlichen Eingaben aus..\";
            \$typeMessage = \"error\";
        }
    }
    //Action Add Processing End
    //Action Update Processing Begin
    else if(\$action == \"update\"){
        \$id".ucfirst($componentName)." = htmlentities(\$_POST['id".ucfirst($componentName)."']);
        if(!empty(\$_POST['".$attributes[0]."'])){\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$_POST['".$attribute."']);\n";
            }
            $codeActionController .= "\t\t\t\$updatedBy = \$_SESSION['userMerlaTrav']->login();
            \$updated = date('Y-m-d h:i:s');
            \t\t\t\$".$componentName." = new ".ucfirst($componentName)."(array(\n";
            $codeActionController .= "\t\t\t\t'id' => \$id".ucfirst($componentName).",\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
            } 
            $codeActionController .= "\t\t\t\t'updated' => \$updated,
            \t'updatedBy' => \$updatedBy\n";
            $codeActionController .= "\t\t\t));
            \$".$componentName."Manager->update(\$".$componentName.");
            \$actionMessage = \"Gültige Aktion : ".ucfirst($componentName)." Modifié(e) avec succès.\";
            \$typeMessage = \"success\";
        }
        else{
            \$actionMessage = \"Erreur Modification ".ucfirst($componentName)." : Füllen Sie die erforderlichen Eingaben aus..\";
            \$typeMessage = \"error\";
        }
    }
    //Action Update Processing End
    //Action Delete Processing Begin
    else if(\$action == \"delete\"){
        \$id".ucfirst($componentName)." = htmlentities(\$_POST['id".ucfirst($componentName)."']);
        \$".$componentName."Manager->delete(\$id".ucfirst($componentName).");
        \$actionMessage = \"Gültige Aktion : ".ucfirst($componentName)." supprimé(e) avec succès.\";
        \$typeMessage = \"success\";
    }
    //Action Delete Processing End
    \$_SESSION['".$componentName."-action-message'] = \$actionMessage;
    \$_SESSION['".$componentName."-type-message'] = \$typeMessage;
    header('Location:../file-name-please.php');\n\n";
    
    //process complete
    $ressourceActionController = fopen($componentActionControllerLocation, "w");
    fwrite($ressourceActionController, $codeActionController);
    fclose($ressourceActionController);
    
    //process end
	$_SESSION['generator-success'] = "Components creation complete.";
	header("Location:../index.php");	
}