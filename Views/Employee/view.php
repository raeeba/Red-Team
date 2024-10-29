<?php
$path = $_SERVER['SCRIPT_NAME'];
?>
<html>
    <head>
        <title>Profile</title>
		<style>
			label{
				display: inline-block;
				width: 150px;
			}
			input[type='button']{
				width: 150px;
			}
		</style>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
		<div class="container">
		<?php include_once dirname(__DIR__) . "/nav.php"; ?>

        <br><label>Employee Number</label><input name="employeeNumber" value="<?php echo $data[0]->employeeNumber;?>" disabled>
            <br><label>Last Name</label><input name="lastName" value="<?php echo $data[0]->lastName;?>" disabled>
            <br><label>First Name</label><input name="firstName" value="<?php echo $data[0]->firstName;?>" disabled>
            <br><label>Extension</label><input name="extension" value="<?php echo $data[0]->extension;?>" disabled>
            <br><label>Email</label><input name="email" value="<?php echo $data[0]->email;?>" disabled>
            <br><label>Office Code</label><input name="officeCode" value="<?php echo $data[0]->officeCode;?>" disabled>
            <br><label>Reports To</label><input name="reportsTo" value="<?php echo $data[0]->reportsTo;?>" disabled>
            <br><label>Job Title</label><input name="jobTitle" value="<?php echo $data[0]->jobTitle;?>" disabled>

            <br><a href="/mvcpractice/employee"><input type="button" value="Go to Employee list"></a>
            <a href="/mvcpractice/employee/update/<?php echo $data[0]->employeeNumber;?>"><input type="button" value="Modify"></a>
		
		
		</div>
    </body>
</html>