<?php get_header(); ?>

<?php

// ...
//get_template_part( 'partials/sidebar', 'advertisment' );

?>

<?php 
if ( have_posts() ) :
?>
<section class="posts">
    <?php
    // Start the loop.
    while ( have_posts() ) : the_post();

        get_template_part( 'partials/sidebar', 'advertisment' );

    ?>
    <article>
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <?php the_time( "d/M/Y - H:i:s" ); ?>
    <?php the_category(); ?>
    <?php the_tags(); ?>
    <?php the_excerpt(); ?>
    <?php the_post_thumbnail( "thumbnail" ); ?>
    </article>
    <?php
    // End the loop.
    endwhile;

    // Previous/next page navigation.

    the_posts_pagination( [
        'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
        'next_text'          => __( 'Next page', 'twentyfifteen' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
     ] );
    ?>
</section>
<?php
// If no content, include the "No posts found" template.
else :
    echo "<h1>No posts.</h1>";

endif;
?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>