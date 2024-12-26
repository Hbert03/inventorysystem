<?php
include('../../config/config_path.php');
include('../../config/fdatabase.php');




if (isset($_POST['delete'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
}

if (isset($_POST['update'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
    if (mysqli_query($fconn, $query)) {
        echo "Updated Successfully";
    } else {
        echo "Failed to update file in the database.";
    }
} elseif (isset($_POST['delete1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['update1'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}
elseif (isset($_POST['delete2'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['update2'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}

elseif (isset($_POST['delete3'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['update3'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}

elseif (isset($_POST['delete4'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['update4'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}

elseif (isset($_POST['delete5'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['update5'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['deleteland'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['updateland'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['deletebuild1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['updatebuild1'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['deletebuild2'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['updatebuild2'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['deletebuild3'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['updatebuild3'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['rpcppe1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['rpcppe'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}

elseif (isset($_POST['rpci1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['rpci'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}

elseif (isset($_POST['transport1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['transport'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['books1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['books'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['furniture1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['furniture'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}


elseif (isset($_POST['others1'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['others'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}

elseif (isset($_POST['historicaldel'])) {
    $fileId = $_POST['id'];
    $query = "DELETE FROM asset WHERE id = '$fileId'";
    if (mysqli_query($fconn, $query)) {
        echo "Deleted Successfully";
    } else {
        echo "Failed to delete file.";
    }
    exit();
} elseif (isset($_POST['historicalget'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
if (mysqli_query($fconn, $query)) {
echo "Updated Successfully";
} else {
echo "Failed to update file in the database.";
}}



if (isset($_POST['update_ao'])) {
    $dataid = $_POST['id'];
    $value1 = $_POST['description'];
    $value2 = $_POST['property_no'];
    $value3 = $_POST['unit_meas'];
    $value4 = $_POST['unit_val'];
    $value5 = $_POST['qty_property_card'];
    $value6 = $_POST['qty_physical_count'];
    $value7 = $_POST['shortage_qty'];
    $value8 = $_POST['shortage_value'];
    $value9 = $_POST['account_officer'];
    $value10 = $_POST['remarks'];
    $query = "UPDATE asset
    SET description = '$value1', property_no = '$value2', unit_meas = '$value3', 
    unit_val = '$value4', qty_property_card = '$value5', qty_physical_count = '$value6',
    shortage_qty = '$value7', shortage_value = '$value8', account_officer = '$value9', remarks = '$value10'
    WHERE id = '$dataid'";
    if (mysqli_query($fconn, $query)) {
        echo "Updated Successfully";
    } else {
        echo "Failed to update file in the database.";
    }
}
?>