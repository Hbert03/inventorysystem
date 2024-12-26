<div class="content-wrapper">
  <div style="margin-left:1em">
    <h2 style="color:gray">DASHBOARD</h2>
  </div>
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
		<div class="col-lg-2 col-3">
            <!-- small box -->
			<div class="small-box bg-info">
              <div class="inner">
                <h3><?php
                if (isset($_SESSION['user_id_sch'])) {
                  include_once('../../../config/config_path.php');
              
              $school_id = intval($_SESSION['user_id_sch']);

						$building_structureCounter = "SELECT count(*) as count FROM depedldn_ams.asset WHERE user_id= '$school_id' AND asset_subid= '6'";
						$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
						$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);

						echo number_format($ROWbuilding_structureCounter['count']);
                }?></h3>

                <p>Land<br></p><br>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="land.php" ></a>
            </div>
          </div>
          <div class="col-lg-2 col-3">
            <!-- small box -->
			<div class="small-box bg-info">
              <div class="inner">
                <h3><?php
                   if (isset($_SESSION['user_id_sch'])) {
                    include_once('../../../config/config_path.php');
                
                $school_id = intval($_SESSION['user_id_sch']);
						$building_structureCounter = "select count(*) as count FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id= '1' and a.user_id='$school_id'";
						$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
						$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);

						echo number_format($ROWbuilding_structureCounter['count']);}
				?></h3>

                <p>Buildings and<br>Structures</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" ></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php
                  if (isset($_SESSION['user_id_sch'])) {
                    include_once('../../../config/config_path.php');
                
                $school_id = intval($_SESSION['user_id_sch']);
						$building_structureCounter = "select count(*) as count FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id= '2' and a.user_id='$school_id'";
						$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
						$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);

						echo number_format($ROWbuilding_structureCounter['count']); }
				?></h3>

                <p>Machinery and<br>Equipment</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" ></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php
                  if (isset($_SESSION['user_id_sch'])) {
                    include_once('../../../config/config_path.php');
                
                $school_id = intval($_SESSION['user_id_sch']);
						$building_structureCounter = "select count(*) as count FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id= '3' and a.user_id='$school_id'";
						$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
						$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);

						echo number_format($ROWbuilding_structureCounter['count']);}
				?></h3>

                <p>Transportation and<br>Equipment</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" ></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php
                  if (isset($_SESSION['user_id_sch'])) {
                    include_once('../../../config/config_path.php');
                
                $school_id = intval($_SESSION['user_id_sch']);
						$building_structureCounter = "select count(*) as count FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id= '4' and a.user_id='$school_id'";
						$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
						$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);

						echo number_format($ROWbuilding_structureCounter['count']);}
				?></h3>

                <p>Furniture Fixtures<br>and Books</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#"></a>
            </div>
          </div>
		  <div class="col-lg-2 col-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php
                  if (isset($_SESSION['user_id_sch'])) {
                    include_once('../../../config/config_path.php');
                
                $school_id = intval($_SESSION['user_id_sch']);
						$building_structureCounter = "select count(*) as count FROM depedldn_ams.asset a INNER JOIN depedldn.tbl_employee e ON e.hris_code = a.account_officer WHERE a.asset_id= '5' and a.user_id='$school_id'";
						$insbuilding_structureCounter = mysqli_query($fconn,$building_structureCounter);
						$ROWbuilding_structureCounter = mysqli_fetch_array($insbuilding_structureCounter,MYSQLI_ASSOC);

						echo number_format($ROWbuilding_structureCounter['count']);}
				?></h3>

                <p>Other Property Plant<br>and Equipment</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="" ></i></a>
            </div>
          </div>
</SECTION>
<div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Inventory School Data
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="land-chart">
                      <canvas id="schoolchart" height="100" style="height:100"></canvas>
                  </div>

                </div>
              </div><!-- /.card-body -->
            </div>
		   </section>

        </div>
        </div>

<script src="graph.js"></script>