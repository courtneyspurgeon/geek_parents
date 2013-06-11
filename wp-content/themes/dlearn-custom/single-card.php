    <?php $strFav = (get_post_favorite($post) ? 'favorite' : '');
            $post = get_post(get_the_ID());
              $activity_id = bp_activity_get_activity_id( array(
                'user_id' => $post->post_author,
                'type' => 'new_blog_post',
                'component' => 'blogs',
                'item_id' => 1,
                'secondary_item_id' => $post->ID
            ) );?>

    <div id="post-<?php the_ID(); ?>-wrapper" class="article-wrapper">

        <article id="post-<?php the_ID(); ?>" <?php post_class($strFav.' post-content clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

            <header class="article-header">
              <a href="<?php echo trim(get_post_meta(get_the_ID(), '_cmb_source_url', true)); ?>" 
                title="External Link: <?php echo trim(get_post_meta(get_the_ID(), '_cmb_source_url', true)); ?>">
                <h2 class="posttitle"><?php the_title(); ?></h2></a>

                <p class="date">
                    <?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ' ' ) ); ?>
                    <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
                </p>
            </header> <!-- end article header -->

            <div class="entry-thumbnail clearfix" itemprop="articleBody">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail(array(300,250));
                } else { ?>
                    <img class="featured" src="http://dummyimage.com/300x250/000/fff.png" alt="Dummy Image" />
                <?php } ?>
            </div>

            <section class="entry-content clearfix" itemprop="articleBody">
                <?php the_excerpt(); ?>
            </section>

            <footer class="article-footer">
                <p class="hidden postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?>&nbsp;</p>
            </footer> <!-- end article footer -->

        </article>

        <div id="post-<?php the_ID(); ?>-dynamic-content"></div>

        <div class="post-favorite-wrapper hidden">
            <?php if ( is_user_logged_in() ) : ?>
            <div class="post-favorite">
              <?php bp_has_activities(); ?>
              <div class="spinner" style="display:none;">Loading</div>
              <a data-id="post-<?php the_ID(); ?>" href="<?php my_bp_activity_favorite_link($activity_id) ?>" class="<?php echo (my_bp_activity_is_favorite($activity_id) ? 'hidden' : '') ?> button fav bp-secondary-action" title="<?php _e( 'Mark as Favorite', 'buddypress' ) ?>"><?php _e( 'Favorite', 'buddypress' ) ?></a>
              <a data-id="post-<?php the_ID(); ?>" href="<?php my_bp_activity_unfavorite_link($activity_id) ?>" class="<?php echo (!my_bp_activity_is_favorite($activity_id) ? 'hidden' : '') ?> button unfav bp-secondary-action" title="<?php _e( 'Remove Favorite', 'buddypress' ) ?>"><?php _e( 'Remove Favorite', 'buddypress' ) ?></a>
            </div> <!-- .post-favorite -->
            <?php endif // user_logged_in?>
        </div> <!-- .post-favorite-wrapper --> 

        <div class="related-posts hidden"><?php related_posts(); ?></div>

        <div id="<?php the_ID(); ?>-post-actions" class="post-actions" data-pid="<?php the_ID(); ?>">

            <div class="spinner" style="display:none;">Loading</div>

            <div class="social-back hidden"><a href="#">BACK</a></div>

            <a href="#" data-type="share" class="post-action share-action">SHARE</a> <a href="#" data-type="conversation" class="post-action action-comment">COMMENT</a> <a href="#" data-type="related" class="post-action action-related">RELATED</a>

        </div><!-- .post-actions -->

    </div><!-- .article-wrapper -->
