<?php
$path =$_SERVER['SCRIPT_NAME'];
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

        <br><label>Name</label><input name="productName" value="<?php echo $data[0]->productName;?>" disabled>
            <br><label>Product Line</label><input name="productLine" value="<?php echo $data[0]->productLine;?>" disabled>
            <br><label>Description</label><input name="productDescription" value="<?php echo $data[0]->productDescription;?>" disabled>
            <br><label>Quanityt in Stock</label><input name="quantityInStock" value="<?php echo $data[0]->quantityInStock;?>" disabled>
            <br><label>Price</label><input name="buyPrice" value="<?php echo $data[0]->buyPrice;?>" disabled>
           
            <br><a href="/mvcpractice/product"><input type="button" value="Go to Product list"></a>
            <a href="/mvcpractice/product/update/<?php echo $data[0]->productCode;?>"><input type="button" value="Modify"></a>
		
		
		</div>
    </body>
</html>