


<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

	<ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="invent_home.php" class="nav-link">Home</a>
      </li>
      <?php
		// if($_SESSION['asset_subidDetails'] != '0'){
		// echo "<li class='nav-item d-none d-sm-inline-block'>";
		// 	if($_SESSION['asset_idDetails'] == '6'){
		// 		echo "<a href='add_ams_land.php' class='nav-link no-outline'>Add</a></li>";
		// 	}else if($_SESSION['asset_idDetails'] == '1'){
		// 		echo "<a href='add_ams_build.php' class='nav-link no-outline'>Add</a></li>";
		// 	}else {
		// 		echo "<a href='add_ams.php' class='nav-link no-outline'>Add</a></li>";
		// 	}
		// }
	  ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="data_rpcsp.php" class="nav-link">RPCSP</a>
      </li>
	 <li class="nav-item d-none d-sm-inline-block">
        <a href="data_rpcppe.php" class="nav-link">RPCPPE</a>
      </li>
    </ul>

	 <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->
       <li class="nav-item" style="margin-right:.5em">
           <button type="button" class="btn btn-primary btn-sm float-right" style="border-radius:10px;  background-color:transparent; color:blue"  data-toggle="modal" data-target="#exampleModal1">
                    ADD INVENTORY <i class="fa fa-plus"></i>
                  </button>
       </li>
       <li class="nav-item" style="margin-right:1em">
       <button type="button" class="btn btn-primary btn-sm float-right" style="border-radius:10px; margin-right:5em; background-color:transparent; color:blue" data-toggle="modal" data-target="#exampleModal">
                    ADD LAND INVENTORY <i class="fa fa-plus"></i>
                  </button>
       </li>
       <!-- <li style="margin-right:3em">
      <button id="notificationButton" style="background-color:transparent; border:none; color:blue" class="btn btn-primary btn-sm">
        <span><i class="fa fa-bell"></i></span>New
      </button>
    </li> -->

    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-logout" role="button"  onclick="confirmLogout()">
        <i class="fas fa-sign-out-alt"></i>
          </a>
          <form id="logoutForm" action="../logout.php" method="post" style="display: none;">
           <input type="hidden" name="confirm_logout" value="1">
          </form>
      </li>
  
    </ul>
  </nav>


  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Update Data</h5>
      </div>
      <div class="modal-body">
      <div class="row">
          <div class="col-12 col-md-6">
            <label for="asset_id" class="form-label">Asset Type</label>
            <select class="form-control select2" id="assetsch" ></select>
          </div>
          <div class="col-12 col-md-6">
            <label for="sub_id" class="form-label">Sub Asset</label>
            <select class="form-control select2" id="subassetsch"></select>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
          <label for="modal-input1" class="form-label">Description</label>
          <input type="text" class="form-control" id="modal-input1">
          </div>
          <div class="col-12 col-md-6">
          <label for="modal-input2" class="form-label">Property No.</label>
          <input type="text" class="form-control" id="modal-input2">
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
          <label for="modal-input3" class="form-label">Unit of Measure</label>
          <input type="text" class="form-control" id="modal-input3">
         </div>
          <div class="col-12 col-md-6">
          <label for="modal-input4" class="form-label">Unit Value</label>
          <input type="text" class="form-control" id="modal-input4">
          </div>
          </div>

        <div class="row">
          <div class="col-12 col-md-6">
          <label for="modal-input5" class="form-label">Quantity on Property Card</label>
          <input type="text" class="form-control" id="modal-input5">
          </div>
          <div class="col-12 col-md-6">
          <label for="modal-input6" class="form-label">Quantity Physical Count</label>
          <input type="text" class="form-control" id="modal-input6">
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
          <label for="modal-input7" class="form-label">Shortage Quantity</label>
          <input type="text" class="form-control" id="modal-input7">
          </div>
          <div class="col-12 col-md-6">
          <label for="modal-input8" class="form-label">Shortage Value</label>
          <input type="text" class="form-control" id="modal-input8">
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6">
          <label for="" class="form-label">Accountable Officer</label>
          <select  class="form-control edit_personnel_school"></select>
          </div>
          <div class="col-12 col-md-6">
          <label for="modal-input10" class="form-label">Remarks</label>
          <input type="text" class="form-control" id="modal-input10">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveChanges">Update</button>
      </div>
    </div>
  </div>
