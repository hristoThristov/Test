<?php get_header(); ?>

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
        <h1><?php the_time( "d/M/Y - H:i:s" ); ?></h1>
        <?php the_title(); ?>
        <p>This is the first worpdress post!!!!!!</p>
        <?php the_content( ); ?>
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