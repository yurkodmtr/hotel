<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script>
        window.urlAjax = "<?php echo admin_url('admin-ajax.php'); ?>";
        window.baseUrl = '<?php bloginfo('template_url');?>';
    </script>

    <?php wp_head(); ?>


</head>

<body ng-app="myApp">


<?php include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views/pop__mailchimp.php'); ?>




<div class="wrap" ng-controller="welcomeController">
    <?php include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views/search_proccess.php'); ?>


    <?php if (have_posts()): while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
        <?php endwhile; ?>
    <?php endif; ?>

</div>

</body>
</html>