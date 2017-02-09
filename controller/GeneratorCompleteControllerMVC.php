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
    $componentModel = ucfirst($componentName).".php";
    $componentModelManager = ucfirst($componentName)."Manager.php";
    $componentSql = "t_".$componentName.".sql";
    $componentActionController = ucfirst($componentName)."ActionController.php";
    $componentView = $componentName.".php";
    $componentPrint = ucfirst($componentName)."Print.php";
    
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
    /************************************************************************************
     *********                      ComponentModel Creation                     *********           
     ************************************************************************************/
    //complete processing
    
    include('../include/componentModel.php');
    /************************************************************************************
     *********              ComponentModelManager Creation                      *********           
     ************************************************************************************/
    include('../include/componentModelManager.php');
    /************************************************************************************
     *********                      ComponentSql Creation                     *********           
     ************************************************************************************/
    include('../include/componentSql.php');
    
    /************************************************************************************
     *********                      ComponentActionController Creation          *********           
     ************************************************************************************/
    include('../include/componentActionController.php');
    
    /************************************************************************************
     *********                      ComponentPrint Creation                     *********           
     ************************************************************************************/
    include('../include/componentPrint.php');
    
    /************************************************************************************
     *********                      ComponentView Creation                     *********           
     ************************************************************************************/
    include('../include/componentView.php');
    
    //process end
    $_SESSION['generator-success'] = "Components creation complete.";
    header("Location:../index.php");    
}