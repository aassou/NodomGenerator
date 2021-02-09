<?php
//begin processing
$componentNameControllerUpperCase = $componentNameUpperCase . "ActionController";
$componentNameManager = $componentNameUpperCase . "Manager";
$codeActionController = "<?php

/**
 * Class $componentNameControllerUpperCase
 */
class $componentNameControllerUpperCase {

    /**
     * @var string
     */
    protected \$_actionMessage;
    
    /**
     * @var string
     */
    protected \$_typeMessage;
    
    /**
     * @var string
     */
    protected \$_source;
    
    /**
     * @var $componentNameManager
     */
    protected \$_$componentName"."Manager;\n


    /**
     * $componentNameUpperCase constructor.
     * @param \$data
     */
    public function __construct(\$source) {
        \$this->_".$componentName."Manager = new $componentNameManagerUpperCase(PDOFactory::getMysqlConnection());
        \$this->_source = \$source;
    }

    /**
     * @return string
     */
    public function actionMessage() {
        return \$this->_actionMessage;
    }

    /**
     * @return string
     */
    public function typeMessage() {
        return \$this->_typeMessage;
    }

    /**
     * @return string
     */
    public function source() {
        return \$this->_source;
    }
    
    /**
     * @param \$$componentNameUpperCase
     */
    public function add(\$$componentName) {
        if (!empty(\$".$componentName."['".$attributes[0]."'])) {\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
        }

        $codeActionController .= "\t\t\$createdBy = \$_SESSION['".$sessionName."']->login();
            \$created = date('Y-m-d h:i:s');
        
            \$$componentName = new $componentNameUpperCase(array(\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t'".$attribute."' => \$".$attribute.",\n";
        }

        $codeActionController .= "\t\t\t'created' => \$created,
            'createdBy' => \$createdBy
        ));
                
        \$this->_" . $componentNameManager . "->add(\$$componentName);
        \$this->_actionMessage = \"Opération Valide : $componentNameUpperCase Ajouté(e) avec succès.\";  
        \$this->_typeMessage = \"success\";
        \$this->_source = \"view/$componentName\";
        } else {
            \$this->_actionMessage = \"Opération Invalide : Vous devez remplir le champ '".$attributes[0]."'.\";
            \$this->_typeMessage = \"error\";
            \$this->_source = \"view/$componentName\";
        }
    }
        
    /**
     * @param \$$componentNameUpperCase
     */
    public function update(\$$componentName) {
        if (!empty(\$".$componentName."['".$attributes[0]."'])) {\n";
            "\$id = htmlentities(\$$componentName['id'])";

    foreach ($attributes as $attribute) {
        $codeActionController .= "\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
    }

        $codeActionController .= "\t\t\t\$updatedBy = \$_SESSION['".$sessionName."']->login();
            \$updated = date('Y-m-d h:i:s');
            \$".$componentName." = new " . $componentNameUpperCase . "(array(\n";
        $codeActionController .= "\t\t\t\t'id' => \$id" . $componentNameUpperCase . ",\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
        }

        $codeActionController .= "\t\t\t\t'updated' => \$updated,
                \t'updatedBy' => \$updatedBy\n";
        $codeActionController .= "\t\t\t));
                \$this->_".$componentName."Manager->update(\$".$componentName.");
                \$this->_actionMessage = \"Opération Valide : " . $componentNameUpperCase . " Modifié(e) avec succès.\";
                \$this->_typeMessage = \"success\";
                \$this->_source = \"view/$componentName\";
        }
        else{
            \$this->_actionMessage = \"Opération Invalide : Vous devez remplir le champ '".$attributes[0]."'.\";
            \$this->_typeMessage = \"error\";
            \$this->_source = \"view/$componentName\";
        }
    }
        \n
        public function delete(\$$componentName) {
            \$id" . $componentNameUpperCase . " = htmlentities(\$".$componentName."['id" . $componentNameUpperCase . "']);
            \$this->_".$componentName."Manager->delete(\$id" . $componentNameUpperCase . ");
            \$this->_actionMessage = \"Opération Valide : " . $componentNameUpperCase . " supprimé(e) avec succès.\";
            \$this->_typeMessage = \"success\";
            \$this->_source = \"view/$componentName\";
        }
        \n\n
        public function get" . $componentNameUpperCase . "ById(\$id) {
            return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "ById(\$id);
        }
        \n\n
        public function get" . $componentNameUpperCase . "s() {
            return  \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "s();
        }
        \n\n
        public function get" . $componentNameUpperCase . "sByLimits(\$begin, \$end) {
            return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "sByLimits(\$begin, \$end);
        }
        \n\n
        public function get" . $componentNameUpperCase . "sNumber() {
            return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "sNumber();
        }
        \n\n
        public function getLastId() {
            return \$this->_".$componentName."Manager->getLastId();
        }
        \n}

