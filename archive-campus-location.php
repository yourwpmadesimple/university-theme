<?php

get_header();
pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'There is something for everyone. Have a look around.',
    'photo' => 'https://images.unsplash.com/photo-1468779036391-52341f60b55d?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1068&q=80'
));
?>

<div class="container container--narrow page-section">

    <div class="acf-map">

        <?php
        while (have_posts()) {
            the_post();
            $mapLocation = get_field('map_location');
        ?>
            <div class='marker' data-lat='<?php echo $mapLocation['lat'] ?>' data-lng='<?php echo $mapLocation['lng'] ?>'>
                <?php echo $mapLocation['lng']; ?>
                <h3><a href='<?php the_permalink() ?>'><?php the_title(); ?></a></h3>
                <?php echo $mapLocation['address'] ?>
            </div>
        <?php } ?>
    </div>
</div>

<?php get_footer(); ?>