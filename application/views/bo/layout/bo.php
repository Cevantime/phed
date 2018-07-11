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
    <body class="theme-blue">


        <!-- Demo page code -->

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
        <script type="text/javascript" data-module="modules/bo/fileselect"></script>

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
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div class="navbar-collapse collapse" style="height: 1px;">
                <a  class="navbar-brand" href="<?php echo base_url(''); ?>"><span><span class="fa fa-rss"></span> PHED</span></a>
                <ul id="main-menu" class="nav navbar-nav navbar-right">
                    <li class="dropdown hidden-xs">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user padding-right-small" style="position:relative;top: 3px;"></span> 
                            <?php if (!$user->name || !$user->forname): ?>
                                <?php echo $user->login; ?>
                            <?php else: ?>
                                <?php echo $user->name; ?> <?php echo $user->forname; ?>
                            <?php endif; ?>
                            <i class="fa fa-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="./">Mon compte</a></li>
                            <li class="divider"></li>

                            <li><a tabindex="-1" href="<?php echo base_url('bo/logout') ?>">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>


        <div class="sidebar-nav">
            <ul>
                <?php
                $this->load->helper('directory');
                $modulesPath = './application/modules';
                $modules = array_map(function($r) {
                    return str_replace(DIRECTORY_SEPARATOR, '/', $r);
                }, array_reverse(directory_map($modulesPath, 1)));
                foreach ($modules as $module) {
                    if (file_exists($modulesPath . '/' . $module . 'views/_bo_menus.php')) {
                        $this->load->view($module . '_bo_menus');
                    }
                }
                ?>

            </ul>
        </div>

        <div class="content">
            <div class="header">
                <!--				<div class="stats">
                                    <p class="stat"><span class="label label-info">5</span> Tickets</p>
                                    <p class="stat"><span class="label label-success">27</span> Tasks</p>
                                    <p class="stat"><span class="label label-danger">15</span> Overdue</p>
                                </div>-->

                <h1 class="page-title">Dashboard</h1>
                <ul class="breadcrumb">
<?php foreach ($breadcrumb as $segment => $uri) : ?>
                        <li><a href="<?php echo $uri ?>"><?php echo $segment ?></a> </li>
                <?php endforeach; ?>
                </ul>

            </div>
            <div class="main-content">
                    <?php if (isset($errors)): ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Error!</h4>
                    <?php foreach ($errors as $error): ?>
                        <?php echo $error; ?>
    <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($warnings)): ?>
                    <div class="alert alert-block">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h4>Warning!</h4>
                    <?php foreach ($warnings as $warning): ?>
                        <?php echo $warning; ?>
    <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4>Success!</h4>
                    <?php foreach ($success as $succes): ?>
                        <?php echo $succes; ?>
    <?php endforeach; ?>
                    </div>
<?php endif; ?>
<?php echo $content_for_layout ?>

                <div id="modal-from-dom" class="modal small fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <a href="#" class="close" data-dismiss="modal">&times;</a>
                                <h3></h3>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-confirm">OK</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" data-module="modules/bo/parseModal"></script>
                <footer>
                    <hr>

                    <!-- Purchase a site license to remove this link from the footer: http://www.portnine.com/bootstrap-themes -->
                    <p>© 2015 <a href="#" target="_blank">Core</a></p>
                </footer>
            </div>
        </div>

<?php echo Modules::run('flashmessages/flashMessages/slidedownstyle'); ?>

        <script src="<?php echo base_url('assets/local/js/app.js'); ?>"></script>

    </body></html>
