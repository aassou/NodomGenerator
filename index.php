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
	        <p>This will generate 6 files : </p>
	        <div class="row">
	        	<div class="large-4 medium-4 columns">
	    			<p><a>Component.php</a><br />This file contains your component Model including attributes, setters and getters.</p>
	    		</div>
	        	<div class="large-4 medium-4 columns">
	        		<p><a>ComponentManager.php</a><br />In this file you'll find the baisc CRUD methods.</p>
	        	</div>
	        	<div class="large-4 medium-4 columns">
	        		<p><a>t_component.sql</a><br />Your table and its structure it's stored in this file.</p>
	        	</div>        
			</div>
			<div class="row">
                <div class="large-4 medium-4 columns">
                    <p><a>ComponentActionController.php</a><br />This file is the bridge between your Views and your business.</p>
                </div>
                <div class="large-4 medium-4 columns">
                    <p><a>ComponentView.php</a><br />In this file we create the minimum structure of a view.</p>
                </div>
                <div class="large-4 medium-4 columns">
                    <p><a>ComponentPrint.php</a><br />This file is used for reporting and PDF files generation.</p>
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
            		echo '<p style="color: green"><strong>'.$_SESSION['generator-success'].'</strong></p>';
            		unset($_SESSION['generator-success']);
            	}
				if(isset($_SESSION['generator-error'])){
            		echo '<p style="color: red"><strong>'.$_SESSION['generator-error'].'</strong></p>';
            		unset($_SESSION['generator-error']);
            	}
            	?>
              	<form method="post" action="controller/GeneratorController.php">
				  <div class="row">
				    <div class="large-4 medium-4 columns">
				      <label>Component Name</label>
				      <input type="text" name="componentName" placeholder="like Student, Person ..." />
				    </div>
				    <div class="large-4 medium-4 columns">
				      <label>Project Path</label>
				      <input type="text" name="componentLocation" placeholder="/home/abdel/workspace/mido-job" value="/home/abdel/workspace/mido-job" />
				    </div>
				    <div class="large-4 medium-4 columns">
				      <label>Attributes Number</label>
				      <input type="text" name="attributesNumber" placeholder="5..." />
				    </div>
				  </div>
				  <input type="submit" value="Generate" class="button" />
				</form>
            </div>
          </div>
        </div>
        <!-- foundation code begin -->
        <!--hr />
        <h5>We bet you&rsquo;ll need a form somewhere:</h5>
        <form>
				  <div class="row">
				    <div class="large-12 columns">
				      <label>Input Label</label>
				      <input type="text" placeholder="large-12.columns" />
				    </div>
				  </div>
				  <div class="row">
				    <div class="large-4 medium-4 columns">
				      <label>Input Label</label>
				      <input type="text" placeholder="large-4.columns" />
				    </div>
				    <div class="large-4 medium-4 columns">
				      <label>Input Label</label>
				      <input type="text" placeholder="large-4.columns" />
				    </div>
				    <div class="large-4 medium-4 columns">
				      <div class="row collapse">
				        <label>Input Label</label>
				        <div class="small-9 columns">
				          <input type="text" placeholder="small-9.columns" />
				        </div>
				        <div class="small-3 columns">
				          <span class="postfix">.com</span>
				        </div>
				      </div>
				    </div>
				  </div>
				  <div class="row">
				    <div class="large-12 columns">
				      <label>Select Box</label>
				      <select>
				        <option value="husker">Husker</option>
				        <option value="starbuck">Starbuck</option>
				        <option value="hotdog">Hot Dog</option>
				        <option value="apollo">Apollo</option>
				      </select>
				    </div>
				  </div>
				  <div class="row">
				    <div class="large-6 medium-6 columns">
				      <label>Choose Your Favorite</label>
				      <input type="radio" name="pokemon" value="Red" id="pokemonRed"><label for="pokemonRed">Radio 1</label>
				      <input type="radio" name="pokemon" value="Blue" id="pokemonBlue"><label for="pokemonBlue">Radio 2</label>
				    </div>
				    <div class="large-6 medium-6 columns">
				      <label>Check these out</label>
				      <input id="checkbox1" type="checkbox"><label for="checkbox1">Checkbox 1</label>
				      <input id="checkbox2" type="checkbox"><label for="checkbox2">Checkbox 2</label>
				    </div>
				  </div>
				  <div class="row">
				    <div class="large-12 columns">
				      <label>Textarea Label</label>
				      <textarea placeholder="small-12.columns"></textarea>
				    </div>
				  </div>
				</form-->
      </div>     

      <div class="large-4 medium-4 columns">
		  <!--h5>Try one of these buttons:</h5>
		  <p><a href="#" class="small button">Simple Button</a><br/>
	        <a href="#" class="small radius button">Radius Button</a><br/>
	        <a href="#" class="small round button">Round Button</a><br/>            
	        <a href="#" class="medium success button">Success Btn</a><br/>
	        <a href="#" class="medium alert button">Alert Btn</a><br/>
	        <a href="#" class="medium secondary button">Secondary Btn</a></p-->           
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
