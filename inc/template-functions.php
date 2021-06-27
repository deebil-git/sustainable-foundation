<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package loveus
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function loveus_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'loveus_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function loveus_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'loveus_pingback_header' );




    if( ! function_exists('loveus_logo') ) :
        function loveus_logo() {
            ?>
            <?php
    $header_topbar_onoff = loveus_get_options('header_topbar_onoff');
    $logo_box_down = '';
    if($header_topbar_onoff == '0') :
        $logo_box_down = 'logo-box-down';
    endif;
    $header_style = loveus_get_options('header_style');

    $header_type = get_query_var('header_type');

?>
<div class="logo-box <?php echo esc_attr($logo_box_down); ?>">
    <div class="logo">
    <?php
        if (has_custom_logo()) {
            //the_custom_logo();
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            if (!empty($logo[0])) {
                ?>
                 <a href="<?php echo esc_url(home_url('/')); ?>">
                      <img src="<?php echo esc_url($logo[0]) ?>" alt="<?php esc_attr_e('Logo', 'loveus') ?>">
                 </a>
                <?php
            }else{
             ?>
             <a href="<?php echo esc_url(home_url('/')); ?>">
              <img src="<?php echo esc_url(LOVEUS_IMG_URL . 'logo.svg') ?>" alt="<?php esc_attr_e('Logo', 'loveus') ?>">
             <?php
            }

        } elseif (!has_custom_logo()) {
            ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php if($header_style == '3' || $header_type == 3) : ?>
                    <img src="<?php echo esc_url(LOVEUS_IMG_URL . 'logo-2.svg') ?>" alt="<?php esc_attr_e('Logo', 'loveus') ?>">
                <?php else : ?>
                    <img src="<?php echo esc_url(LOVEUS_IMG_URL . 'logo.svg') ?>" alt="<?php esc_attr_e('Logo', 'loveus') ?>">
                <?php endif; ?> 
            </a> 
            <?php
        } else {

            if (is_front_page() && is_home()) :
                ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                <?php
            else :
                ?>
                <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
            <?php
            endif;
            $loveus_description = get_bloginfo('description', 'display');
            if ($loveus_description || is_customize_preview()) :
                ?>
                <p class="site-description"><?php echo esc_html($loveus_description); /* WPCS: xss ok. */ ?></p>
                <?php
            endif;
        }
        ?>
        
    </div>
</div>
            <?php 
        }
    endif;
    add_action('loveus_logo_fun', 'loveus_logo');
?>