<?php
//begin processing
$codeView = 
"<?php
require('../app/classLoad.php');
session_start();
if ( isset(\$_SESSION['$sessionName']) ) {
    //create Controller
    \$".$componentName."ActionController = new ".ucfirst($componentName)."ActionController('".$componentName."');
    //get objects
    \$".$componentName."s = \$".$componentName."ActionController->get".ucfirst($componentName)."s(); 
    /*\$".$componentName."sNumber = \$".$componentName."ActionController->get".ucfirst($componentName)."sNumber(); 
    \$p = 1;
    if ( \$".$componentName."sNumber != 0 ) {
        \$".$componentName."PerPage = 20;
        \$pageNumber = ceil(\$".$componentName."sNumber/\$".$componentName."PerPage);
        if(isset(\$_GET['p']) and (\$_GET['p']>0 and \$_GET['p']<=\$pageNumber)){
            \$p = \$_GET['p'];
        }
        else{
            \$p = 1;
        }
        \$begin = (\$p - 1) * \$".$componentName."PerPage;
        \$pagination = paginate('".$componentName.".php', '?p=', \$pageNumber, \$p);
        \$".$componentName."s = \$".$componentName."ActionController->get".ucfirst($componentName)."sByLimits(\$begin, \$".$componentName."PerPage);
    }*/ 
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
                            <ul class=\"breadcrumb\">
                                <li><i class=\"icon-home\"></i><a href=\"dashboard.php\">Accueil</a><i class=\"icon-angle-right\"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class=\"row-fluid\">
                        <div class=\"span12\">
                            <?php if(isset(\$_SESSION['actionMessage']) and isset(\$_SESSION['typeMessage'])){ \$message = \$_SESSION['actionMessage']; \$typeMessage = \$_SESSION['typeMessage']; ?>
                            <div class=\"alert alert-<?= \$typeMessage ?>\"><button class=\"close\" data-dismiss=\"alert\"></button><?= \$message ?></div>
                            <?php } unset(\$_SESSION['actionMessage']); unset(\$_SESSION['typeMessage']); ?>
                            <!-- add".ucfirst($componentName)." box begin -->
                            <div id=\"add".ucfirst($componentName)."\" class=\"modal hide fade in\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"false\" >
                                <div class=\"modal-header\">
                                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\"></button>
                                    <h3>Ajouter ".ucfirst($componentName)."</h3>
                                </div>
                                <form class=\"form-horizontal\" action=\"../app/Dispatcher.php\" method=\"post\">
                                    <div class=\"modal-body\">
                                    ";
                                    foreach ( $attributes as $attribute ) {
                                    $codeView.=
                                        "<div class=\"control-group\">
                                            <label class=\"control-label\">".ucfirst($attribute)."</label>
                                            <div class=\"controls\">
                                                <input required=\"required\" type=\"text\" name=\"".$attribute."\" />
                                            </div>
                                        </div>
                                        ";}
                                    $codeView .="     
                                    </div>
                                    <div class=\"modal-footer\">
                                        <div class=\"control-group\">
                                            <div class=\"controls\">
                                                <input type=\"hidden\" name=\"action\" value=\"add\" />
                                                <input type=\"hidden\" name=\"source\" value=\"".$componentName."\" />    
                                                <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Non</button>
                                                <button type=\"submit\" class=\"btn red\" aria-hidden=\"true\">Oui</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>    
                            <!-- add".ucfirst($componentName)." box end -->
                            <div class=\"portlet box light-grey\">
                                <div class=\"portlet-title\">
                                    <h4>Liste des ".ucfirst($componentName)."s</h4>
                                    <div class=\"tools\">
                                        <a href=\"javascript:;\" class=\"reload\"></a>
                                    </div>
                                </div>
                                <div class=\"portlet-body\">
                                    <div class=\"clearfix\">
                                        <div class=\"btn-group\">
                                            <a class=\"btn blue pull-right\" href=\"#add".ucfirst($componentName)."\" data-toggle=\"modal\">
                                                <i class=\"icon-plus-sign\"></i>&nbsp;".ucfirst($componentName)."
                                            </a>
                                        </div>
                                    </div>
                                    <table class=\"table table-striped table-bordered table-hover\" id=\"sample_2\">
                                        <thead>
                                            <tr>
                                                <th class=\"t10 hidden-phone\">Actions</th>";
                                                foreach ( $attributes as $attribute ) {
                                                $codeView .= "
                                                <th class=\"t10\">".ucfirst($attribute)."</th>";
                                                }
                                                $codeView .="
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //if ( \$".$componentName."sNumber != 0 ) { 
                                            foreach ( \$".$componentName."s as \$".$componentName." ) {
                                            ?>
                                            <tr>
                                                <td class=\"hidden-phone\">
                                                    <a href=\"#delete".ucfirst($componentName)."<?= \$".$componentName."->id() ?>\" data-toggle=\"modal\" data-id=\"<?= \$".$componentName."->id() ?>\" class=\"btn mini red\"><i class=\"icon-remove\"></i></a>
                                                    <a href=\"#update".ucfirst($componentName)."<?= \$".$componentName."->id() ?>\" data-toggle=\"modal\" data-id=\"<?= \$".$componentName."->id() ?>\" class=\"btn mini green\"><i class=\"icon-refresh\"></i></a>
                                                </td>";
                                                foreach ( $attributes as $attribute ) {
                                                $codeView .= "
                                                <td><?= \$".$componentName."->".$attribute."() ?></td>";
                                                }
                                                $codeView .="
                                            </tr> 
                                            <!-- update".ucfirst($componentName)." box begin -->
                                            <div id=\"update".ucfirst($componentName)."<?= \$".$componentName."->id() ?>\" class=\"modal hide fade in\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"false\">
                                                <div class=\"modal-header\">
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\"></button>
                                                    <h3>Modifier Info ".ucfirst($componentName)."</h3>
                                                </div>
                                                <form class=\"form-inline\" action=\"../app/Dispatcher.php\" method=\"post\">
                                                    <div class=\"modal-body\">";
                                                    foreach ( $attributes as $attribute ) {
                                                        $codeView .= "
                                                        <div class=\"control-group\">
                                                            <label class=\"control-label\">".ucfirst($attribute)."</label>
                                                            <div class=\"controls\">
                                                                <input required=\"required\" type=\"text\" name=\"".$attribute."\"  value=\"<?= \$".$componentName."->".$attribute."() ?>\" />
                                                            </div>
                                                        </div>";
                                                    }
                                                    $codeView .= "
                                                    </div>
                                                    <div class=\"modal-footer\">
                                                        <div class=\"control-group\">
                                                            <div class=\"controls\">
                                                                <input type=\"hidden\" name=\"id".ucfirst($componentName)."\" value=\"<?= \$".$componentName."->id() ?>\" />
                                                                <input type=\"hidden\" name=\"action\" value=\"update\" />
                                                                <input type=\"hidden\" name=\"source\" value=\"".$componentName."\" />    
                                                                <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Non</button>
                                                                <button type=\"submit\" class=\"btn red\" aria-hidden=\"true\">Oui</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- update".ucfirst($componentName)." box end --> 
                                            <!-- delete".ucfirst($componentName)." box begin -->
                                            <div id=\"delete".ucfirst($componentName)."<?= \$".$componentName."->id() ?>\" class=\"modal modal-big hide fade in\" tabindex=\"-1\" role=\"dialog\" aria-hidden=\"false\">
                                                <div class=\"modal-header\">
                                                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\"></button>
                                                    <h3>Supprimer ".ucfirst($componentName)."</h3>
                                                </div>
                                                <form class=\"form-horizontal\" action=\"../app/Dispatcher.php\" method=\"post\">
                                                    <div class=\"modal-body\">
                                                        <h4 class=\"dangerous-action\">Êtes-vous sûr de vouloir supprimer ".ucfirst($componentName)." : <?= \$".$componentName."->".$attributes[0]."() ?> ? Cette action est irréversible!</h4>
                                                    </div>
                                                    <div class=\"modal-footer\">
                                                        <div class=\"control-group\">
                                                            <div class=\"controls\">
                                                                <input type=\"hidden\" name=\"id".ucfirst($componentName)."\" value=\"<?= \$".$componentName."->id() ?>\" />
                                                                <input type=\"hidden\" name=\"action\" value=\"delete\" />
                                                                <input type=\"hidden\" name=\"source\" value=\"".$componentName."\" />    
                                                                <button class=\"btn\" data-dismiss=\"modal\" aria-hidden=\"true\">Non</button>
                                                                <button type=\"submit\" class=\"btn red\" aria-hidden=\"true\">Oui</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- delete".ucfirst($componentName)." box end --> 
                                            <?php 
                                            }//end foreach 
                                            //}//end if
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php /*if(\$".$componentName."sNumber != 0){ echo \$pagination; }*/ ?><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('../include/footer.php'); ?>
        <?php include('../include/scripts.php'); ?>     
        <script>jQuery(document).ready( function(){ App.setPage(\"table_managed\"); App.init(); } );</script>
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
