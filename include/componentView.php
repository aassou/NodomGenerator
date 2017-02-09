<?php
//begin processing
$codeView = 
"<?php
require('../app/classLoad.php');
spl_autoload_register(\"classLoad\"); 
require('../app/PDOFactory.php');
session_start();
if ( isset(\$_SESSION['$sessionName']) ) {
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang=\"en\" class=\"ie8\"> <![endif]-->
<!--[if IE 9]> <html lang=\"en\" class=\"ie9\"> <![endif]-->
<!--[if !IE]><!--> <html lang=\"en\"> <!--<![endif]-->
    <head>
        <?php include('../include/head.php') ?>
    </head>
    <body class=\"fixed-top\">
        <div class=\"header navbar navbar-inverse navbar-fixed-top\">
          <?php include(\"../include/top-menu.php\"); ?>
        </div>
        <div class=\"page-container row-fluid sidebar-closed\">
            <?php include(\"../include/sidebar.php\"); ?>
            <div class=\"page-content\">
                <div class=\"container-fluid\">
                    <div class=\"row-fluid\">
                        <div class=\"span12\">
                            <h3 class=\"page-title\">AxaAmazigh</h3>
                        </div>
                    </div>
                    <div class=\"row-fluid\">
                        <div class=\"span12\">
                            <h4 class=\"breadcrumb\"><i class=\"icon-hand-right\"></i> Accueil</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../include/footer.php'); ?>
        <?php include('../include/scripts.php'); ?>     
        <script>jQuery(document).ready( function(){ App.setPage(\"sliders\"); App.init(); } );</script>
    </body>
</html>
<?php
}
else{
    header('Location:../index.php');    
}
?>
";
//process complete
$ressourceView = fopen($componentViewLocation, "w");
fwrite($ressourceView, $codeView);
fclose($ressourceView);
