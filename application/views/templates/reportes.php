<header id="header" class="page-topbar">
  <!-- start header nav-->
  <?=$report_header?>
  <!-- end header nav-->
</header>


<div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

    <?=$report_sidebar?>

    <section id="content">

        <!--breadcrumbs start-->
        <!--<div id="breadcrumbs-wrapper" class=" grey lighten-3">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Basic Tables</h5>
                <ol class="breadcrumb">
                    <li><a href="index.html">Dashboard</a></li>
                    <li><a href="#">Tables</a></li>
                    <li class="active">Basic Tables</li>
                </ol>
              </div>
            </div>
          </div>
        </div> -->
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">


          <div id="table-datatables">
            <h4 class="header">Descargas</h4>
            <div class="row">
              <div class="col s12 m4 l3">
                <p>Lista de descargas realizadas por usuario</p>
              </div>
              <div class="col s12 m8 l9">

                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Transaccion</th>
                        <th>Fecha y hora</th>
                        <th>Imagen</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?foreach ($datares as $key => $value):?>
                    <tr>
                      <td><?=$value->username?></td>
                      <td><?=$value->activity_type?></td>
                      <td><?=$value->session_date?></td>
                      <td><?=$value->img_code?></td>
                    </tr>
                    <?endforeach;?>
                  </tbody>
                
                  </table>
              </div>
            </div>
          </div>

        </div>
      </div>
</section>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="<?php echo base_url("materialize/js/materialize.js"); ?>"></script>
<script src="<?php echo base_url("js/perfect-scrollbar.min.js"); ?>"></script>
<script src="<?php echo base_url("js/jquery.dataTables.min.js"); ?>"></script>
<script src="<?php echo base_url("js/data-tables-script.js"); ?>"></script>
<script src="<?php echo base_url("js/plugins.js"); ?>"></script>

