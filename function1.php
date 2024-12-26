
<?
session_start();
include('../../config/config_path.php');
include('../../config/fdatabase.php');

if(isset($_POST['create_ams'])){
  $nowDate = date("Y-m-d H:i:s");
  $user_id = $_SESSION['personnel'];
  $select1 = $_POST['select1'];
  $select2 = $_POST['select2'];
  $article = $_POST['article'];
  $type = $_POST['type'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $sn = $_POST['sn'];
  $useful_life = $_POST['useful_life'];
  $description = $type;
  $property_no = $_POST['property_no'];
  $measurement = $_POST['measurement'];
  $unit_value = $_POST['unit_value'];
  $qty_card = $_POST['qty_card'];
  $qty_count = $_POST['qty_count'];
  $qty_short = $_POST['qty_short'];
  $value_short = $_POST['value_short'];
  $remarks = $_POST['remarks'];
  $account_off = $_POST['account_off'];

  $check_query = "SELECT * FROM asset WHERE description = '$description' AND unit_val = '$unit_value' AND property_no = '$property_no' AND remarks = '$remarks'";
  $result = mysqli_query($fconn, $check_query);

  if (mysqli_num_rows($result) == 0) {
    $query = "INSERT INTO asset(asset_id,user_id,asset_subid,article_id,asset_type,brand,model,asset_sn,useful_life,description,property_no,unit_meas,unit_val,qty_property_card,qty_physical_count,shortage_qty,shortage_value,remarks,account_officer,date)VALUES
    ('$select1','$user_id','$select2','$article','$type','$brand','$model','$sn','$useful_life','$description','$property_no','$measurement','$unit_value','$qty_card', '$qty_count', '$qty_short','$value_short','$account_off','$remarks','$nowDate')";  
    if(mysqli_query($fconn,$query)){
 
      $_SESSION['success_message'] = "Asset created successfully!";
    }else{
     
      $_SESSION['error_message'] = "Something went wrong while creating asset. If the error persists, please contact your ICT.";
    }
  
    header("Location: data.php");
    exit();
  }
}
?>