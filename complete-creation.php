<?php
session_start();
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nodom Generator | Welcome</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <div class="row">
      <div class="large-12 columns">
        <h1>Nodom Generator</h1>
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
      	<div class="panel">
	        <h3>Welcome to Nodom Generator! </h3>
	        <p>Here you can create your project just on taping your "component" name.</p>
	        <p>This will generate 3 files : </p>
	        <div class="row">
	        	<div class="large-4 medium-4 columns">
	    		<p><a>Component.php</a><br />This file contains our your component Model including attributes, setters and getters.</p>
	    	</div>
	        	<div class="large-4 medium-4 columns">
	        		<p><a>ComponentManager.php</a><br />In this file you'll find the baisc CRUD methods.</p>
	        	</div>
	        	<div class="large-4 medium-4 columns">
	        		<p><a>t_component.sql</a><br />Your table and its structure it's stored in this file.</p>
	        	</div>        
					</div>
      	</div>
      </div>
    </div>

    <div class="row">
      <div class="large-8 medium-8 columns">
        <!-- Grid Example -->
        <div class="row">
          <div class="large-12 columns">
            <div class="callout panel">
            	<?php
            	if(isset($_SESSION['generator-success'])){
            		echo '<p style="color: blue"><strong>'.$_SESSION['generator-success'].'</strong></p>';
            		unset($_SESSION['generator-success']);
            	}
            	?>
              	<form method="post" action="controller/GeneratorCompleteController.php">
				  <!--div class="row"-->
				  	<?php
				  	$attributesNumber = $_SESSION['attributesNumber'];
				  	for($i=0; $i < $attributesNumber; $i++) {
				  	?>	
				    <div class="large-6 medium-6 columns">
				      <label>Attribute Name</label>
				      <input type="text" name="attributes[]" placeholder="" />
				    </div>
				    <div class="large-6 columns">
				      <label>Attribute Type</label>
				      <select name="attributesTypes[]">
				      	<option value="INT(12)">INT</option>
				        <option value="DECIMAL(12,2)">DECIMAL</option>
				        <option value="VARCHAR(50)">VARCHAR(50)</option>
				        <option value="VARCHAR(100)">VARCHAR(100)</option>
				        <option value="VARCHAR(255)">VARCHAR(255)</option>
				        <option value="TEXT">TEXT</option>
				        <option value="DATE">DATE</option>
				        <option value="DATE TIME">DATE TIME</option>
				      </select>
				    </div>
				  <!--/div-->
				  	<?php		  
					}
				  	?>
					<br>	  
				  <input type="submit" value="Generate" class="button" />
				</form>
            </div>
          </div>
        </div>
      </div>     

      <div class="large-4 medium-4 columns">           
		<div class="panel">
        	<h5>About Nodom Generator</h5>
        	<p>It's just a "barbarian" tool that i created to help myself keep coding and pay my bills :) .</p>       
        </div>
      </div>
      <!-- foundation code end -->
    </div>
    
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
