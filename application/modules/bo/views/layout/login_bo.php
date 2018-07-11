<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/css/bootstrap/bootstrap.min.css') ?>">
		<link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/font-awesome/css/font-awesome.css'); ?>">


		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/css/bo/theme.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/css/bo/premium.css') ?>">

		<script type="text/javascript">
			var baseURL = "<?php echo base_url(); ?>";
		</script>

		<?php echo $css_for_layout ?>

		<?php echo $js_for_layout ?>

        <title><?php echo $title_for_layout ?></title>
    </head>
	<body class=" theme-blue">


		<style type="text/css">
			#line-chart {
				height:300px;
				width:800px;
				margin: 0px auto;
				margin-top: 1em;
			}
			.navbar-default .navbar-brand, .navbar-default .navbar-brand:hover { 
				color: #fff;
			}
		</style>

		<script type="text/javascript" data-module="modules/bo/switchNav"></script>

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="../assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">


		<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
		<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
		<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
		<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
		<!--[if (gt IE 9)|!(IE)]><!--> 

		<!--<![endif]-->

		<div class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<a class="" href="index.html"><span class="navbar-brand"><span class="fa fa-paper-plane"></span> Admin Core</span></a></div>

			<div class="navbar-collapse collapse" style="height: 1px;">

			</div>
		</div>

		<?php echo $content_for_layout ?>
		<?php echo Modules::run('flashmessages/flashMessages/slidedownstyle'); ?>
		<script src="<?php echo base_url('assets/local/js/app.js'); ?>"></script>


	</body></html>