<?php get_header(); ?>

<?php 
if ( have_posts() ) {
?>
<section class="posts">
    <?php
    // Start the loop.
    while ( have_posts() ) :
        the_post();
    ?>
    <article>
        <?php the_title(); ?>
        <?php the_post_thumbnail( ); ?>
        <?php the_time( "d/M/Y - H:i:s" ); ?>
        <?php the_author( ); ?>
    </article>
    <?php
    // End the loop.
    endwhile;
    ?>

<?php } ?>
</section>

<?php get_footer(); ?>