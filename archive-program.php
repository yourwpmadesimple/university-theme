<?php

get_header();
pageBanner(array(
  'title' => 'All Programs',
  'subtitle' => 'There is something for everyone. Have a look around.',
  'photo' => 'https://images.unsplash.com/photo-1468779036391-52341f60b55d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1068&q=80'
));
?>

<div class="container container--narrow page-section">

  <ul class="link-list min-list">

    <?php
    while (have_posts()) {
      the_post(); ?>
      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php }
    echo paginate_links();
    ?>
  </ul>



</div>

<?php get_footer();

?>