<?php
//begin processing
$componentNameControllerUpperCase = $componentNameUpperCase . "ActionController";
$componentNameManager = $componentNameUpperCase . "Manager";
$codeActionController = "<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class $componentNameControllerUpperCase 
{

    protected string \$_actionMessage;
    
    protected string \$_typeMessage;
    
    protected string \$_source;
    
    protected $componentNameManager \$_$componentName"."Manager;

    public function __construct(string \$source)
    {
        \$this->_".$componentName."Manager = new $componentNameManagerUpperCase(PDOFactory::getMysqlConnection());
        \$this->_source = \$source;
    }

    public function actionMessage(): string 
    {
        return \$this->_actionMessage;
    }

    public function typeMessage(): string 
    {
        return \$this->_typeMessage;
    }

    public function source(): string 
    {
        return \$this->_source;
    }
    
    public function add(array \$$componentName) 
    {
        if (!empty(\$".$componentName."['".$attributes[0]."'])) {\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
        }

        $codeActionController .= "\t\t\t\$createdBy = \$_SESSION['".$sessionName."']->getLogin();
            \$created = date('Y-m-d h:i:s');
        
            \$$componentName = new $componentNameUpperCase([\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
        }

        $codeActionController .= "\t\t\t\t'created' => \$created,
            \t'createdBy' => \$createdBy
        \t]);
                
        \tif (\$this->_" . $componentName . "Manager->add(\$$componentName)) {
            \t\$this->_actionMessage = \"Gültige Aktion : Vorgang erfolgreich hinzugefügt\";  
            \t\$this->_typeMessage = \"success\";
            \t\$this->_source = \"view/$componentName\";
        \t} else {
            \t\$this->_actionMessage = \"Ungültige Aktion : Daten nicht hinzugefügt\";  
            \t\$this->_typeMessage = \"success\";
            \t\$this->_source = \"view/$componentName\";
            }    
        } else {
            \$this->_actionMessage = \"Ungültige Aktion : Füllen Sie die erforderlichen Eingaben aus.\";
            \$this->_typeMessage = \"error\";
            \$this->_source = \"view/$componentName\";
        }
    }
        
    public function update(array \$$componentName) 
    {
        if (!empty(\$".$componentName."['".$attributes[0]."'])) {
            \$id = htmlentities(\$" . $componentName . "['id']);\n";

    foreach ($attributes as $attribute) {
        $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
    }

        $codeActionController .= "\t\t\t\$updatedBy = \$_SESSION['".$sessionName."']->getLogin();
            \$updated = date('Y-m-d h:i:s');\n
            \$".$componentName." = new " . $componentNameUpperCase . "([\n";
        $codeActionController .= "\t\t\t\t'id' => \$id,\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
        }

        $codeActionController .= "\t\t\t\t'updated' => \$updated,
                'updatedBy' => \$updatedBy\n";
        $codeActionController .= "\t\t\t]);\n
            if (\$this->_".$componentName."Manager->update(\$".$componentName.")) {
            \t\$this->_actionMessage = \"Gültige Aktion : Daten erfolgreich aktualisiert.\";
            \t\$this->_typeMessage = \"success\";
            \t\$this->_source = \"view/$componentName\";
            } else {
            \t\$this->_actionMessage = \"Ungültige Aktion : Daten nicht hinzugefügt\";  
            \t\$this->_typeMessage = \"success\";
            \t\$this->_source = \"view/$componentName\";
            }    
        } else {
            \$this->_actionMessage = \"Ungültige Aktion: Füllen Sie die erforderlichen Eingaben aus.\";
            \$this->_typeMessage = \"error\";
            \$this->_source = \"view/$componentName\";
        }
    }
    
    public function delete(array \$$componentName) 
    {
        \$id" . $componentNameUpperCase . " = htmlentities(\$".$componentName."['id" . $componentNameUpperCase . "']);
        
        if (\$this->_".$componentName."Manager->delete(\$id" . $componentNameUpperCase . ")) {
            \$this->_actionMessage = \"Gültige Aktion: Daten erfolgreich gelöscht.\";
            \$this->_typeMessage = \"success\";
        } else {
            \$this->_actionMessage = \"Ungültige Aktion: Daten nicht gelöscht.\";
            \$this->_typeMessage = \"success\";
        }
        
        \$this->_source = \"view/$componentName\";
    }
    
    public function getOneById(\$id) 
    {
        return \$this->_".$componentName."Manager->getOneById(\$id);
    }
    
    public function getAll() 
    {
        return  \$this->_".$componentName."Manager->getAll();
    }
    
    public function getAllByLimits(\$begin, \$end) 
    {
        return \$this->_".$componentName."Manager->getAllByLimits(\$begin, \$end);
    }
    
    public function getAllNumber() 
    {
        return \$this->_".$componentName."Manager->getAllNumber();
    }
    
    public function getLastId() 
    {
        return \$this->_".$componentName."Manager->getLastId();
    }
}
";

