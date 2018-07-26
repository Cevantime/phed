<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript">
            var baseURL = "<?php echo base_url(); ?>";
        </script>

        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/css/font-awesome/css/font-awesome.min.css'); ?>"></link>
        <link rel="stylesheet" href="<?php echo base_url('assets/local/css/modules/filebrowser.css'); ?>"></link>
        <?php echo $css_for_layout ?>
        <?php echo $js_for_layout ?>

        <title><?php echo $title_for_layout ?></title>
    </head>
    <body>

        <div id="main" data-module="modules/filebrowser/globals">
            <?php echo $content_for_layout ?>
        </div>
        <script src="<?php echo base_url('assets/local/js/app.js'); ?>"></script>
    </body>
</html>