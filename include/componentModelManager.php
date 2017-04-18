<?php
//$componentModelLocation = $_SESSION['componentLocation']."/".$componentModelManager;
    
    //complete processing
    
    //create class name
    $codeModelManager = "<?php\nclass ".ucfirst($componentName."Manager")."{\n\n";
    
    //create attributes
    $codeModelManager .= "\t//attributes\n";
    $codeModelManager .= "\tprivate \$_db;\n";
    
    //create constructor
    $codeModelManager .= "\n\t//constructor
    public function __construct(\$db){
        \$this->_db = \$db;
    }\n\n\t//BASIC CRUD OPERATIONS\n";
    
    //create BASIC CRUD OPERATIONS
    
    /**
     * create add method
     */
    $codeModelManager .= "\tpublic function add(".ucfirst($componentName)." \$".$componentName."){
        \$query = \$this->_db->prepare(' INSERT INTO t_".$componentName." (\n\t\t";
    $codeModelManager .= implode(", ", $attributes);
    $codeModelManager .= ", created, createdBy)";
    $codeModelManager .= "\n\t\tVALUES (";
    $codeModelManager .= ":".implode(", :", $attributes);
    $codeModelManager .= ", :created, :createdBy)')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
    foreach($attributes as $attribute){
        $codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->".$attribute."());\n";    
    }
    $codeModelManager .= "\t\t\$query->bindValue(':created', \$".$componentName."->created());\n";
    $codeModelManager .= "\t\t\$query->bindValue(':createdBy', \$".$componentName."->createdBy());\n";
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
    $codeModelManager .= implode(", ", $attributes2);
    $codeModelManager .= ", updated=:updated, updatedBy=:updatedBy";
    $codeModelManager .= "\n\t\tWHERE id=:id";
    $codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
    $codeModelManager .= "\t\t\$query->bindValue(':id', \$".$componentName."->id());\n";
    foreach($attributes as $attribute){
        $codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->".$attribute."());\n";    
    }
    $codeModelManager .= "\t\t\$query->bindValue(':updated', \$".$componentName."->updated());\n";
    $codeModelManager .= "\t\t\$query->bindValue(':updatedBy', \$".$componentName."->updatedBy());\n";
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
    $codeModelManager .= "\tpublic function getOneById(\$id){
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
    $codeModelManager .= "\tpublic function getAll(){
        \$".$componentName."s = array();\n";
    $codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName."
        ORDER BY id ASC');\n";
    $codeModelManager .= "\t\twhile(\$data = \$query->fetch(PDO::FETCH_ASSOC)){\n";
    $codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
    $codeModelManager .= "\t\t}\n\t\t\$query->closeCursor();\n\t\treturn \$".$componentName."s;\n\t}\n\n";
    /**
     * create getComponentsByLimits method
     */
    $codeModelManager .= "\tpublic function getAllByLimits(\$begin, \$end){
        \$".$componentName."s = array();\n";
    $codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName."
        ORDER BY id DESC LIMIT '.\$begin.', '.\$end);\n";
    $codeModelManager .= "\t\twhile(\$data = \$query->fetch(PDO::FETCH_ASSOC)){\n";
    $codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
    $codeModelManager .= "\t\t}\n\t\t\$query->closeCursor();\n\t\treturn \$".$componentName."s;\n\t}\n\n";
    /**
     * create getComponentsNumber method
     */
    $codeModelManager .= "\tpublic function getAllNumber(){
        \$query = \$this->_db->query('SELECT COUNT(*) AS ".$componentName."sNumber FROM t_".$componentName."');
        \$data = \$query->fetch(PDO::FETCH_ASSOC);
        \$".$componentName." = \$data['".$componentName."sNumber'];
        return \$".$componentName.";
    }\n\n";
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
    $ressourceModelManager = fopen($componentModelManagerLocation, "w");
    fwrite($ressourceModelManager, $codeModelManager);
    fclose($ressourceModelManager);