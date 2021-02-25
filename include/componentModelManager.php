<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//$componentModelLocation = $_SESSION['componentLocation']."/".$componentModelManager;

//complete processing
//create class name

$componentNameManagerUpperCase = $componentNameUpperCase.'Manager';
$codeModelManager = "<?php\n
/**
 * Class $componentNameManagerUpperCase
 */
class $componentNameManagerUpperCase {\n\n";

//create attributes
$codeModelManager .= "\t/**\n\t * @var PDO\n\t */\n";
$codeModelManager .= "\tprivate \$_db;\n\n";

//create constructor
$codeModelManager .= "\t/**
\t * $componentNameManagerUpperCase constructor.
\t * @param \$db
\t */
\tpublic function __construct(\$db) {
    \t\$this->_db = \$db;
\t}\n\n";
//create BASIC CRUD OPERATIONS

/**
 * create add method
 */
$codeModelManager .= "\t/**
\t * @param $componentNameUpperCase $componentName
\t */\n";
$codeModelManager .= "\tpublic function add(".ucfirst($componentName)." \$".$componentName.") {
    \t\$query = \$this->_db->prepare('INSERT INTO t_".$componentName." (\n\t\t";
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
$codeModelManager .= "\t/**
\t * @param $componentNameUpperCase $componentName
\t */\n";
$codeModelManager .= "\tpublic function update(".ucfirst($componentName)." \$".$componentName.") {
    \t\$query = \$this->_db->prepare('UPDATE t_".$componentName." SET \n\t\t";
$attributes2 = array();
$attributes2 = $attributes;

for ($i=0; $i<count($attributes2); $i++) {
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
// */
$codeModelManager .= "\t/**\n\t * @param \$id\n\t */
\tpublic function delete(\$id) {
\t\t\$query = \$this->_db->prepare('DELETE FROM t_$componentName WHERE id=:id";
$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
$codeModelManager .= "\t\t\$query->bindValue(':id', \$id);\n";
$codeModelManager .= "\t\t\$query->execute();\n\t\t\$query->closeCursor();\n\t}\n\n";

/**
 * create getComponentByID method
 */
$codeModelManager .= "\t/**\n\t * @param \$id\n\t * @return $componentNameUpperCase\n\t */";
$codeModelManager .= "\n\tpublic function getOneById(\$id) {
    \t\$query = \$this->_db->prepare('SELECT * FROM t_" . $componentName . " WHERE id=:id";
$codeModelManager .= "')\n\t\tor die (print_r(\$this->_db->errorInfo()));\n";
$codeModelManager .= "\t\t\$query->bindValue(':id', \$id);\n";
$codeModelManager .= "\t\t\$query->execute();\t\t\n";
$codeModelManager .= "\t\t\$data = \$query->fetch(PDO::FETCH_ASSOC);\n";
$codeModelManager .= "\t\t\$query->closeCursor();\n";
$codeModelManager .= "\n\t\treturn new ".$componentNameUpperCase."(\$data);\n\t}\n\n";
/**
 * create getComponents method
 */
$codeModelManager .= "\t/**\n\t * @return array\n\t */\n";
$codeModelManager .= "\tpublic function getAll() {\n\t\t\$".$componentName."s = array();\n";
$codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName." ORDER BY id ASC');\n";
$codeModelManager .= "\n\t\twhile (\$data = \$query->fetch(PDO::FETCH_ASSOC)) {\n";
$codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
$codeModelManager .= "\t\t}\n\n\t\t\$query->closeCursor();\n\n\t\treturn \$".$componentName."s;\n\t}\n\n";
/**
 * create getComponentsByLimits method
 */
$codeModelManager .= "\t/**\n\t * @param \$begin\n\t * @param \$end\n\t * @return array\n\t */";
$codeModelManager .= "\n\tpublic function getAllByLimits(\$begin, \$end) {
    \t\$".$componentName."s = array();\n";
$codeModelManager .= "\t\t\$query = \$this->_db->query('SELECT * FROM t_".$componentName." ORDER BY id DESC LIMIT \$begin, \$end');\n\n";
$codeModelManager .= "\t\twhile (\$data = \$query->fetch(PDO::FETCH_ASSOC)) {\n";
$codeModelManager .= "\t\t\t\$".$componentName."s[] = new ".ucfirst($componentName)."(\$data);\n";
$codeModelManager .= "\n\t\t}\n\n\t\t\$query->closeCursor();\n\n\t\treturn \$".$componentName."s;\n\t}\n\n";
/**
 * create getComponentsNumber method
 */
$codeModelManager .= "\t/**\n\t * @return mixed\n\t */\n";
$codeModelManager .= "\tpublic function getAllNumber() {
    \t\$query = \$this->_db->query('SELECT COUNT(*) AS ".$componentName."sNumber FROM t_".$componentName."');
    \t\$data = \$query->fetch(PDO::FETCH_ASSOC);
    \t\$".$componentName." = \$data['".$componentName."sNumber'];
    \n\t\treturn \$".$componentName.";
\t}\n\n";
/**
 * create getLastID method
 */
$codeModelManager .= "\t/**\n\t * @return mixed\n\t */";
$codeModelManager .= "\n\tpublic function getLastId() {
    \t\$query = \$this->_db->query(' SELECT id AS last_id FROM t_$componentName ORDER BY id DESC LIMIT 0, 1');\n";
$codeModelManager .= "\t\t\$data = \$query->fetch(PDO::FETCH_ASSOC);\n";
$codeModelManager .= "\n\t\treturn \$data['last_id'] ?? 0;\n\t}\n";
//end of class
$codeModelManager .= "}\n";

//process complete
$ressourceModelManager = fopen($componentModelManagerLocation, "w");
fwrite($ressourceModelManager, $codeModelManager);
fclose($ressourceModelManager);
