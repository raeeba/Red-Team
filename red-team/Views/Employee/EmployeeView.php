<?php
$path = $_SERVER['SCRIPT_NAME'];
//echo "<pre>";var_dump($data[0]);
?>

<html>
    <head>
        <title>Employee List</title>

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
		
		<style>
			td.center{
				text-align: center;
			}
		</style>

    </head>
    <body>
		<div class="container">
		<?php include_once dirname(__DIR__) . "/nav.php"; ?>
        <table class="table table-striped">
			<thead>
            <tr>
                <th>Employee Number</th>
                <th>Name</th>
                <th>Extension</th>
                <th>Email</th>
                <th>Office Code</th>
                <th>Reposts To</th>
                <th>Job Title</th>
            </tr>
            </thead>
            <tbody>
			<?php
                foreach($data as $row) {
                    echo "<tr><td>" . $row->employeeNumber. "</td><td>" 
                        . $row->lastName. ", " . $row->firstName. "</td>";
					echo "<td>" . $row->extension . "</td>";
					echo "<td>" . $row->email . "</td>";
					echo "<td class='center'>" . $row->officeCode . "</td>";
					echo "<td class='center'>" . $row->reportsTo . "</td>";
					echo "<td>" . $row->jobTitle . "</td>";

                	echo "<td><a href='/mvcpractice/employee/view/".$row->employeeNumber."'>View</a></td>";
                    echo "<td><a href='/mvcpractice/employee/viewManagerTree/".$row->employeeNumber."'>Manager Tree</a></td>";
					echo "<td><a href='/mvcpractice/employee/update/".$row->employeeNumber."'>Edit</a></td>";
                    echo "<td><a href='/mvcpractice/employee/delete/".$row->employeeNumber."'>Delete</a></td>";


                    echo "</tr>";
                
                }
            ?>
			</tbody>
        </table>
        <?php echo "<a href='/mvcpractice/employee/add'>Add Employees</a>" ?>

		</div>
    </body>
</html>