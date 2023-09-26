<?php get_header(); ?>
    <main class="main-content col-xs-12 error-page">

        <div class="container">
        	<div class="container-error">
            	<span class="four">4</span>
            	<span class="weight-404"><img src="<?php echo SH_URL . "assets/svg/weight.svg" ?>"></span>
            	<span class="four">4</span>
        	</div>
                <p class="text-center">Page Not Found</p>
                <a href="<?php echo home_url("/"); ?>" class="btn btn-theme m-center">
                Back to Home</a>
        </div>
    </main>
<?php get_footer(); ?>