";

$codeActionController .=
"
public function add(\$$componentName) {
    if ( !empty(\$".$componentName."['".$attributes[0]."']) ) {\n";
        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
        }
        $codeActionController .= "\t\t\t\$createdBy = \$_SESSION['".$sessionName."']->login();
        \$created = date('Y-m-d h:i:s');
        //create object
        \$".$componentName." = new " . $componentNameUpperCase . "(array(\n";
        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
        }
        $codeActionController .= "\t\t\t\t'created' => \$created,
        \t'createdBy' => \$createdBy\n";
        $codeActionController .= "\t\t\t));
        //add it to db
        \$this->_".$componentName."Manager->add(\$".$componentName.");
        \$this->_actionMessage = \"Opération Valide : " . $componentNameUpperCase . " Ajouté(e) avec succès.\";  
        \$this->_typeMessage = \"success\";
        \$this->_source = \"view/$componentName\";
    } else {
        \$this->_actionMessage = \"Opération Invalide : Vous devez remplir le champ '".$attributes[0]."'.\";
        \$this->_typeMessage = \"error\";
        \$this->_source = \"view/$componentName\";
    }
}
\n\n
public function update(\$$componentName) {
    if (!empty(\$".$componentName."['".$attributes[0]."'])) {\n";
        "\$id" . $componentNameUpperCase . " = htmlentities(\$".$componentName."['id" . $componentNameUpperCase . "'])";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
        }

        $codeActionController .= "\t\t\t\$updatedBy = \$_SESSION['".$sessionName."']->login();
        \$updated = date('Y-m-d h:i:s');
        \$".$componentName." = new " . $componentNameUpperCase . "(array(\n";
        $codeActionController .= "\t\t\t\t'id' => \$id" . $componentNameUpperCase . ",\n";

        foreach ($attributes as $attribute) {
            $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
        }

        $codeActionController .= "\t\t\t\t'updated' => \$updated,
        \t'updatedBy' => \$updatedBy\n";
        $codeActionController .= "\t\t\t));
        \$this->_".$componentName."Manager->update(\$".$componentName.");
        \$this->_actionMessage = \"Opération Valide : " . $componentNameUpperCase . " Modifié(e) avec succès.\";
        \$this->_typeMessage = \"success\";
        \$this->_source = \"view/$componentName\";
    }
    else{
        \$this->_actionMessage = \"Opération Invalide : Vous devez remplir le champ '".$attributes[0]."'.\";
        \$this->_typeMessage = \"error\";
        \$this->_source = \"view/$componentName\";
    }
}
\n
public function delete(\$$componentName) {
    \$id" . $componentNameUpperCase . " = htmlentities(\$".$componentName."['id" . $componentNameUpperCase . "']);
    \$this->_".$componentName."Manager->delete(\$id" . $componentNameUpperCase . ");
    \$this->_actionMessage = \"Opération Valide : " . $componentNameUpperCase . " supprimé(e) avec succès.\";
    \$this->_typeMessage = \"success\";
    \$this->_source = \"view/$componentName\";
}
\n\n
public function get" . $componentNameUpperCase . "ById(\$id) {
    return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "ById(\$id);
}
\n\n
public function get" . $componentNameUpperCase . "s() {
    return  \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "s();
}
\n\n
public function get" . $componentNameUpperCase . "sByLimits(\$begin, \$end) {
    return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "sByLimits(\$begin, \$end);
}
\n\n
public function get" . $componentNameUpperCase . "sNumber() {
    return \$this->_".$componentName."Manager->get" . $componentNameUpperCase . "sNumber();
}
\n\n
public function getLastId() {
    return \$this->_".$componentName."Manager->getLastId();
}
\n}
";

//process complete
$ressourceActionController = fopen($componentActionControllerLocation, "w");
fwrite($ressourceActionController, $codeActionController);
fclose($ressourceActionController);
