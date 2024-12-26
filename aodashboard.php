<div class="content-wrapper">
  <div style="margin-left:1em">
    <h2 style="color:gray">DASHBOARD</h2>
  </div>

<div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header" >
                <h3 class="card-title" id="graph_school_name" style="color:red">
                  <i class="fas fa-chart-pie mr-1"></i>
                 No School Selected
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="land-chart">
                      <canvas id="aoassetchart" height="100" style="height:100"></canvas>
                  </div>

                </div>
              </div><!-- /.card-body -->
            </div>
		   </section>

        </div>
        </div>

<script src="graph.js"></script>