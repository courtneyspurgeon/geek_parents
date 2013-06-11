<?php
// register Logbook_Widget widget
function register_admin_widgets() 
{
    register_widget( "Logbook_Widget" );
    register_widget( "Sharetools_Widget" );
}

add_action( 'widgets_init', 'register_admin_widgets', 1);

/**
 * Adds Logbook_Widget widget.
 */
class Logbook_Widget extends WP_Widget 
{
	/**
	 * Register widget with WordPress.
	 */
    public function __construct() 
    {
		parent::__construct(
	 		'logbook_widget', // Base ID
			'Logbook Widget', // Name
			array( 'description' => __( 'Adds a logbook for the current user.' ), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
    public function widget( $args, $instance ) 
    {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
            echo $before_title . $title . $after_title; ?>

            <div id="user-logbook" class="logbook-hide">

                <p id="logbook-heading"><a href="#">Toggle Open/Close</a></p>

                <div id="logbook-content">

                  <?php if ( is_user_logged_in() ) : ?>

                  <?php if ( $arrActivities = get_my_bp_activity_favorites() ) { ?>

                      <?php if ( bp_has_activities( 'include='.implode(',',$arrActivities) ) ) { ?>
                      <ul>
                            <?php while ( bp_activities() ) : bp_the_activity(); ?>
                         
                                <?php locate_template( array( 'favorites.php' ), true, false ); ?>
                         
                            <?php endwhile; ?>
                      </ul>
                      <?php } // end if?>

                  <?php } else { ?>

                  <p>Your logbook is empty</p>

                  <?php } // end if ?>

                  <?php else : ?>
                      <?php if ( bp_get_signup_allowed() ) : ?>
                      
                          <p id="login-text">
                              <?php printf( __( 'Please <a href="%s" title="Create an account">create an account</a> to get started.', 'buddypress' ), bp_get_signup_page() ); ?>
                          </p>

                      <?php endif; ?>
                  <?php endif; ?>

                </div>
            </div><!-- #user-logbook -->
<?php
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
    public function update( $new_instance, $old_instance ) 
    {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
    public function form( $instance ) 
    {
        if ( isset( $instance[ 'title' ] ) ) 
        {
			$title = $instance[ 'title' ];
		}
        else 
        {
			$title = __( 'User Logbook' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class Logbook_Widget

/**
 * Adds Sharetools_Widget widget.
 */
class Sharetools_Widget extends WP_Widget 
{
	/**
	 * Register widget with WordPress.
	 */
    public function __construct() 
    {
		parent::__construct(
	 		'sharetools_widget', // Base ID
			'Sharetools Widget', // Name
			array( 'description' => __( 'Adds some share/save tools for the current user.' ), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
    public function widget( $args, $instance ) 
    {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

            $post = get_post(get_the_ID());
              $activity_id = bp_activity_get_activity_id( array(
                'user_id' => $post->post_author,
                'type' => 'new_blog_post',
                'component' => 'blogs',
                'item_id' => 1,
                'secondary_item_id' => $post->ID
              ) );
        ?>

            <div id="post-favorite">

            <?php if ( is_user_logged_in() ) : ?>

              <?php bp_has_activities(); ?>

              <div id="logbook-spinner" style="display:none;"><img src="<?php echo get_stylesheet_directory_uri() ?>/img/ajax-loader.gif" />Loading</div>
              <a href="<?php my_bp_activity_favorite_link($activity_id) ?>" class="<?php echo (my_bp_activity_is_favorite($activity_id) ? 'hide' : '') ?> button fav bp-secondary-action" title="<?php _e( 'Mark as Favorite', 'buddypress' ) ?>"><?php _e( 'Favorite', 'buddypress' ) ?></a>
              <a href="<?php my_bp_activity_unfavorite_link($activity_id) ?>" class="<?php echo (!my_bp_activity_is_favorite($activity_id) ? 'hide' : '') ?> button unfav bp-secondary-action" title="<?php _e( 'Remove Favorite', 'buddypress' ) ?>"><?php _e( 'Remove Favorite', 'buddypress' ) ?></a>

            <?php endif // user_logged_in?>

            </div>
    <?php
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
    public function update( $new_instance, $old_instance ) 
    {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
    public function form( $instance ) 
    {
        if ( isset( $instance[ 'title' ] ) ) 
        {
			$title = $instance[ 'title' ];
		}
        else 
        {
			$title = __( 'Share and Save' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}

} // class Sharetools_Widget
?>
