<?php
 session_start();
 include('../../config/fdatabase.php');



 
 if(isset($_POST['save_land'])){

   $nowDate = date("Y-m-d H:i:s");
   $select1 = $_POST['select1'];

  if (isset($_POST['selectedOfficeId1']) && !empty($_POST['selectedOfficeId1'])) {
    $user_id = intval($_POST['selectedOfficeId1']);
} elseif (isset($_SESSION['personnel'])) {
    $user_id = $_SESSION['personnel'];
    $account_id = null; 
} else {
    echo json_encode(['success' => 0, 'error' => 'User is not logged in or office is not selected.']);
    exit();
}


    
   $description = $_POST['description'].' '.'Titled:'.$_POST['titled'].' '.'Date Titled:'.$_POST['date_titled'];
   $property_no = $_POST['property_no'];
   $land_area = $_POST['land_area'];
   $acquisition_cost = $_POST['acquisition_cost'];
   $titled = $_POST['titled'];
   $date_titled = $_POST['date_titled'];
   $date = $_POST['date'];
   $remarks = $_POST['remarks'];
   $date_acq = $_POST['date_acq'];
   $account_id = $account_id ?? $_SESSION['account_id'] ?? null; 


     $query = "INSERT INTO asset (asset_id, user_id, description, property_no, remarks, unit_val, titled, date_titled, land_area, account_id, date_acquired, date)
               VALUES ('$select1', '$user_id', '$description', '$property_no', '$remarks', '$acquisition_cost', '$titled', '$date_titled', '$land_area', '$account_id', '$date_acq', '$date')";  
     if(mysqli_query($fconn,$query)){
       echo json_encode(['success' => 1]);
     } else {
       echo json_encode(['success' => 0, 'error' => 'Failed to insert data into database.']);
     }
   }

 




 if (isset($_POST['save_asset'])) {
  $nowDate = date("Y-m-d H:i:s");

  if (isset($_POST['selectedOfficeId']) && !empty($_POST['selectedOfficeId'])) {
      $user_id = intval($_POST['selectedOfficeId']);
  } elseif (isset($_SESSION['personnel'])) {
      $user_id = $_SESSION['personnel'];
      $account_id = null; 
  } else {
      echo json_encode(['success' => 0, 'error' => 'User  is not logged in or office is not selected.']);
      exit();
  }

  $select1 = $_POST['select1'];
  $select2 = $_POST['select2'];
  $quantity = $_POST['quantity']?? null;
  $article = $_POST['article'];
  $type = $_POST['type'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $sn = $_POST['sn'];
  $useful_life = $_POST['useful_life'];
  $description = $type;
  $property_no = $_POST['property_no'];
  $stock = $_POST['stock'];
  $measurement = $_POST['measurement'];
  $unit_value = $_POST['unit_value'];
  $qty_card = $_POST['qty_card'];
  $qty_count = $_POST['qty_count'];
  $qty_short = $_POST['qty_short'];
  $value_short = $_POST['value_short'];
  $remarks = $_POST['remarks'];
  $date_acq = $_POST['date_acq'];
  $account_off = $_POST['account_off'];
  $fund_source = $_POST['fund_source'];
  $account_id = $account_id ?? $_SESSION['account_id'] ?? null; 
  $supplier =  $_POST['supplier'] ?? null; 

  $query = "INSERT INTO asset(asset_id, user_id, asset_subid, quantity, article_id, asset_type, brand, model, asset_sn, useful_life, description, property_no, stock_no, unit_meas, unit_val, qty_property_card, qty_physical_count, shortage_qty, shortage_value, account_officer,supplier, fund_source, account_id, remarks, date_acquired, date) 
            VALUES ('$select1', '$user_id', '$select2','$quantity','$article', '$type', '$brand', '$model', '$sn', '$useful_life', '$description', '$property_no', '$stock', '$measurement', '$unit_value', '$qty_card', '$qty_count', '$qty_short', '$value_short', '$account_off', '$supplier', '$fund_source', '$account_id', '$remarks', '$date_acq', '$nowDate')";

  if (mysqli_query($fconn, $query)) {
      echo json_encode(['success' => 1]);
  } else {
      echo json_encode(['success' => 0, 'error' => 'Failed to insert data into database.']);
  }
}



?>