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
		</style>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
		<div class="container">
		<?php include_once dirname(__DIR__) . "/nav.php"; ?>

        <form action="/mvcpractice/employee/updateSave/<?php echo $data[0]->employeeNumber?>" method="POST">
            <input name="employeeNumber" type="hidden" value="<?php echo $data[0]->employeeNumber;?>" >
            <br><label>First Name</label><input name="firstName" value="<?php echo $data[0]->firstName;?>">
            <br><label>Last Name</label><input name="lastName" value="<?php echo $data[0]->lastName;?>">
            <br><label>Email</label><input name="email" value="<?php echo $data[0]->email;?>">
            <br><label>Job Title</label><select name="jobTitle">
        <?php
        // Loop through the job titles and create an option for each
        foreach($arrJobTitles as $objJobTitle) {
            // If this job title is the same as the employee's current job title, make it selected
            $selected = ($objJobTitle->jobTitle == $data[0]->jobTitle) ? "selected" : "";
            echo "<option value='" . $objJobTitle->jobTitle . "' $selected>" . $objJobTitle->jobTitle . "</option>";
        }
        ?>
    </select>

    <br><label>Reports To</label><select name="reportsTo">
        <?php
        // Loop through the job titles and create an option for each
      foreach($arrReportsTo as $objEmployee) {
    // Concatenate the firstName and lastName to display both in the option text
    $fullName = $objEmployee->firstName . " " . $objEmployee->lastName;

    // Create the option element with both first name and last name
    echo "<option value='" . $objEmployee->employeeNumber . "'>" . $fullName . "</option>";
}
        ?>
    </select>
            <br><input type="submit" value="Save Update">
        </form>
		
		</div>
    </body>
</html>