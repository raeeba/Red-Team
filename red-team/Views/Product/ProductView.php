<?php
$path =$_SERVER['SCRIPT_NAME'];
?>

<html>
<head>
<title> Product List</title>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <div class=container>
    <?php include_once dirname(__DIR__) . "/nav.php";?>


    <table class="table table-striped">
        <thead>
        <tr>
                <th> Product Code </th>
                <th>Product Name</th>
                <th>Product Line</th>
                <th>Description</th>
                <th>Quantity in stock</th>
                <th>Price</th>
                <th></th>
        </tr>
        </thead>
        <tbody>

<?php
                foreach($data as $row) {
                    echo "<tr>";
					echo "<td>" . $row->productCode . "</td>" 
                        . "<td>" . $row->productName . "</td>" 
                        . "<td>" . $row->productLine .  "</td>"
                        . "<td>" . $row->productDescription . "</td>"
                        . "<td>" . $row->quantityInStock . "</td>"
					
                        . "<td>" . $row->buyPrice . "</td>";

					echo "<td><a href='/mvcpractice/product/view/".$row->productCode."'>View</a></td>";
					echo "<td><a href='/mvcpractice/product/update/".$row->productCode."'>Edit</a></td>";
                    echo "<td><a href='/mvcpractice/product/delete/".$row->productCode."'>Delete</a></td>";


                    echo "</tr>";
                
                }
            ?>

        </tbody>

            </table>
            <?php echo "<a href='/mvcpractice/product/add'>Add Products</a>" ?>


    </div>

            </body>




</html>