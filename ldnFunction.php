<?php
	function getRows($table){
		$select = "select count(*) as count from $table";
		$selIns = mysqli_query($fconn2,$select);
		$selRow = mysqli_fetch_array($selIns,MYSQLI_ASSOC);
		
		return $selRow['count'];
	}
	function cntnonTeaching(){
		$building_structureCounter = "select count(*) as count from asset where asset_id= '2'";
		$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
		$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);
											
											
		return number_format($ROWbuilding_structureCounter['count']);
	}

	function getFullname($hris_code){
		require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
		$nameGet = "select * From tbl_employee where hris_code = '$hris_code'";
		$nameIns = mysqli_query($fconn2,$nameGet);
		$nameRow = mysqli_fetch_array($nameIns,MYSQLI_ASSOC);
		
		$fullname = $nameRow['firstname']." ".$nameRow['middlename']." ".$nameRow['lastname']." ".$nameRow['ext_name'];
		return($fullname);
	}

	function betweenDates($cmpDate,$startDate,$endDate){ 
		if((date($cmpDate) >= date($startDate)) && (date($cmpDate) <= date($endDate))){
			return 1;
		}else{
			return 0;
		}
	}
	// function getSchoolName($office_id){
		// require("fdatabase.php");
		// $schoolQuery = "select * from tbl_office where office_id = '$office_id'";
		// $schoolIns = mysqli_query($fconn2,$schoolQuery);
		// $schoolRow = mysqli_fetch_array($schoolIns,MYSQLI_ASSOC);
		// $school_name = $schoolRow['office_name'];
		// return($school_name);
	// }
	class schoolDetails{
		private $schoolPersonnelCount = '';
		private $schoolHead = '';
		private $schoolLogo = '';
		private $schoolName = '';
		private $districtName = '';
		private $schoolId = '';
		private $sectionCount = '';
		private $officetbl_id = '';
		
		function setSchool($office_id){
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			
			$query = "select *, tbl_district.district as districtName,tbl_office.id as tblOfficeId from tbl_office left join tbl_employee on tbl_employee.hris_code = tbl_office.office_head left join tbl_district on tbl_district.id = tbl_office.district where office_id = '$office_id'";
			$queryins = mysqli_query($fconn2,$query);
			$queryRow = mysqli_fetch_array($queryins,MYSQLI_ASSOC);
				
			$queryCnt = "select count(hris_code) as count from tbl_employee left join tbl_office on tbl_office.id = tbl_employee.department_id where tbl_office.office_id = '$office_id'";
			$queryCntIns = mysqli_query($fconn2,$queryCnt);
			$queryCntRow = mysqli_fetch_array($queryCntIns,MYSQLI_ASSOC);
			
			$sectionCnt = "select count(section_id) as count from section left join school on school.schooltable_id = section.schooltable_id where school.school_id='$office_id'";
			$sectionCntIns = mysqli_query($fconn,$sectionCnt);
			$sectionCntRow = mysqli_fetch_array($sectionCntIns,MYSQLI_ASSOC);
			
			$sectionCount = $sectionCntRow['count'];
			$headName = $queryRow['firstname']." ".$queryRow['middlename']." ".$queryRow['lastname']." ".$queryRow['ext_name'];
			$schoolName = $queryRow['office_name'];
			$logo = $queryRow['logo'];
			$office_id = $queryRow['office_id'];
			$officetbl_id = $queryRow['tblOfficeId'];
			$personnelCnt = $queryCntRow['count'];
			$districtName = $queryRow['districtName'];

			
			$this->schoolPersonnelCount = $personnelCnt;
			$this->schoolHead = $headName;
			$this->schoolLogo = $logo;
			$this->schoolName = $schoolName;
			$this->districtName = $districtName;
			$this->schoolId = $office_id;
			$this->sectionCount = $sectionCount;
			$this->officetbl_id = $officetbl_id;
		}
		function districtName(){
			return($this->districtName);
		}
		function schoolName(){
			return($this->schoolName);
		}
		function schoolLogo(){
			return($this->schoolLogo);
		}
		function schPersonnelCount(){
			return($this->schoolPersonnelCount);
		}
		function schoolHead(){
			return($this->schoolHead);
		}
		function schoolId(){
			return($this->schoolId);
		}
		function sectionCount(){
			return($this->sectionCount);
		}
		function learnerCount(){
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			$office_id = $this->schoolId;
			$learnerTemp = "select count(temp_enrollment_id) as temp_count from temp_enrollment left join school on school.schooltable_id = temp_enrollment.schooltable_id where school.school_id ='$office_id'";
			$inslearnerTemp = mysqli_query($fconn,$learnerTemp);
			$rowlearnerTemp = mysqli_fetch_array($inslearnerTemp,MYSQLI_ASSOC);
			$tempLearnerCount = $rowlearnerTemp['temp_count'];
			$learnerCurrent = "select count(current_enrollment_id) as curr_count from current_enrollment left join section on section.section_id = current_enrollment.section_id left join school on section.schooltable_id = school.schooltable_id where school.school_id = '$office_id'";
			$inslearnerCurrent = mysqli_query($fconn,$learnerCurrent);
			$rowlearnerCurrent = mysqli_fetch_array($inslearnerCurrent,MYSQLI_ASSOC);
			$currentLearnerCount = $rowlearnerCurrent['curr_count'];
			$learnerCount = $currentLearnerCount+$tempLearnerCount;
			
			return($learnerCount);
		}
		function school_type(){
			require('../../config/fdatabase.php');
			$office_id = $this->schoolId;
			$type = "select school_type from school where school_id = '$office_id'";
			$insType = mysqli_query($fconn,$type);
			$rowType = mysqli_fetch_all($insType,MYSQLI_BOTH);
			if(!empty($rowType)){
				$schType = $rowType[0]['school_type'];
				return ($schType);
			}
		}
		function onLeave(){
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			$tblID = $this->officetbl_id;
			$hrisQue = "select * from tbl_employee where department_id = '$tblID'";
			$hrisIns = mysqli_query($fconn2,$hrisQue);
			$leave = array();
			while($hrisRow = mysqli_fetch_array($hrisIns,MYSQLI_ASSOC)){
				$hris = $hrisRow['hris_code'];
				$query = "select * from tbl_leave left join tbl_office on tbl_office.id = tbl_leave.department where tbl_leave.department = '$tblID' and tbl_leave.status = '7' and tbl_leave.record_stat = '1' and tbl_leave.hris = '$hris'";
				$queryIns = mysqli_query($fconn2,$query);
				while($queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC)){
					$dateFrom = $queryRow['date_from'];
					$dateTo = $queryRow['date_to'];
					
					$x = betweenDates(date('Y-m-d'),$dateFrom,$dateTo);
					if($x == '1'){
						//$leave = $leave + '1';
						array_push($leave,$queryRow['hris']);
						break;
					}
				}
			}
			return($leave);
		}
		function getOls($part){
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			
			$office_id = $this->schoolId;
			$userQuery = "select * from tbl_user where department = '$office_id'";
			$userIns = mysqli_query($fconn2,$userQuery);
			$userRow = mysqli_fetch_array($userIns,MYSQLI_ASSOC);

			$username = $userRow['username'];
			$password = $userRow['password'];
			$validation = $userRow['validation'];
			$active = $userRow['active'];
			
			switch($part){
				case "username":
					return($username);
					break;
				case "password":
					return($password);
					break;
				case "validation":
					return($validation);
					break;
				case "active":
					return($active);
					break;
			}
		}
	}
	class Person{
		private $fname = "";
		private $mname = "";
		private $lname = "";
		private $extname = "";
		private $position = "";
		private $itemNO = "";
		private $bday = "";
		private $sigloc = "";
		function setter($hris_code){
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			$emp_query = "select * from tbl_employee left join tbl_office on tbl_office.id = tbl_employee.department_id left join tbl_emp_photo_signature as sign on sign.hris = tbl_employee.hris_code where tbl_employee.hris_code = '$hris_code'";
			$ins_emp = mysqli_query($fconn2,$emp_query);
			$row_emp = mysqli_fetch_array($ins_emp,MYSQLI_ASSOC);
			
			//personnel details
			$this -> fname = $row_emp['firstname'];
			$this -> mname = $row_emp['middlename'];
			$this -> lname = $row_emp['lastname'];
			$this -> extname = $row_emp['ext_name'];
			$this -> position = $row_emp['position'];
			$this -> itemNO = $row_emp['ItemNo'];
			$this -> civilStatus = $row_emp['civil_status'];
			$this -> bday = $row_emp['birth_date'];
			$this -> gender = $row_emp['gender'];
			$this -> bloodType = $row_emp['blood_type'];
			$this -> Contact = $row_emp['contact_no'];
			$this -> username = $row_emp['username'];
			$this -> password = $row_emp['password'];
			$this -> validation = $row_emp['validation'];
			$this -> role = $row_emp['employee_classification'];
			//more details
			$this -> tin = $row_emp['tin'];
			$this -> sss = $row_emp['sss'];
			$this -> gsis = $row_emp['gsis'];
			$this -> philhealth = $row_emp['philhealth'];
			$this -> sigloc = $row_emp['signature_location'];
			//office details
			$this -> employeeNumber = $row_emp['employee_no'];
			$this -> assignment_plantilla = $row_emp['assignment_plantilla'];
			$this -> appointmentDate = $row_emp['appointment_date'];
			$this -> salaryGrade = $row_emp['salary_grade'];
			$this -> salaryStep = $row_emp['salary_step'];
			$this -> employmentStatus = $row_emp['employment_status'];
			$this -> department_id = $row_emp['department_id'];
			$this -> startdateContinuedService = $row_emp['startdatecontinuesservice'];
			$this -> active = $row_emp['active'];
		}
		function getName($part){
			$partName = $part;
			$firstname = $this -> fname;
			$middlename = $this -> mname;
			$lastname = $this -> lname;
			$extname = $this -> extname;
			$fullname = $firstname." ".$middlename." ".$lastname." ".$extname;
			$formatted = $firstname." ".$middlename[0].". ".$lastname." ".$extname;
			switch($partName){
				case "firstname":
					return($firstname);
					break;
				case "middlename":
					return($middlename);
					break;
				case "lastname":
					return($lastname);
					break;
				case "extname":
					return($extname);
					break;
				case "full":
					return($fullname);
					break;
				case "formatted":
					return($formatted);
					break;
			}
		}
		function getSignature(){
			return($this->sigloc);
		}
		function getPosition(){
			return($this->position);
		}
		function active(){
			return($this->active);
		}
		function assigntmentPlantilla(){
			return($this->assignment_plantilla);
		}
		function getUsername(){
			return($this->username);
		}
		function getPassword(){
			return($this->password);
		}
		function getValidation(){
			return($this->validation);
		}
		function getItemNo(){
			return($this->itemNO);
		}
		function getBirthday(){
			return($this->bday);
		}
		function getCivilstatus(){
			return($this->civilStatus);
		}
		function getContact(){
			return($this->Contact);
		}
		function getBloodtype(){
			return($this->bloodType);
		}
		function getGender(){
			return($this->gender);
		}
		function getTin(){
			return($this->tin);
		}
		function getSss(){
			return($this->sss);
		}
		function getGsis(){
			return($this->gsis);
		}
		function getPhilhealth(){
			return($this->philhealth);
		}
		function getSalarystep(){
			return($this->salaryStep);
		}
		function getSalarygrade(){
			return($this->salaryGrade);
		}
		function getEmploymentstatus(){
			return($this->employmentStatus);
		}
		function getAppointmentdate(){
			return($this->appointmentDate);
		}
		function getEmployeenumber(){
			return($this->employeeNumber);
		}
		function getDepartment(){
			$departmentid = $this->department_id;
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			$officeQue = "select * from tbl_office where id = '$departmentid'";
			$officeIns = mysqli_query($fconn2,$officeQue);
			$officeRow = mysqli_fetch_array($officeIns,MYSQLI_ASSOC);
			
			
			$officeName = $officeRow['office_name'];
			return($officeName);
		}
		function getDepartmentData($data){
			$departmentid = $this->department_id;
			require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			$officeQue = "select * from tbl_office where id = '$departmentid'";
			$officeIns = mysqli_query($fconn2,$officeQue);
			$officeRow = mysqli_fetch_array($officeIns,MYSQLI_ASSOC);
			
			
			$officeName = $officeRow['office_name'];
			$officeHead = $officeRow['office_head'];
			
			switch($data){
				case "id":
					return ($departmentid);
					break;
				case "head":
					return ($officeHead);
					break;
				default:
					return($officeName);
					break;
			}
		}
		function getRole(){
			$emp_class = $this -> role;
			if($emp_class == "0"){
				return("not set");
			}else{
				$query = "select * from tbl_emp_classification where id = '$emp_class'";
				require $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
				$queryIns = mysqli_query($fconn2,$query);
				$queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC);
				
				return($queryRow['classification']);
			}
			
		}
		function getStartdatecontinuedservice(){
			return($this->startdateContinuedService);
		}
	}
	class ols_signatory{
		private $name;
		private $position;
		private $date_from;
		private $date_to;
		private $role;
		private $remarks;
		private $hris;
		function __construct($id){
			include $_SERVER['DOCUMENT_ROOT'] . DB_PATH . 'fdatabase.php';
			$query = "select * from tbl_leave_signatory where id = '$id'";
			$queryIns = mysqli_query($fconn2,$query);
			$queryRow = mysqli_fetch_array($queryIns,MYSQLI_ASSOC);
			
			$this-> role = $queryRow['role'];
			$this-> name = $queryRow['name'];
			$this-> position = $queryRow['position'];
			$this-> date_from = $queryRow['date_from'];
			$this-> date_to = $queryRow['date_to'];
			$this-> remarks = $queryRow['remarks'];
			$this-> hris = $queryRow['hris'];
		}
		function getDetail($detail){
			switch($detail){
				case "name":
					return $this->name;
					break;
				case "position":
					return $this->position;
					break;
				case "date_from":
					return $this->date_from;
					break;
				case "date_to":
					return $this->date_to;
					break;
				case "role":
					return $this->role;
					break;
				case "remarks":
					return $this->remarks;
					break;
				case "hris":
					return $this->hris;
					break;
			}
		}
	}
?>