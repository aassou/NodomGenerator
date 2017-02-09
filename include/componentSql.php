<?php
//begin processing
    $codeSql = "CREATE TABLE IF NOT EXISTS t_".$componentName." (\n";
    $codeSql .= "\tid INT(11) NOT NULL AUTO_INCREMENT,\n";
    $tableData = array();
    for($i=0; $i<count($attributes); $i++){
        $codeSql .= "\t".$attributes[$i]." ".$attributesTypes[$i]." DEFAULT NULL,\n";
    }
    $codeSql .= "\tcreated DATETIME DEFAULT NULL,\n";
    $codeSql .= "\tcreatedBy VARCHAR(50) DEFAULT NULL,\n";
    $codeSql .= "\tupdated DATETIME DEFAULT NULL,\n";
    $codeSql .= "\tupdatedBy VARCHAR(50) DEFAULT NULL,\n";
    $codeSql .= "\tPRIMARY KEY (id)\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    //process complete
    $ressourceSql = fopen($componentSqlLocation, "w");
    fwrite($ressourceSql, $codeSql);
    fclose($ressourceSql);