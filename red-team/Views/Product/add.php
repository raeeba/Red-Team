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


        <form action="/mvcpractice/product/insert"  method="POST">

        <label>Product Number</label> <input name="productCode" >
        <br><label>Name</label><input name="productName" >
        <br><label>Product Line</label><select name="productLine">
        <?php
        // Loop through the job titles and create an option for each
      foreach($productLineArr as $objProductLine) {
    // Concatenate the firstName and lastName to display both in the option text
    $selected = ($objProductLine->productLine == $data[0]->productLine) ? "selected" : "";

    // Create the option element with both first name and last name
    echo "<option value='" . $objProductLine->productLine . "' $selected>" . $objProductLine->productLine . "</option>";
}
        ?>
    </select>
            <br><label>Description</label><textarea name="productDescription" cols="50"></textarea>

            <br><label>Quanityt in Stock</label><input name="quantityInStock"  >
            <br><label>Price</label><input name="buyPrice" >
           
            
            <br><input type="submit" value="Save Update">
        </form>
		</div>
    </body>
</html>