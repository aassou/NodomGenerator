<?php
//create class name
$codeModel = "<?php

/**
 * Class $componentNameUpperCase
 */
class $componentNameUpperCase {

    private \$_id;
";

foreach ($attributes as $attribute) {
    $codeModel .= "\tprivate \$_".$attribute.";\n";
}

$codeModel .= "\tprivate \$_created;
    private \$_createdBy;
    private \$_updated;
    private \$_updatedBy;

    /**
     * $componentNameUpperCase constructor.
     * @param \$data
     */
    public function __construct(\$data) {
        \$this->hydrate(\$data);
    }

    /**
     * @param \$data
     */
    public function hydrate(\$data) {
        foreach (\$data as \$key => \$value) {
            \$method = 'set'.ucfirst(\$key);
            
            if (method_exists(\$this, \$method)) {
                \$this->\$method(\$value);
            }
        }
    }

    //setters
    
    public function setId(\$id) {
        \$this->_id = \$id;
    } 
";

//create setters
foreach ($attributes as $attribute) {
    $codeModel .= "
    public function set".ucfirst($attribute)."(\$".$attribute.") {
        \$this->_".$attribute." = \$".$attribute.";
    }";
}
$codeModel .= "
    
    public function setCreated(\$created) {
        \$this->_created = \$created;
    }
    
    public function setCreatedBy(\$createdBy) {
        \$this->_createdBy = \$createdBy;
    }
    
    public function setUpdatedBy(\$updatedBy) {
        \$this->_updatedBy = \$updatedBy;
    }    
    
    public function setUpdated(\$updated) {
        \$this->_updated = \$updated;
    }
    
    //getters
    
    public function getId() {
        return \$this->_id;
    }
";

//create getters

foreach ($attributes as $attribute) {
    $codeModel .= "
    public function get".ucfirst($attribute)."() {
        return \$this->_".$attribute.";
    }
    ";
}
$codeModel .= "
    public function getCreated() {
        return \$this->_created;
    }
    
    public function getCreatedBy() {
        return \$this->_createdBy;
    }
    
    public function getUpdated() {
        return \$this->_updated;
    }
    
    public function getUpdatedBy() {
        return \$this->_updatedBy;
    }
}

";

//process complete
$ressourceModel = fopen($componentModelLocation, "w");
fwrite($ressourceModel, $codeModel);
fclose($ressourceModel);