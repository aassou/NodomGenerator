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
    $componentNameUpperCase = ucfirst($componentName);
    $componentModel = $componentNameUpperCase.".php";
    $componentModelManager = $componentNameUpperCase."Manager.php";
    $componentSql = "t_".$componentName.".sql";
    $componentActionController = $componentNameUpperCase."ActionController.php";
    $componentView = $componentName.".php";
    $componentPrint = $componentNameUpperCase."Print.php";
    var_dump('here');
    //componentLocation
    $componentModelLocation = $_SESSION['componentLocation']."/model/".$componentModel;
    $componentModelManagerLocation = $_SESSION['componentLocation']."/model/".$componentModelManager;
    $componentSqlLocation = $_SESSION['componentLocation']."/db/".$componentSql;
    $componentActionControllerLocation = $_SESSION['componentLocation']."/controller/".$componentActionController;
    $componentViewLocation = $_SESSION['componentLocation']."/view/".$componentView;
    $componentPrintLocation = $_SESSION['componentLocation']."/print/".$componentPrint;
    //Application SESSION Name
    $sessionName = explode('/', $_SESSION['componentLocation']);
    $sessionName = "user".$sessionName[sizeof($sessionName)-1];
    var_dump('there');
    /************************************************************************************
     *********                      ComponentModel Creation                     *********           
     ************************************************************************************/
    //complete processing
    
    include('../include/componentModel.php');
    var_dump('model');
    /************************************************************************************
     *********              ComponentModelManager Creation                      *********           
     ************************************************************************************/
    include('../include/componentModelManager.php');
    var_dump('modelManager');
    /************************************************************************************
     *********                      ComponentSql Creation                     *********           
     ************************************************************************************/
    include('../include/componentSql.php');
    var_dump('sql');
    /************************************************************************************
     *********                      ComponentActionController Creation          *********           
     ************************************************************************************/
    include('../include/componentActionController.php');
    var_dump('action');
    /************************************************************************************
     *********                      ComponentPrint Creation                     *********           
     ************************************************************************************/
    include('../include/componentPrint.php');
    var_dump('print');
    /************************************************************************************
     *********                      ComponentView Creation                     *********           
     ************************************************************************************/
    include('../include/componentView.php');
    var_dump('view');
    //process end
    $_SESSION['generator-success'] = "Components creation complete.";
    header("Location:../index.php");    
}