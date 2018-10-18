<?php
/*
Template Name: About us page
*/

print_numbers_skip_ten(100);

?>
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
    <h1>
        <ul>
            <li>Нема ти кажа!</li>
            <li>Не знам!</li>
            <li>Нещо друго!</li>
        </ul>
    </h1>
    <?php
    // End the loop.
    endwhile;
    ?>

<?php } ?>
</section>

<?php get_footer(); ?>