<?php

function add_menu() 
{
    add_submenu_page('edit.php', 'Order', 'Stories Order', 'edit_others_posts', 'order-sticky-posts', 'display_sorted_order');
}
add_action( 'admin_menu', 'add_menu');

function display_sorted_order() 
{

    $strSticky = get_option( 'sticky_posts' );
    $strMetaKey = '_top_tile_position';
    $arrPosts['notsticky'] = get_posts( array( 
      'numberposts' => -1,
      'post__in' => $strSticky,
      'ignore_sticky_posts' => 1,
      'order' => 'ASC'
    ));
    $arrPosts['sticky'] = get_posts( array( 
      'numberposts' => -1,
      'post__in' => $strSticky,
      'ignore_sticky_posts' => 1,
      'orderby' => 'meta_value',
      'meta_key' => $strMetaKey,
      'order' => 'ASC'
    ));

?>
  <h2>Sort Stories</h2>

  <style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 70%; }
    #sortable li { margin: 0 5px 5px 5px; padding: 0.4em; padding-left: 1.5em; font-size: 1.2em; height: 18px; cursor: move; position:relative; background-color:#c3c3c3 }
    #sortable li span { position: absolute; margin-left: -1.3em; }
    #sort-results {color:#E6E6E6;margin:10px 0;padding:10px;width:70%;}
    .sticky {color:green;}
    .error {background-color:red}
    .success {background-color:green}
    .hide {display:none;}
  </style>
  <script>
    jQuery(function() {
      jQuery( "#sortable" ).sortable({
        stop: function( event, ui ) {
          var arrOrder = []
          jQuery('#sortable li')
            .each(function(i,el){
              arrOrder[i] = el.id;
          });
          jQuery.post(ajaxurl, {action:'update-tile-order', tile_order:arrOrder}, function(data) {
            jQuery('#sort-results').show().text(data).addClass(data)
            jQuery('#sort-results').delay(2000).hide('slow')
          });
        }
      });
      jQuery( "#sortable" ).disableSelection();
    });
  </script>

  <ul id="sortable">
<?php
    ksort($arrPosts, SORT_DESC);
    foreach ($arrPosts as $strStatus=>$objPosts)
    {
        foreach ($objPosts as $objPost)
        {
            $strHidden = (in_array($objPost, $arrPosts['sticky']) && $strStatus == 'notsticky') ? 'hide' : 'show';
?>
    <li id="<?php echo $objPost->ID; ?>" class="ui-state-default <?php echo $strStatus .' '. $strHidden ?> ">
      <span class="ui-icon ui-icon-arrowthick-2-n-s"><?php echo $objPost->post_title; ?></span>
    </li>
<?php
        }
    }
    echo "</ul>";
    echo '<div id="sort-results"></div>';
} 

function ajax_save_order() 
{

    $arrOrder = $_POST['tile_order'];

    if ( is_array($arrOrder) ) 
    {
        foreach( $arrOrder as $strIndex=>$strPostID ) 
        { 
            update_post_meta($strPostID, '_top_tile_position', $strIndex);
        }
        echo 'success';
    }
    else 
    {
        echo 'error';
    }
    die(); // Silly Wordpress, functions are for kids

}

add_action( 'wp_ajax_update-tile-order', 'ajax_save_order');

?>
