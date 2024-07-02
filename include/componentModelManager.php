<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//$componentModelLocation = $_SESSION['componentLocation']."/".$componentModelManager;

//complete processing
//create class name

$componentNameManagerUpperCase = $componentNameUpperCase.'Manager';
$codeModelManager = "<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class $componentNameManagerUpperCase
{";
$codeModelManager .= "
    private PDO \$_db;

    public function __construct(PDO \$db) 
    {
        \$this->_db = \$db;
    }
";
//create BASIC CRUD OPERATIONS

/**
 * create add method
 */
$codeModelManager .= "
    public function add(".ucfirst($componentName)." \$".$componentName.")
    {
        \$query = \$this->_db->prepare('
            INSERT INTO t_$componentName (
                ";
$codeModelManager .= implode(", ", $attributes);
$codeModelManager .= ", created, createdBy
            )";
$codeModelManager .= "
            VALUES (
                ";
$codeModelManager .= ":".implode(", :", $attributes);
$codeModelManager .= ", :created, :createdBy
            )
        ') or die (print_r(\$this->_db->errorInfo()));
        
";

foreach ($attributes as $attribute) {
    $codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->get".ucfirst($attribute)."());\n";
}
$codeModelManager .= "
        \$query->bindValue(':created', \$".$componentName."->getCreated());
        \$query->bindValue(':createdBy', \$".$componentName."->getCreatedBy());
        
        \$result = \$query->execute();
        
        \$query->closeCursor();

        return \$result;
    }
";

/**
 * create update method
 */
$codeModelManager .= "
    public function update(".ucfirst($componentName)." \$".$componentName.")
    {
        \$query = \$this->_db->prepare('
            UPDATE t_".$componentName." SET
            ";
$attributes2 = array();
$attributes2 = $attributes;

for ($i=0; $i<count($attributes2); $i++) {
    $attributes2[$i] .= "=:".$attributes[$i];
}

$codeModelManager .= implode(", ", $attributes2);
$codeModelManager .= ", updated=:updated, updatedBy=:updatedBy";
$codeModelManager .= "\n\t\tWHERE id=:id";
$codeModelManager .= "
        ') or die (print_r(\$this->_db->errorInfo()));\n\n";
$codeModelManager .= "\t\t\$query->bindValue(':id', \$".$componentName."->getId());\n";
foreach($attributes as $attribute){
    $codeModelManager .= "\t\t\$query->bindValue(':".$attribute."', \$".$componentName."->get".ucfirst($attribute)."());\n";
}
$codeModelManager .= "
        \$query->bindValue(':updated', \$".$componentName."->getUpdated());
        \$query->bindValue(':updatedBy', \$".$componentName."->getUpdatedBy());

        \$result = \$query->execute();
        
        \$query->closeCursor();
        
        return \$result;
    }
";

/**
 * create delete method
// */
$codeModelManager .= "
    public function delete(int \$id)
    {
        \$query = \$this->_db->prepare('DELETE FROM t_$componentName WHERE id=:id')
            or die (print_r(\$this->_db->errorInfo()));
            
        \$query->bindValue(':id', \$id);

        \$result = \$query->execute();
        
        \$query->closeCursor();
        
        return \$result;
    }
";

/**
 * create getComponentByID method
 */
$codeModelManager .= "
    public function getOneById(int \$id): ?$componentNameUpperCase
    {
        \$query = \$this->_db->prepare('SELECT * FROM t_$componentName WHERE id=:id')
            or die (print_r(\$this->_db->errorInfo()));
            
        \$query->bindValue(':id', \$id);
        
        \$query->execute();

        \$data = \$query->fetch(PDO::FETCH_ASSOC);

        \$query->closeCursor();

        return new $componentNameUpperCase(\$data);
    }
";

/**
 * create getComponents method
 */
$codeModelManager .= "
    public function getAll(): array
    {
        \$$componentName" . "Array" . " = [];
        
        \$query = \$this->_db->query('SELECT * FROM t_".$componentName." ORDER BY id ASC');
        
        while (\$data = \$query->fetch(PDO::FETCH_ASSOC)) {
            \$$componentName" . "Array" . "[] = new " . ucfirst($componentName) . "(\$data);
        }
        
        \$query->closeCursor();
        
        return \$$componentName" ."Array;
    }

    public function getAllByLimits(\$begin, \$end): array
    {
        \$$componentName" . "Array" . " = [];
        
        \$query = \$this->_db->query('SELECT * FROM t_".$componentName." ORDER BY id DESC LIMIT \$begin, \$end');

        while (\$data = \$query->fetch(PDO::FETCH_ASSOC)) {
            \$$componentName" . "Array" . "[] = new " . ucfirst($componentName) . "(\$data);
        }
        
        \$query->closeCursor();
        
        return \$$componentName" ."Array;
    }
    
    public function getAllNumber(): int 
    {
        \$query = \$this->_db->query('SELECT COUNT(*) AS allNumber FROM t_$componentName');
        \$data = \$query->fetch(PDO::FETCH_ASSOC);
        
        return \$data['allNumber'] ?? 0;
    }

    public function getLastId(): int 
    {
        \$query = \$this->_db->query(' SELECT id AS last_id FROM t_$componentName ORDER BY id DESC LIMIT 0, 1');
        \$data = \$query->fetch(PDO::FETCH_ASSOC);
        
        return \$data['last_id'] ?? 0;
    }
}
";

//process complete
$ressourceModelManager = fopen($componentModelManagerLocation, "w");
fwrite($ressourceModelManager, $codeModelManager);
fclose($ressourceModelManager);
