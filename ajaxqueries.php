<?php
	if(isset($_POST['ols_signatories'])){
		include('fdatabase.php');
		include('ldnFunction.php');
		$id = "";
		$signatoryArray = array();
		$nameArray = array();
		$hrisArray = array();
		$positionArray = array();
		$dateFromArr = array();
		$datetoArr = array();
		$roleArr = array();
		$remarks = array();
		////////////////////////////////////////////////////////////////////////
		$query = "select id from tbl_leave_signatory";
		$queryIns = mysqli_query($fconn2,$query);
		while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
			$signatory = new ols_signatory($queryRow['id']);
			array_push($nameArray,$signatory->getDetail('name'));
			array_push($hrisArray,$signatory->getDetail('hris'));
			array_push($positionArray,$signatory->getDetail('position'));
			array_push($dateFromArr,$signatory->getDetail('date_from'));
			array_push($datetoArr,$signatory->getDetail('date_to'));
			array_push($roleArr,$signatory->getDetail('role'));
			array_push($remarks,$signatory->getDetail('remarks'));
			
		}
		array_push($signatoryArray,$nameArray,$hrisArray,$positionArray,$dateFromArr,$datetoArr,$roleArr,$remarks);
		echo json_encode($signatoryArray);
		
	}

?>