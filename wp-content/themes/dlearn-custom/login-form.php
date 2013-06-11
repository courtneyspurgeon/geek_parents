<?php if ( is_user_logged_in() ) : ?>

    <p>You are Logged In</p>

<?php else : ?>

    <?php if ( bp_get_signup_allowed() ) : ?>
    
        <p id="login-text">

            <?php printf( __( 'Please <a href="%s" title="Create an account">create an account</a> to get started.', 'buddypress' ), bp_get_signup_page() ); ?>

        </p>

    <?php endif; ?>

    <form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ); ?>" method="post">
        <label><?php _e( 'Username', 'buddypress' ); ?><br />
        <input type="text" name="log" id="sidebar-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

        <label><?php _e( 'Password', 'buddypress' ); ?><br />
        <input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>

        <p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'buddypress' ); ?></label></p>

        <input type="submit" name="wp-submit" id="sidebar-wp-submit" value="<?php _e( 'Log In', 'buddypress' ); ?>" tabindex="100" />
        <input type="hidden" name="testcookie" value="1" />
    </form>

<?php endif; ?>
