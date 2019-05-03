<html lang="en">
<head>

<?php 
require 'libraries/constants.php';
require_once HEAD_START;
?>

    <!--Optional sources start -->

    <!-- Optional sources end -->

</head>

<body>

<?php
session_start();
$_SESSION['current_page']='home';

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
        <div class="pull-left">Bienvenue</div>
        <div class="widget-icons pull-right">
          <a href="mac_bootstrap/macadmin/theme/#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
          <a href="mac_bootstrap/macadmin/theme/#" class="wclose"><i class="fa fa-times"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="widget-content">
        <div class="padd">
          <!-- Content goes here -->

          <?php

          echo "Bonjour <b>$user</b>, bienvenue sur l'espace de gestion génétique GenIS du Conservatoire des Races d'Aquitaine !";

          ?>

        </div>
        <div class="widget-foot">
          <!-- Footer goes here -->
        </div>
      </div>
    </div>

  </div>
</div>

<?php require BODY_END;?>

<!--Optional scripts start -->

<!-- Optional scripts end -->

</body>
</html>