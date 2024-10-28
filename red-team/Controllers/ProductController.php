<?php
include_once "Models/Product.php";
include_once "Controllers/Controller.php";


class ProductController extends Controller{

function route(){
   
        $action = isset($_GET['action']) ? $_GET['action'] : "ProductView";
        $id = isset($_GET['id']) ?($_GET['id']) : "";
    
    if($action=="defaultView"){
        $action= "ProductView";
        }

        echo "Action: " . $action . "<br>";
        echo "ID: " . $id . "<br>";
    
        if ($action == "ProductView") {
          $product=Product::list();
          $this->render("Product", "ProductView", $product);


        }else if($action=="view"){
            $product = new Product($id);
            $this->render("Product", "view", array($product));
           
        }else if($action=="update"){
            $product = new Product($id);
            $productList = Product::listProductLine();
            $this->render("Product", "update", ['productArr'=>$productList, 'data'=>array($product)]);
        }else if($action=="updateSave"){
            $product= new Product($id);
            $product->updateSave($_POST);
            header("location: /mvcpractice/product");  
              
        } else if($action =="delete"){
            $product = new Product($id);
            $product -> delete($id);
            header("location: /mvcpractice/product");

        }else if($action=="add"){
           $product=Product::listProductLine();
           $this->render("Product", "add",['productLineArr'=>$product]);

        }else if($action=="insert"){
            $product=new Product();
        $product->insert($_POST);
        
        header("location: /mvcpractice/product");
        }
    }
    


}





?>