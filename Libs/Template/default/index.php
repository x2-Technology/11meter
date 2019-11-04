<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no">
        <?= $this->page_meta_property; ?>

    <title><?= $this->page_title; ?></title>

    <script type="text/javascript">let APPLICATION = true; </script>
    <script type="text/javascript">let APP_NAME = "DAF-ANDROID"; </script>
    <script type="text/javascript">let base_url = "<?= Config::BASE_URL; ?>"; </script>
    <!--<script type="text/javascript">var DEVICE   = "<? /*= $_SESSION[REPOSITORY::CURRENT_DEVICE]; */ ?>"; </script>-->
    <script type="text/javascript">let DEVICE = "<?= REPOSITORY::read(REPOSITORY::CURRENT_DEVICE); ?>"; </script>

    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/src/js/jquery.js"></script>
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/src/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/src/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/src/js/circle-progress.js"></script>

    <!-- X2Factor Activity Controller JS Module -->
    <!--<script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/Frameworks/X2Factor/X2FactorViewController.mobile.js"></script>-->

    <!--X2 Mobile JS-->
    <!--<script type="text/javascript" src="<?/*= Config::BASE_URL; */?>/Libs/Frameworks/X2Factor/X2Tools.mobile.js"></script>-->
    <!--X2 Mobile CSS-->
    <!--<link rel="stylesheet" href="<?/*= Config::BASE_URL; */?>/Libs/Frameworks/X2Factor/X2FactorLayout.mobile.css">-->

    <!--X2 Mobile JS-->
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/Frameworks/X2Factor/X2Tools.mobile.org.js"></script>
    <!--X2 Mobile CSS-->
    <!--<link rel="stylesheet" href="<?/*= Config::BASE_URL; */?>/Libs/Frameworks/X2Factor/X2FactorLayout.mobile.org.css">-->
    <!--<link rel="stylesheet" href="<?/*= Config::BASE_URL; */?>/Libs/Frameworks/X2Factor/X2FactorLayout.mobile.removeable.row.org.css">-->
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/Frameworks/X2Factor/X2FactorLayout.mobile.not.removeable.css">





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <!--<script type="text/javascript" src="<? /*= Config::BASE_URL; */ ?>/Libs/Frameworks/Bootstrap4.0/js/jquery-3.2.1.slim.min.js"></script> This script distrubin the jquery-ui -->

    <!-- Bootstrap CSS -->
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/Frameworks/Bootstrap4.0/js/popper.min.js"></script>
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/Frameworks/Bootstrap4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/Frameworks/Bootstrap4.0/css/bootstrap.min.css" type="text/css">

    <!-- Bootstrap Switch Box CSS -->
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/Frameworks/Bootstrap4.0/css/bootstrap-checkbox.css"
          type="text/css">

    <script type="text/javascript"
            src="<?= Config::BASE_URL; ?>/Libs/Frameworks/Bootstrap4.0/js/velocity.min.js"></script>
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/Frameworks/Bootstrap4.0/js/velocity.ui.min.js"></script>


    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/src/css/jquery-ui.css" type="text/css">
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/src/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/src/css/animate.css" type="text/css">
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/src/font/icomoon/icomoon.css" type="text/css">
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/src/font/font.css" type="text/css">


    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/Template/<?= Config::TEMPLATE; ?>/footer.css">
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/Template/<?= Config::TEMPLATE; ?>/header.css">




    <!--<script type="text/javascript" src="<? /*= Config::URL_API; */ ?>/js/tsoftx-ui.js"></script>
    <link rel="stylesheet" href="<? /*= Config::URL_API; */ ?>/css/tsoftx-ui.css">-->

    <!--CONSTANTS JS -->
    <!--<script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/Template/<?= Config::TEMPLATE; ?>/Constants.js"></script>-->


    <!--INPUT MASK-->
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/src/js/inputmask.js"></script>

    <!--TEMPLATE JS -->
    <script type="text/javascript"
            src="<?= Config::BASE_URL; ?>/Libs/Template/<?= Config::TEMPLATE; ?>/script.js"></script>
    <!--TEMPLATE CSS -->
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/Template/<?= Config::TEMPLATE; ?>/style.css">

    <!--X2 CSS-->
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Libs/src/css/x2.ui.css">
    <!--X2 JS-->
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Libs/src/js/x2.ui.js"></script>

    <!--TEMPLATE CSS -->
    <link rel="stylesheet" href="<?= Config::BASE_URL; ?>/Views/<?= $this->class; ?>/style.css" type="text/css">
    <!--TEMPLATE JS -->
    <script type="text/javascript" src="<?= Config::BASE_URL; ?>/Views/<?= $this->class;?>/script.js"></script>







</head>
<body class="background-primary" data-spy="scroll" data-target=".bs-docs-sidebar" >

<div class="view-wrapper">
        <?= $this->content; ?>
</div>

<?php if ($this->class === "Login") { ?>
        <?php echo $this->footer; ?>
<?php } ?>

</body>


</html>



