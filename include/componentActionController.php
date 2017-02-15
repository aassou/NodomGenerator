<?php
//begin processing
    $codeActionController = "<?php\nclass ".ucfirst($componentName)."ActionController {\n
    //attributes
    protected \$_actionMessage;
    protected \$_typeMessage;
    protected \$_source;
    protected \$_$componentName"."Manager;\n
    //constructor
    public function __construct(\$source){
    \t\$this->_".$componentName."Manager = new ".ucfirst($componentName)."Manager(PDOFactory::getMysqlConnection());
    \t\$this->_source = \$source;
    }";
    
    $codeActionController .=
    "\n
    //getters
    public function actionMessage(){
        return \$this->_actionMessage;
    }
    \n
    public function typeMessage(){
        return \$this->_typeMessage;
    }
    \n
    public function source(){
        return \$this->_source;
    }
    
    //actions
    public function add(\$$componentName){
        if( !empty(\$_POST['".$attributes[0]."']) ){\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
            }
            $codeActionController .= "\t\t\t\$createdBy = \$_SESSION['".$sessionName."']->login();
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
            \$this->_".$componentName."Manager->add(\$".$componentName.");
            \$this->_actionMessage = \"Opération Valide : ".ucfirst($componentName)." Ajouté(e) avec succès.\";  
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
    public function update(\$$componentName){
        \$id".ucfirst($componentName)." = htmlentities(\$_POST['id".ucfirst($componentName)."']);
        if(!empty(\$".$componentName."['".$attributes[0]."'])){\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\$".$attribute." = htmlentities(\$".$componentName."['".$attribute."']);\n";
            }
            $codeActionController .= "\t\t\t\$updatedBy = \$_SESSION['".$sessionName."']->login();
            \$updated = date('Y-m-d h:i:s');
            \$".$componentName." = new ".ucfirst($componentName)."(array(\n";
            $codeActionController .= "\t\t\t\t'id' => \$id".ucfirst($componentName).",\n";
            foreach($attributes as $attribute){
                $codeActionController .= "\t\t\t\t'".$attribute."' => \$".$attribute.",\n";
            } 
            $codeActionController .= "\t\t\t\t'updated' => \$updated,
            \t'updatedBy' => \$updatedBy\n";
            $codeActionController .= "\t\t\t));
            \$this->_".$componentName."Manager->update(\$".$componentName.");
            \$this->_actionMessage = \"Opération Valide : ".ucfirst($componentName)." Modifié(e) avec succès.\";
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
    public function delete(\$$componentName){
        \$id".ucfirst($componentName)." = htmlentities(\$".$componentName."['id".ucfirst($componentName)."']);
        \$this->_".$componentName."Manager->delete(\$id".ucfirst($componentName).");
        \$this->_actionMessage = \"Opération Valide : ".ucfirst($componentName)." supprimé(e) avec succès.\";
        \$this->_typeMessage = \"success\";
        \$this->_source = \"view/$componentName\";
    }
    \n}";
    
    //process complete
    $ressourceActionController = fopen($componentActionControllerLocation, "w");
    fwrite($ressourceActionController, $codeActionController);
    fclose($ressourceActionController);
    