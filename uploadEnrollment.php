<?php
	if(isset($_POST['elementaryData'])){
		include('fdatabase.php');
		$insertedId = array();
		$currDate = date('Y-m-d');
		$month = $_POST['month'];
		$errorCnt = 0;
		$schYear = $_POST['schoolyear'];
		//check existing upload
		$monthYear = "select count(*) as count from enrollment where schoolyear = '$schYear' and month = '$month' and type = '1'";
		$monthIns = mysqli_query($fconn2,$monthYear);
		$monthRow = mysqli_fetch_array($monthIns,MYSQLI_ASSOC);
		$count = $monthRow['count'];
		if($count > 0){
			echo 2;
		}else{
			foreach($_POST['elementaryData'] as $school){
				$schid = getOfficeId($school[0]);
				$k1m = $school[1];
				$k1f = $school[2];
				$g1m = $school[3];
				$g1f = $school[4];
				$g2m = $school[5];
				$g2f = $school[6];
				$g3m = $school[7];
				$g3f = $school[8];
				$g4m = $school[9];
				$g4f = $school[10];
				$g5m = $school[11];
				$g5f = $school[12];
				$g6m = $school[13];
				$g6f = $school[14];
				$ngm = $school[15];
				$ngf = $school[16];
				
				$uplQuery = "insert into enrollment(office_id,upload_date,k_m,k_f,g1_m,g1_f,g2_m,g2_f,g3_m,g3_f,g4_m,g4_f,g5_m,g5_f,g6_m,g6_f,ng_m,ng_f,schoolyear,type,month)values('$schid','$currDate','$k1m','$k1f','$g1m','$g1f','$g2m','$g2f','$g3m','$g3f','$g4m','$g4f','$g5m','$g5f','$g6m','$g6f','$ngm','$ngf','$schYear','1','$month')";
				if(mysqli_query($fconn2,$uplQuery)){
					array_push($insertedId,mysqli_insert_id($fconn2));
				}else{
					$errorCnt++;
					break;
				}
			}
			if($errorCnt == 0){
				echo 0;
			}else{
				echo $delete = "delete from enrollment where enrollment_id in ('".implode("','",$insertedId)."')";
				$insert = mysqli_query($fconn2,$delete);
				echo 1;
			}
		}
		
	}
	if(isset($_POST['jhs'])){
		include('fdatabase.php');
		$insertedId = array();
		$currDate = date('Y-m-d');
		$month = $_POST['month'];
		$errorCnt = 0;
		$schYear = $_POST['schoolyear'];
		//check existing upload
		$monthYear = "select count(*) as count from enrollment where schoolyear = '$schYear' and month = '$month' and type = '2'";
		$monthIns = mysqli_query($fconn2,$monthYear);
		$monthRow = mysqli_fetch_array($monthIns,MYSQLI_ASSOC);
		$count = $monthRow['count'];
		if($count > 0){
			echo 2;
		}else{
			foreach($_POST['jhs'] as $school){
				$schid = getOfficeId($school[0]);
				$_7m = $school[1];
				$_7f = $school[2];
				$_8m = $school[3];
				$_8f = $school[4];
				$_9m = $school[5];
				$_9f = $school[6];
				$_10m = $school[7];
				$_10f = $school[8];
				
				$uplQuery = "insert into enrollment(office_id,upload_date,g7_m,g7_f,g8_m,g8_f,g9_m,g9_f,g10_m,g10_f,schoolyear,type,month)values('$schid','$currDate','$_7m','$_7f','$_8m','$_8f','$_9m','$_9f','$_10m','$_10f','$schYear','2','$month')";
				if(mysqli_query($fconn2,$uplQuery)){
					array_push($insertedId,mysqli_insert_id($fconn2));
				}else{
					$errorCnt++;
					break;
				}
			}
			if($errorCnt == 0){
				echo 0;
			}else{
				echo $delete = "delete from enrollment where enrollment_id in ('".implode("','",$insertedId)."')";
				$insert = mysqli_query($fconn2,$delete);
				echo 1;
			}
		}
		
	}
	if(isset($_POST['shs'])){
		include('fdatabase.php');
		$insertedId = array();
		$currDate = date('Y-m-d');
		$month = $_POST['month'];
		$errorCnt = 0;
		$schYear = $_POST['schoolyear'];
		//check existing upload
		$monthYear = "select count(*) as count from enrollment where schoolyear = '$schYear' and month = '$month' and type = '3'";
		$monthIns = mysqli_query($fconn2,$monthYear);
		$monthRow = mysqli_fetch_array($monthIns,MYSQLI_ASSOC);
		$count = $monthRow['count'];
		if($count > 0){
			echo 2;
		}else{
			foreach($_POST['shs'] as $school){
				$schid = getOfficeId($school[0]);
				$abm_g11m = $school[1];
				$abm_g11f = $school[2];
				$humss_g11m = $school[3];
				$humss_g11f = $school[4];
				$stem_g11m = $school[5];
				$stem_g11f = $school[6];
				$gas_g11m = $school[7];
				$gas_g11f = $school[8];
				$tvl_g11m = $school[9];
				$tvl_g11f = $school[10];
				$sports_g11m = $school[11];
				$sports_g11f = $school[12];
				$arts_g11m = $school[13];
				$arts_g11f = $school[14];
				$abm_g12m = $school[15];
				$abm_g12f = $school[16];
				$humss_g12m = $school[17];
				$humss_g12f = $school[18];
				$stem_g12m = $school[19];
				$stem_g12f = $school[20];
				$gas_g12m = $school[21];
				$gas_g12f = $school[22];
				$tvl_g12m = $school[23];
				$tvl_g12f = $school[24];
				$sports_g12m = $school[25];
				$sports_g12f = $school[26];
				$arts_g12m = $school[27];
				$arts_g12f = $school[28];
				
				$uplQuery = "insert into enrollment(office_id,upload_date,g11_m_ABM,g11_f_ABM,g11_m_HUMSS,g11_f_HUMSS,g11_m_STEM,g11_f_STEM,g11_m_GAS,g11_f_GAS,g11_m_TVL,g11_f_TVL,g11_m_SPORTS,g11_f_SPORTS,g11_m_ARTS,g11_f_ARTS,g12_m_ABM,g12_f_ABM,g12_m_HUMSS,g12_f_HUMSS,g12_m_STEM,g12_f_STEM,g12_m_GAS,g12_f_GAS,g12_m_TVL,g12_f_TVL,g12_m_SPORTS,g12_f_SPORTS,g12_m_ARTS,g12_f_ARTS,schoolyear,type,month)values('$schid','$currDate','$abm_g11m','$abm_g11f','$humss_g11m','$humss_g11f','$stem_g11m','$stem_g11f','$gas_g11m','$gas_g11f','$tvl_g11m','$tvl_g11f','$sports_g11m','$sports_g11f','$arts_g11m','$arts_g11f','$abm_g12m','$abm_g12f','$humss_g12m','$humss_g12f','$stem_g12m','$stem_g12f','$gas_g12m','$gas_g12f','$tvl_g12m','$tvl_g12f','$sports_g12m','$sports_g12f','$arts_g12m','$arts_g12f','$schYear','3','$month')";
				if(mysqli_query($fconn2,$uplQuery)){
					array_push($insertedId,mysqli_insert_id($fconn2));
				}else{
					$errorCnt++;
					break;
				}
			}
			if($errorCnt == 0){
				echo 0;
			}else{
				echo $delete = "delete from enrollment where enrollment_id in ('".implode("','",$insertedId)."')";
				$insert = mysqli_query($fconn2,$delete);
				echo 1;
			}
		}
		
	}
	if(isset($_POST['schtype'])){
		include('fdatabase.php');
		$schType = $_POST['type'];
		$schoolyear = array();
		$query = "select distinct(schoolyear) from enrollment where type = '$schType' order by schoolyear asc";
		$queryIns = mysqli_query($fconn2,$query);
		
		while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
			array_push($schoolyear,$queryRow['schoolyear']);
		} 
		echo json_encode($schoolyear);
	}
	if(isset($_POST['schYear'])){
		include('fdatabase.php');
		$schYear = $_POST['schYear'];
		$monthArr = array();
		$query = "select distinct(month) from enrollment where schoolyear = '$schYear' order by month asc";
		$queryIns = mysqli_query($fconn2,$query);
		
		while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
			array_push($monthArr,$queryRow['month']);
		} 
		echo json_encode($monthArr);
	}
	if(isset($_POST['tableShow'])){
		include('fdatabase.php');
		$schYear = $_POST['schyear'];
		$month = $_POST['month'];
		$type = $_POST['type'];

		$query = "select * from enrollment where month = '$month' and schoolyear = '$schYear' and type = '$type'";
		$arrayEnr = array();
		$queryIns = mysqli_query($fconn2,$query);
		if($type == "1"){
			while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
				$school = getSchool($queryRow['office_id']);
				$enrArray = array($school,$queryRow['k_m'],$queryRow['k_f'],$queryRow['g1_m'],$queryRow['g1_f'],$queryRow['g2_m'],$queryRow['g2_f'],$queryRow['g3_m'],$queryRow['g3_f'],$queryRow['g4_m'],$queryRow['g4_f'],$queryRow['g5_m'],$queryRow['g5_f'],$queryRow['g6_m'],$queryRow['g6_f'],$queryRow['ng_m'],$queryRow['ng_f']);
				array_push($arrayEnr,$enrArray);
			}
			echo json_encode($arrayEnr);
		}else if($type == '2'){
			//jhs
			while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
				$school = getSchool($queryRow['office_id']);
				$enrArray = array($school,$queryRow['g7_m'],$queryRow['g7_f'],$queryRow['g8_m'],$queryRow['g8_f'],$queryRow['g9_m'],$queryRow['g9_f'],$queryRow['g10_m'],$queryRow['g10_f']);
				array_push($arrayEnr,$enrArray);
			}
			echo json_encode($arrayEnr);
		}else if($type == '3'){
			//shs
			while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
				$school = getSchool($queryRow['office_id']);
				$enrArray = array($school,$queryRow['g11_m_ABM'],$queryRow['g11_f_ABM'],$queryRow['g12_m_ABM'],$queryRow['g12_f_ABM'],$queryRow['g11_m_HUMSS'],$queryRow['g11_f_HUMSS'],$queryRow['g12_m_HUMSS'],$queryRow['g12_f_HUMSS'],$queryRow['g11_m_STEM'],$queryRow['g11_f_STEM'],$queryRow['g12_m_STEM'],$queryRow['g12_f_STEM'],$queryRow['g11_m_GAS'],$queryRow['g11_f_GAS'],$queryRow['g12_m_GAS'],$queryRow['g12_f_GAS'],$queryRow['g11_m_TVL'],$queryRow['g11_f_TVL'],$queryRow['g12_m_TVL'],$queryRow['g12_f_TVL'],$queryRow['g11_m_SPORTS'],$queryRow['g11_f_SPORTS'],$queryRow['g12_m_SPORTS'],$queryRow['g12_f_SPORTS'],$queryRow['g11_m_ARTS'],$queryRow['g11_f_ARTS'],$queryRow['g12_m_ARTS'],$queryRow['g12_f_ARTS'],);
				array_push($arrayEnr,$enrArray);
			}
			echo json_encode($arrayEnr);
		}
		
		
	}
	if(isset($_POST['chckschID'])){
		$schID = array();
		$_POST['chckschID'];
		foreach($_POST['chckschID'] as $id){
			array_push($schID,getOfficeId($id));
		}
		echo json_encode($schID);
	}
	function getSchool($id){
		include('fdatabase.php');
		$query = "select * from tbl_office where id = '$id'";
		$queryIns = mysqli_query($fconn2,$query);
		$queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC);
		
		return strtoupper($queryRow['office_name'])." (".$queryRow['office_id'].")";
	}
	if(isset($_POST['uploadedEnrollment'])){
		$type = $_POST['type'];
		include('fdatabase.php');
		$enrollmentQue = "select distinct month,schoolyear from enrollment where type = '$type'";
		$enrollmentIns = mysqli_query($fconn2,$enrollmentQue);
		$arrayEnrollment = array(); 
		while($enrollmentRow = mysqli_fetch_array($enrollmentIns,MYSQLI_ASSOC)){
			$x = array($enrollmentRow['month'],$enrollmentRow['schoolyear']);
			array_push($arrayEnrollment,$x);
		}
		echo json_encode($arrayEnrollment);
	}
	function getOfficeId($office_id){
		include('fdatabase.php');
		$offId = $office_id;
		$select = "select * from tbl_office where office_id = '$offId'";
		$insert = mysqli_query($fconn2,$select);
		$queryRow = mysqli_fetch_all($insert,MYSQLI_BOTH);
		
		if(count($queryRow) > 0){
			return $id = $queryRow[0]['id'];
		}else{
			return "non-existent";
		}
	}
	

?>