//$codeActionController .=
//"
//public function add(\$$componentName) {
//    if ( !empty(\$".$componentName."['".$attributes[0]."']) ) {\n";
//        foreach ($attributes as $attribute) {
//            $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
//        }
//        $codeActionController .= "\t\t\t\$createdBy = \$_SESSION['".$sessionName."']->login();
//        \$created = date('Y-m-d h:i:s');
//        //create object
//        \$".$componentName." = new " . $componentNameUpperCase . "(array(\n";
//        foreach ($attributes as $attribute) {
//            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
//        }
//        $codeActionController .= "\t\t\t\t'created' => \$created,
//        \t'createdBy' => \$createdBy\n";
//        $codeActionController .= "\t\t\t));
//        //add it to db
//        \$this->_".$componentName."Manager->add(\$".$componentName.");
//        \$this->_actionMessage = \"Gültige Aktion : " . $componentNameUpperCase . " Ajouté(e) avec succès.\";
//        \$this->_typeMessage = \"success\";
//        \$this->_source = \"view/$componentName\";
//    } else {
//        \$this->_actionMessage = \"Ungültige Aktion : Füllen Sie die erforderlichen Eingaben aus.\";
//        \$this->_typeMessage = \"error\";
//        \$this->_source = \"view/$componentName\";
//    }
//}
//\n\n
//public function update(\$$componentName) {
//    if (!empty(\$".$componentName."['".$attributes[0]."'])) {\n";
//        "\$id" . $componentNameUpperCase . " = htmlentities(\$".$componentName."['id" . $componentNameUpperCase . "'])";
//
//        foreach ($attributes as $attribute) {
//            $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
//        }
//
//        $codeActionController .= "\t\t\t\$updatedBy = \$_SESSION['".$sessionName."']->login();
//        \$updated = date('Y-m-d h:i:s');
//        \$".$componentName." = new " . $componentNameUpperCase . "(array(\n";
//        $codeActionController .= "\t\t\t\t'id' => \$id" . $componentNameUpperCase . ",\n";
//
//        foreach ($attributes as $attribute) {
//            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
//        }
//
//        $codeActionController .= "\t\t\t\t'updated' => \$updated,
//        \t'updatedBy' => \$updatedBy\n";
//        $codeActionController .= "\t\t\t));
//        \$this->_".$componentName."Manager->update(\$".$componentName.");
//        \$this->_actionMessage = \"Gültige Aktion : Daten erfolgreich aktualisiert.\";
//        \$this->_typeMessage = \"success\";
//        \$this->_source = \"view/$componentName\";
//    }
//    else{
//        \$this->_actionMessage = \"Ungültige Aktion : Füllen Sie die erforderlichen Eingaben aus.\";
//        \$this->_typeMessage = \"error\";
//        \$this->_source = \"view/$componentName\";
//    }
//}
//\n
//public function delete(\$$componentName) {
//    \$id" . $componentNameUpperCase . " = htmlentities(\$".$componentName."['id" . $componentNameUpperCase . "']);
//    \$this->_".$componentName."Manager->delete(\$id" . $componentNameUpperCase . ");
//    \$this->_actionMessage = \"Gültige Aktion : Daten erfolgreich gelöscht\";
//    \$this->_typeMessage = \"success\";
//    \$this->_source = \"view/$componentName\";
//}
//\n\n
//public function get" . $componentNameUpperCase . "ById(\$id) {
//    return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "ById(\$id);
//}
//\n\n
//public function get" . $componentNameUpperCase . "s() {
//    return  \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "s();
//}
//\n\n
//public function get" . $componentNameUpperCase . "sByLimits(\$begin, \$end) {
//    return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "sByLimits(\$begin, \$end);
//}
//\n\n
//public function get" . $componentNameUpperCase . "sNumber() {
//    return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "sNumber();
//}
//\n\n
//public function getLastId() {
//    return \$this->_".$componentName."Manager->getLastId();
//}
//\n}
//";

//process complete
$ressourceActionController = fopen($componentActionControllerLocation, "w");
fwrite($ressourceActionController, $codeActionController);
fclose($ressourceActionController);
