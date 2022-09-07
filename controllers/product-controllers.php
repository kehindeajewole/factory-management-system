<?php

//store error variables
$errors = array();

/**Handle all SKU related features **/
$skuname = "";
$skuimage = "";

//get the customer details on submit and validate
if ( isset( $_POST['add-sku'] ) ) {
    $skuname = filter_var($_POST['sku-name'], FILTER_SANITIZE_STRING);

    //validation
    if ( empty($skuname) ) {
        $errors['skuname'] = "SKU Name Required";
    }
    if(!empty($_FILES['sku-image']['name'])) {
        $image_name = time() . '_' . $_FILES['sku-image']['name'];
        $destination = ABSPATH . "/assets/images/" . $image_name;
        $result = move_uploaded_file($_FILES['sku-image']['tmp_name'], $destination);

        if ($result) {
            $skuimage = $image_name;
        } else {
            $errors['skuimage'] = "Failed to upload image";
        }      
    } else {
        $errors['skuimage'] = "SKU image required";
    }

    if ( count($errors) === 0 ) {
        $sql = "INSERT INTO skus (sku_name, sku_image) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $skuname, $skuimage);

        if ( $stmt->execute() ) {
            $skuname = "";
            $skuimage = "";  

            $success['sku_add_success'] = "SKU Added Successfully";
        } else {
            $errors['sku_add_fail'] = "SKU addition failed: Please try again later";
        }
    } else {
        $errors['sku_add_fail'] = "One or more fields has errors.";
    }

}

//Update SKU details STEP 1: Get data from DB
if ( isset($_GET['seid']) ) {
    $skuId = htmlspecialchars($_GET['seid']);

    $dataQuery = "SELECT * FROM skus WHERE sku_id=? LIMIT 1";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $skuId);
    $stmt->execute();
    $result = $stmt->get_result();
    $sku = $result->fetch_assoc();

    $skuname = $sku['sku_name'];
    $skuimage = $sku['sku_image'];
}

//Update SKU details STEP 2: update DB
if ( isset( $_POST['edit-sku'] ) ) {
    $skuname = filter_var($_POST['sku-name'], FILTER_SANITIZE_STRING);
    $skuimage = htmlspecialchars($_POST['sku-image-curr']);
    $skuId = $_POST['sku-id'];

    //validation
    if ( empty($skuname) ) {
        $errors['skuname'] = "SKU Name Required";
    }
    if(!empty($_FILES['sku-image']['name'])) {
        $image_name = time() . '_' . $_FILES['sku-image']['name'];
        $destination = ABSPATH . "/assets/images/" . $image_name;
        $result = move_uploaded_file($_FILES['sku-image']['tmp_name'], $destination);

        if ($result) {
            $skuimage = $image_name;
        } else {
            $errors['skuimage'] = "Failed to upload image";
        }      
    } else {
        $errors['skuimage'] = "SKU image required";
    }
      
    if ( count($errors) === 0 ) {
        $sql = "UPDATE skus SET sku_name=?, sku_image=? WHERE sku_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $skuname, $skuimage, $skuId );    

        if ( $stmt->execute() ) {
            $success['sku_edit_success'] = "SKU Updated Successfully";
        } else {
            $errors['sku_edit_fail'] = "SKU update failed: Please try again later";
        }   
    } else {
        $errors['sku_edit_fail'] = "One or more fields have errors.";
    }
}


/**Handle all Product related features **/
$prodname = "";
$prodcost = "";
$prodsale = "";
$prodqty = "";
$proddate = "";

$prodnames = [
    '' => 'Select SKU',
];

$skusQuery = "SELECT * FROM skus";
$stmtSkus = $conn->prepare($skusQuery); 
$stmtSkus->execute();
$resultSkus = $stmtSkus->get_result();
$skusQueryCount= $resultSkus->num_rows;

if( $skusQueryCount > 0 ) :
   while ( $row = $resultSkus->fetch_assoc() ):
      $prodnames += [$row["sku_id"] => $row["sku_name"]];
   endwhile;
endif ;

