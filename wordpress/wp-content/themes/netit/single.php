<?php get_header(); ?>

<?php

if(has_nav_menu( 'netit_top' )) {
    ?>
    <section class="menu">
        <?php
            // Primary navigation menu.
            wp_nav_menu( array(
                'menu_class'     => 'nav-menu',
                'theme_location' => 'netit_top',
                'container' => "nav",
                // solution 1 'before' => " | ",
                // solution 2
                'before' => "<span>|</span>",
            ) );
        ?>
    </section>
    <?php
}

?>

<?php
if ( have_posts() ) :
?>
<section class="posts">
    <?php
    // Start the loop.
    while ( have_posts() ) :
        the_post();
    ?>
    <article>
        <h1><?php the_title(); ?></h1>
        <?php the_time( "d/M/Y - H:i:s" ); ?>
        <?php the_post_thumbnail( ); ?>
        <?php the_content( ); ?>
        <?php the_category(); ?>
        <?php the_tags(); ?>
    </article>
    <?php
    // End the loop.
    endwhile;
    ?>
</section>
<?php
// If no content, include the "No posts found" template.
else :
    echo "<h1>No posts.</h1>";

endif;
?>

<?php get_footer(); ?>