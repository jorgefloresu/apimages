<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-signin-client_id" content="987744642536-gvtpepf2mv4us93dh0njve8kpge4jopc.apps.googleusercontent.com">
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/materialize.min.css"); ?>" media="screen, projection"/>
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/materialize-plus.css"); ?>" />
		<link rel="stylesheet" href="<?php echo base_url("materialize/css/perfect-scrollbar.css"); ?>" />
		<? if ($bodytype != 'Reportes'): ?>
			<link rel="stylesheet" href="<?php echo base_url("materialize/css/style-horizontal.css"); ?>" />
	<!--		<link rel="stylesheet" href="<?php echo base_url("materialize/css/materialize-fix.css"); ?>" /> -->
	<!--	<link rel="stylesheet" href="<?php echo base_url("materialize/css/freewall.css"); ?>" /> -->
	<!--	<link rel="stylesheet" href="<?php echo base_url("materialize/css/collage.css"); ?>" /> -->
			<link rel="stylesheet" href="<?php echo base_url("materialize/css/masonry.css"); ?>" />
			<link rel="stylesheet" href="<?php echo base_url("materialize/css/magnific-popup.css"); ?>" />  
			<link rel="stylesheet" type="text/css" href="<?php echo base_url("materialize/css/base_style.css"); ?>" />
		<? endif; ?>
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link href="http://cdn.datatables.net/1.10.6/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">


		<title>Get Images from API</title>

	</head>

<?php if ($bodytype == "Login Page"): ?>
	<body class="cyan">
<?php else: ?>
	<body>
<?php endif; ?>

  <!-- Start Page Loading -->
    <div id="loader-wrapper">
        <div id="loader"></div>        
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->

