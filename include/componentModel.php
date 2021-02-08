<?php
//create class name
$codeModel = "<?php\nclass ".ucfirst($componentName)."{\n\n";

//create attributes
$codeModel .= "\n";
$codeModel .= "\tprivate \$_id;\n";

foreach ($attributes as $attribute) {
    $codeModel .= "\tprivate \$_".$attribute.";\n";
}

$codeModel .= "\tprivate \$_created;\n";
$codeModel .= "\tprivate \$_createdBy;\n";
$codeModel .= "\tprivate \$_updated;\n";
$codeModel .= "\tprivate \$_updatedBy;\n";
$codeModel .= "\n\t/**
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
}\n\n\n";

//create setters
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

//create getters
$codeModel .= "\n";
$codeModel .= "\tpublic function getId() {
    return \$this->_id;
}\n";
foreach ($attributes as $attribute) {
    $codeModel .= "\tpublic function get".ucfirst($attribute)."() {
    return \$this->_".$attribute.";
}\n\n";
}
$codeModel .= "\tpublic function created() {
    return \$this->_created;
}\n\n";
$codeModel .= "\tpublic function createdBy() {
    return \$this->_createdBy;
}\n\n";
$codeModel .= "\tpublic function updated() {
    return \$this->_updated;
}\n\n";
$codeModel .= "\tpublic function updatedBy() {
    return \$this->_updatedBy;
}\n\n";
//end of class
$codeModel .= "}";

//process complete
$ressourceModel = fopen($componentModelLocation, "w");
fwrite($ressourceModel, $codeModel);
fclose($ressourceModel);