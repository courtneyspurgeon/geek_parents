<?php   
// All links should redirect to the source
header( 'Location: '.trim(get_post_meta(get_the_ID(), '_cmb_source_url', true)) ); ?>
<?php get_header(); ?>

	<div id="content">

		<div class="no-padder">

			<?php do_action( 'bp_before_blog_single_post' ) ?>

			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                <?php $strFav = (get_post_favorite($post) ? 'favorite' : ''); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class($strFav.' clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

					<div class="author-box">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
						<p><?php printf( _x( 'curated by %s', 'curated by...', 'buddypress' ), str_replace( '<a href=', '<a rel="author" href=', bp_core_get_userlink( $post->post_author ) ) ); ?></p>
					</div>

                    <header class="article-header">
						<h2 class="posttitle"><?php the_title(); ?></h2>

						<p class="date">
							<?php printf( __( '%1$s <span>in %2$s</span>', 'buddypress' ), get_the_date(), get_the_category_list( ', ' ) ); ?>
							<span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buddypress' ) ); ?></span>
						</p>
                    </header> <!-- end article header -->

                    <section class="entry-content clearfix <?php echo $strFav ?>" itemprop="articleBody">
                        <?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>

                        <?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
                    </section>

                    <footer class="article-footer">

                    <p class="source">Source: 
                      <a class="stwpopup" href="<?php echo trim(get_post_meta(get_the_ID(), 'source', true)); ?>" 
                        title="External Link: <?php echo trim(get_post_meta(get_the_ID(), 'source', true)); ?>"><?php echo trim(get_post_meta(get_the_ID(), 'source', true)); ?></a>
                    </p>

                    <p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buddypress' ), ', ', '</span>' ); ?>&nbsp;</p>

                    </footer> <!-- end article footer -->

				</article>

            <?php if ( bp_has_activities( 'action=blog_post_read&primary_id='.get_the_ID()) ) : ?>
                <?php while ( bp_activities() ) : bp_the_activity(); ?>
             
                    <?php locate_template( array( 'activity/entry.php' ), true, false ); ?>
             
                <?php endwhile; ?>
            <?php endif; ?>

            <?php comments_template( ); ?> 
                          

			<?php endwhile; else: ?>

                <article id="post-not-found" class="hentry clearfix">
                    <header class="article-header">
                        <h1><?php _e("Oops, Post Not Found!", "buddypress"); ?></h1>
                    </header>
                    <section class="entry-content">
                        <p><?php _e("Uh Oh. Something is missing. Try double checking things.", "buddypress"); ?></p>
                    </section>
                    <footer class="article-footer">
                        <p><?php _e("This is the error message in the single.php template.", "buddypress"); ?></p>
                    </footer>
                </article>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar() ?>

<?php get_footer() ?>