</div>

  
  <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>ADD INVENTORY</b></h5>
      </div>
      <div class="modal-body">
        <form id="save_asset" action="" method="POST"  enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-6">
            <input type="hidden" id="selectedOfficeId" name="selectedOfficeId">
              <select class="form-control asset_type_school" name="select1" required></select>
              <input type="text" class="form-control mb-1 mt-2" name="type" id="type" placeholder="Type" required>
						<input type="text" class="form-control mb-1" name="brand" id="brand" placeholder="Brand">
						<input type="text" class="form-control mb-1" name="model" id="model" placeholder="Model">
						<input type="text" class="form-control mb-1" name="article" id="article" placeholder="Article" required>
						<input type="text" class="form-control mb-1" name="sn" id="sn" placeholder="Serial No.">
						<input type="text" class="form-control mb-1" name="property_no" id="property_no" placeholder="Property No." required>
            <input type="text" class="form-control mb-1" name="stock" id="stock" placeholder="Stock No." required>
						<input type="text" class="form-control mb-1" name="unit_value" id="unit_value" placeholder="Unit Value" required>
            <select class="form-control mb-1 " name="remarks" id="remarks" required>
            <option disabled selected>Remarks</option>
							<option id="h1" value="New/Good Condition/Funds">New/Good Condition/Funds</option>
							<option id="h2" value="Need Repair">Need Repair</option>
							<option id="h3" value="Defective - Repairable">Defective - Repairable</option>
							<option id="h4" value="Defective - Disposal">Defective - Disposal</option>
              <option id="b1" value="In good Condition">In good Condition</option>
							<option id="b2" value="Need Minor Repair">Need Minor Repair</option>
							<option id="b3" value="Need Major Repair">Need Major Repair</option>
							<option id="b4" value="For Demolition">For Demolition</option>
            </select>
            <select class="form-control mb-1 " name="fund_source" id="fund_source" required>
            <option disabled selected>Fund Source</option>
							<option value="CO">CO</option>
							<option value="RO">RO</option>
							<option value="DO">DO</option>
							<option value="SEF">SEF</option>
							<option value="DONATION">DONATION</option>
							<option value="SCHOOL">SCHOOL</option>
							<option value="MOOE">MOOE</option>
            </select>
            </div>
            <div class="col-md-6">
              <select class="form-control sub_asset_type_school mb-1" name="select2" required></select>
              <input type="text" class="form-control mt-2 mb-1" name="qty_card" id="qty_card" placeholder="Qty Card" required>
						<input type="text" class="form-control mb-1" name="qty_count" id="qty_count" placeholder="Qty Count" required>
						<input type="text" class="form-control mb-1" name="useful_life" id="useful_life" placeholder="Usefull Life" required>
						<input type="text" class="form-control mb-1" name="qty_short" id="qty_short" placeholder="qty_short " required>
						<input type="text" class="form-control mb-1" name="value_short" id="value_short" placeholder="value_short" required>
            <input type="text" class="form-control mb-1" name="measurement" id="measurement" placeholder="Unit of Measurement" required>
            
            <label>Acquisition Date</label>
						<input type="date" class="form-control mb-1" name="date_acq" id="date_acq" placeholder=""  required>  
            <select  class="form-control mb-1 select_account_school" name="account_off" id="account_off"  required></select>
            </div>
          </div>
          <button type="button" class="btn btn-primary btn-sm btn-block mt-2 save_asset_school">SAVE</button>
          <button type="button" class="btn btn-secondary btn-sm btn-block" data-dismiss="modal">CANCEL</button>
        </form> 
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>



    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>ADD INVENTORY LAND</b></h5>
      </div>
      <div class="modal-body">
        <form id="addland" action="" method="POST"  enctype="multipart/form-data">
              <label for="examDropdown">Asset Type</label>
              <select class="form-control land" name="select1" required></select>
              <input type="text" class="form-control mb-1 mt-1" name="description" id="description" placeholder="Description" required>
						<input type="text" class="form-control mb-1" name="property_no" id="property_no" placeholder="Property No." required>
						<input type="text" class="form-control mb-1" name="land_area" id="land_area" placeholder="Land Area" required>
						<input type="text" class="form-control mb-1" name="acquisition_cost" id="acquisition_cost" placeholder="Acquisition Cost" required>
            <label>Date Encoded</label>
            <input type="date" class="form-control mb-1" name="date" placeholder="Date Encoded">
            <label>Titled</label>
						<select class="form-control mb-1 " name="titled" id="titled" required>
							<option disabled selected>Select Titled</option>
							<option value="yes">Yes</option>
							<option value="no">No</option></select>
              <label>Date Titled</label>
						<input type="date" class="form-control mb-1" name="date_titled" id="date_titled" placeholder="Date Titled">
            <label>Date Acquired</label>
						<input type="date" class="form-control mb-1" name="date_acq" id="date_acq" placeholder="Date Acquired" required>
            <label>Remarks</label>
            <select class="form-control mb-1 " name="remarks" id="remarks" required>
            <option disabled selected>Remarks</option>
							<option value="New/Good Condition/Funds">New/Good Condition/Funds</option>
							<option value="Need Repair">Need Repair</option>
							<option value="Defective - Repairable">Defective - Repairable</option>
							<option value="Defective - Disposal">Defective - Disposal</option>

            </select>
						<button type="button" class="btn btn-primary btn-sm btn-block mt-2 saveland" >SAVE</button>
						<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal" >CANCEL</button>
        </form> 
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="fundSourceModal" tabindex="-1" aria-labelledby="fundSourceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fundSourceModalLabel"><b>New Entry from Region and Central</b></h5>
        <button type="button" class="btn btn-primary btn-close" data-dismiss="modal" >Back</button>
      </div>
      <div class="modal-body">

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="fundSourceTable" style="width: 100%;">
            <thead>
              <tr>
                <th>Description</th>
                <th>Property Number</th>
                <th>Unit Measure</th>
                <th>Unit Value</th>
                <th>Quantity Property Card</th>
                <th>Quantity Physical Count</th>
                <th>Shortage Quantity</th>
                <th>Shortage Value</th>
                <th>Date Acquired</th>
                <th>Remarks</th>
                <th>Accountable Officer</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

