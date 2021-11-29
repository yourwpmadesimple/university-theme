<?php

get_header();
pageBanner(array(
  'title' => 'All Events',
  'subtitle' => 'See what is going on in our world.',
  'photo' => 'https://images.unsplash.com/photo-1468779036391-52341f60b55d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1068&q=80'
));
?>

<div class="container container--narrow page-section">
  <?php

  while (have_posts()) {
    the_post();
    get_template_part('template-parts/content', 'event');
  }
  echo paginate_links();
  ?>

  <hr class="section-break">

  <p>Looking for a recap of past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive</a>.</p>

</div>

<?php get_footer();

?>