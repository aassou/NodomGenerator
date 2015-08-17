<?php
session_start();

if(!empty($_POST['componentName']) and !empty($_POST['componentLocation'])){
	//get component name and location
	$componentName = htmlentities($_POST['componentName']);
	$componentLocation = htmlentities($_POST['componentLocation']);
	$attributesNumber = htmlentities($_POST['attributesNumber']);
	
	//create files's names
	$componentModel = ucfirst($componentName).".php";
	$componentModelManager = ucfirst($componentName)."Manager.php";
	$componentSql = "t_".$componentName.".sql";
	
	//create files
	$componentModelFile = fopen($componentLocation."/".$componentModel, "w");
	$componentModelManagerFile = fopen($componentLocation."/".$componentModelManager, "w");
	$componentSqlFile = fopen($componentLocation."/".$componentSql, "w");
	
	//close files
	fclose($componentModelFile);
	fclose($componentModelManagerFile);
	fclose($componentSqlFile);
	//message
	$_SESSION['generator-success'] = "Components created succefully.";
	$_SESSION['attributesNumber'] = $attributesNumber;
	$_SESSION['componentName'] = $componentName;
	$_SESSION['componentLocation'] = $componentLocation;
	//components files
	$_SESSION['componentName'] = $componentName;
	header('Location:../complete-creation.php');
}
else{
	$_SESSION['generator-error'] = "&lt;Component Name&gt; and &lt;Location File&gt; fields should be fill.";
	header('Location:../index.php');	
}
