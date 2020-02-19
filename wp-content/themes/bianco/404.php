<?php get_header(); ?>
    <div class="main-container page-404">
        <div class="container">
            <div class="text-center content-404">
                <h1 class="heading"><?php esc_html_e('404','bianco'); ?></h1>
                <h2 class="title"><?php esc_html_e('Opps! have no idea what just happened.','bianco'); ?></h2>
                <p class="subtitle"><?php esc_html_e('The page you’re looking for can’t be found. You might find these links userful','bianco'); ?></p>
                <a class="button" href="<?php echo esc_url( get_home_url('/') ); ?>"><?php esc_html_e('Back to Homepage','bianco'); ?></a>
            </div>
        </div>
    </div>
<?php get_footer();