if ( isset( $_POST['add-product'] ) ) {
    $prodname = filter_var($_POST['prod-name'], FILTER_SANITIZE_STRING);
    $prodcost = filter_var($_POST['prod-cost'], FILTER_SANITIZE_STRING);
    $prodsale = filter_var($_POST['prod-sale'], FILTER_SANITIZE_STRING);
    $prodqty = filter_var($_POST['prod-qty'], FILTER_SANITIZE_STRING);
    $proddate = filter_var($_POST['prod-date'], FILTER_SANITIZE_STRING);

    //validation
    if ( empty($prodname) ) {
        $errors['prodname'] = "Please select product SKU";
    }
    if ( empty($prodcost) ) {
        $errors['prodcost'] = "Cost of production required";
    }
    if ( !preg_match("/(^[0-9]*$)/"
    , $prodcost) && !empty($prodcost) ) {
        $errors['prodcost'] = "Please enter a valid integer";
    }
    if ( empty($prodsale) ) {
        $errors['prodsale'] = "Selling price required";
    }
    if ( !preg_match("/(^[0-9]*$)/"
    , $prodsale) && !empty($prodsale) ) {
        $errors['prodsale'] = "Please enter a valid integer";
    }
    if ( empty($prodqty) ) {
        $errors['prodqty'] = "Production quantity required";
    }
    if ( !preg_match("/(^[0-9]*$)/"
    , $prodqty) && !empty($prodqty) ) {
        $errors['prodqty'] = "Please enter a valid integer";
    }
    if ( empty($proddate) ) {
        $errors['proddate'] = "Production date required";
    }

    if ( count($errors) === 0 ) {
        $sql = "INSERT INTO products (prod_name, prod_cost,  prod_sale, prod_qty, prod_manu_date) VALUES (?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $prodname, $prodcost, $prodsale, $prodqty, $proddate);

        if ( $stmt->execute() ) {
            $prodname = "";
            $prodcost = "";
            $prodsale = "";
            $prodqty = "";
            $proddate = ""; 

            $success['prod_add_success'] = "Product Added Successfully";
        } else {
            $errors['prod_add_fail'] = "Product addition failed: Please try again later";
        }
    } else {
        $errors['prod_add_fail'] = "One or more fields has errors.";
    }
}

//Update product details STEP 1: Get data from DB
if ( isset($_GET['peid']) ) {
    $prodId = htmlspecialchars($_GET['peid']);

    $dataQuery = "SELECT * FROM products INNER JOIN skus ON products.prod_name = skus.sku_id WHERE prod_id=?";
    $stmt = $conn->prepare($dataQuery); 
    $stmt->bind_param("s", $prodId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    $prodname = $product['prod_name'];
    $prodcost = $product['prod_cost'];
    $prodsale = $product['prod_sale'];
    $prodqty = $product['prod_qty'];
    $proddate = date('Y-m-d', strtotime($product['prod_manu_date'])); 
}

//Update product details STEP 2: update DB
if ( isset( $_POST['edit-product'] ) ) {
    $prodname = filter_var($_POST['prod-name'], FILTER_SANITIZE_STRING);
    $prodcost = filter_var($_POST['prod-cost'], FILTER_SANITIZE_STRING);
    $prodsale = filter_var($_POST['prod-sale'], FILTER_SANITIZE_STRING);
    $prodqty = filter_var($_POST['prod-qty'], FILTER_SANITIZE_STRING);
    $proddate = filter_var($_POST['prod-date'], FILTER_SANITIZE_STRING);
    $prodId = $_POST['prod-id'];

    //validation
    if ( empty($prodname) ) {
        $errors['prodname'] = "Please select product SKU";
    }
    if ( empty($prodcost) ) {
        $errors['prodcost'] = "Cost of production required";
    }
    if ( !preg_match("/(^[0-9]*$)/"
    , $prodcost) && !empty($prodcost) ) {
        $errors['prodcost'] = "Please enter a valid integer";
    }
    if ( empty($prodqty) ) {
        $errors['prodqty'] = "Production quantity required";
    }
    if ( !preg_match("/(^[0-9]*$)/"
    , $prodqty) && !empty($prodqty) ) {
        $errors['prodqty'] = "Please enter a valid integer";
    }
    if ( empty($prodsale) ) {
        $errors['prodsale'] = "Selling price required";
    }
    if ( !preg_match("/(^[0-9]*$)/"
    , $prodsale) && !empty($prodsale) ) {
        $errors['prodsale'] = "Please enter a valid integer";
    }
    if ( empty($proddate) ) {
        $errors['proddate'] = "Production date required";
    }
      
    if ( count($errors) === 0 ) {
        $sql = "UPDATE products SET prod_name=?, prod_cost=?, prod_sale=?,prod_qty=?, prod_manu_date=? WHERE prod_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $prodname, $prodcost, $prodsale,$prodqty, $proddate, $prodId);    

        if ( $stmt->execute() ) {
            $success['prod_edit_success'] = "Product Updated Successfully";
        } else {
            $errors['prod_edit_fail'] = "Product update failed: Please try again later";
        }   
    } else {
        $errors['prod_edit_fail'] = "One or more fields have errors.";
    }
}