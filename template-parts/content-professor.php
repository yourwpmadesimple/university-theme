<div class="post-item">
    <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <li class="professor-card__list-item">
        <a class="professor-card" href="<?php the_permalink(); ?>">
            <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape') ?>">
            <span class="professor-card__name"><?php the_title(); ?></span>
        </a>
    </li>
    <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">View Professor &raquo;</a></p>
</div>