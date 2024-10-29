<html>
    <head>
        <title>Home Page</title>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

		<style>
			img{
				width: 100%;
			}
		</style>

    </head>
    <body>
		<div class="container">
		<?php 
			$path = $_SERVER['SCRIPT_NAME'];

            //DIR takes the current directory: MVCPRACTICE/Views/Home
            //dirname takes the folder right about the directory in the parnthesis
            // Dirname returns MVCPRACTICE/Views
			include_once dirname(__DIR__) . "/nav.php";
		?>
		
			<h1>Home Page</h1>
			
            <img src="smash.png" alt="Smash Bros" width="auto">
			
            <!--
			-->
		</div>
    </body>
</html>