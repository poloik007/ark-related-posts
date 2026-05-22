<div class="wp-block-group">
    <hr />
    <h3>Related Posts</h3>
    <section class="ark-related-posts">

        <?php if (!empty($posts)): ?>

            <?php foreach ($posts as $post): ?>
                <div class="ark-related-posts__item">
                    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
                        <?php echo get_the_post_thumbnail($post->ID, 'small'); ?>
                        <span><?php echo esc_html($post->post_title); ?></span>
                    </a>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </section>
</div>