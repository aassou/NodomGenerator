<?php
$componentNameControllerUpperCase = $componentNameUpperCase . "ActionController";
$componentNameManager = $componentNameUpperCase . "Manager";
$codeActionController = "<?php

require_once('../app/AppController.php');

/**
 * Class $componentNameControllerUpperCase
 */
class $componentNameControllerUpperCase extends AppController {
    
}
";

//process complete
$ressourceActionController = fopen($componentActionControllerLocation, "w");
fwrite($ressourceActionController, $codeActionController);
fclose($ressourceActionController);