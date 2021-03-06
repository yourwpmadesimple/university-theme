<?php

get_header();
pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false))  . '&rdquo;',
    'photo' => 'https://images.unsplash.com/photo-1468779036391-52341f60b55d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1068&q=80'
));
?>

<div class="container container--narrow page-section">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', get_post_type())
    ?>

    <?php }
        echo paginate_links();
    } else {
        echo "<h2 class='headline headline--small'>No results match that search</h2>";
    }
    get_search_form();
    ?>
</div>

<?php get_footer();

?>