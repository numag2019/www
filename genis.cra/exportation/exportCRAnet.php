<!DOCTYPE html>
<html lang="en">
<head>

  <title>GenIS</title>

  <?php 
  require_once '../libraries/constants.php';
  require_once HEAD_START;
  ?>

  <!--Optional sources start -->
    <script type="text/javascript" src="js/script_import.js"></script>
  <!-- Optional sources end -->

</head>

<body>

<?php
session_start();
$_SESSION['current_page']='exportCRAnet';

require BODY_START;

/*
 * Starting connection to database
 */

$con = pdo_connection(HOST_DB,DB_NAME,USER_DB,PW_DB);

?>

<div class="row">
  <div class="col-md-12">

    <div class="widget">
      <div class="widget-head">
        <div class="pull-left">Exportation des données vers le site WEB CRAnet</div>
        <div class="widget-icons pull-right">
          <a href="../mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
          <a href="../mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
	  
      <div class="widget-content">
        <div class="padd">
            <!-- Content goes here -->

		
			 <form class="form-horizontal" id="import_eleveurs" method="POST" role="form" action="creationcsv.php">
                <fieldset>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"></label>
                        <div class="col-lg-5">
                            <button class="btn btn-sm btn-success" type="submit" id="buttonImportEleveurs">Exporter les données</button>
                        </div>
                    </div>
                </fieldset>
            </form>

        </div>
        <div class="widget-foot">
          <!-- Footer goes here -->
        </div>
      </div>
    </div>

  </div>
</div>

<?php require BODY_END;?>


<!-- Optional scripts end -->

</body>
</html>
