
<div class="container">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

        <?php include_once dirname(__DIR__) . "/nav.php";?>

<form action="/mvcpractice/employee/insert" method="POST">
<table>
	
<tr>
		<td><label>Employee Number</label></td>
		<td><input name="employeeNumber" ></td>
	</tr>
	<tr>
		<td><label>Last Name</label></td>
		<td><input name="lastName" ></td>
	</tr>

	<tr>
		<td><label>First Name</label></td>
		<td><input name="firstName"></td>
	</tr>

	<tr>
		<td><label>Extension</label></td>
		<td><input name="extension" style="width:255px;" ></td>
	</tr>
    <tr>
		<td><label>Email</label></td>
		<td><input name="email" style="width:255px;" ></td>
	</tr>

    <tr>
		<td><label>Office Code</label></td>
		<td><input name="officeCode" style="width:255px;" ></td>
	</tr>

    <tr>
		<td><label>Job Title</label></td>
		<td><select name="jobTitle">
        <?php
        // Loop through the job titles and create an option for each
        foreach($arrJobTitles as $objJobTitle) {
            // If this job title is the same as the employee's current job title, make it selected
            $selected = ($objJobTitle->jobTitle == $data[0]->jobTitle) ? "selected" : "";
            echo "<option value='" . $objJobTitle->jobTitle . "' $selected>" . $objJobTitle->jobTitle . "</option>";
        }
        ?>
    </select> </td>
	</tr>

    <tr>
		<td><label>Reports To</label></td>
		<td><select name="reportsTo">
        <?php
        // Loop through the job titles and create an option for each
      foreach($arrReportsTo as $objEmployee) {
    // Concatenate the firstName and lastName to display both in the option text
    $fullName = $objEmployee->firstName . " " . $objEmployee->lastName;

    // Create the option element with both first name and last name
    echo "<option value='" . $objEmployee->employeeNumber . "'>" . $fullName . "</option>";
}
        ?>
    </select></td>
	</tr>

	
	<tr>
		<td><label></label></td>
		<td><input type="submit"></td>
	</tr>
</table>
</form>

</div>