<?php
/**
 * Template for displaying curriculum tab of single course.
 *
 * This template can be overridden by copying it to yourtheme/learnpress/single-course/tabs/curriculum.php.
 *
 * @author  ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.0
 */

defined( 'ABSPATH' ) || exit();

$course                  = LP_Global::course();
$user                    = learn_press_get_current_user();

if ( ! $course || ! $user ) {
	return;
}

$can_view_content_course = $user->can_view_content_course( $course->get_id() );
?>

<div class="course-curriculum" id="learn-press-course-curriculum">
	<div class="curriculum-scrollable">

		<?php do_action( 'learn-press/before-single-course-curriculum' ); ?>

		<?php
		$curriculum = $course->get_curriculum();
		if ( $curriculum ) :
			?>
			<ul class="curriculum-sections">
				<?php
				foreach ( $curriculum as $section ) {
					$args = array(
						'section'                 => $section,
						'can_view_content_course' => $can_view_content_course,
					);

					learn_press_get_template( 'single-course/loop-section.php', $args );
				}
				?>
			</ul>

		<?php else : ?>
			<?php
			echo wp_kses_post(
				apply_filters(
					'learnpress/course/curriculum/empty',
					esc_html__( 'Curriculum is empty', 'learnpress' )
				)
			);
			?>
		<?php endif ?>





		<?php /* ?>
		<div class="lp-course-buttons">
			<?php do_action( 'learn-press/before-purchase-form' ); ?>
			<form name="purchase-course" class="purchase-course form-purchase-course <?php echo $guest_checkout; ?>"
				  method="post" enctype="multipart/form-data">
				<?php do_action( 'learn-press/before-purchase-button' ); ?>

				<input type="hidden" name="purchase-course" value="<?php echo esc_attr( $course->get_id() ); ?>"/>
				<input type="hidden" name="purchase-course-nonce"
					   value="<?php echo esc_attr( LP_Nonce_Helper::create_course( 'purchase' ) ); ?>"/>

				<button class="lp-button button button-purchase-course thim-enroll-course-button">
					<?php echo esc_html( apply_filters( 'learn-press/purchase-course-button-text', __( 'Buy Now', 'eduma' ) ) ); ?>
				</button>
				<?php do_action( 'learn-press/after-purchase-button' ); ?>
			</form>
			<?php do_action( 'learn-press/after-purchase-form' ); ?>
		</div>
		<?php */ ?>

		<?php do_action( 'learn-press/before-course-buttons' ); ?>
		<div class="lp-course-buttons dnone">
			<div class="ctm-wrap-btn-add-course-to-cart">
				<form name="ctm-form-add-course-to-cart" id="AddData" method="post">
					<input type="hidden" name="course-id" value="<?php echo get_the_ID(); ?>">
					<input type="hidden" name="add-course-to-cart-nonce" value="<?php echo wp_create_nonce( 'add-course-to-cart' ); ?>">
					<?php
					global $wpdb, $woocommerce;
					function matched_cart_items( $product_id ) {
					    $count = 0; // Initializing
					    if ( ! WC()->cart->is_empty() ) {
					        // Loop though cart items
					        foreach(WC()->cart->get_cart() as $cart_item ) {
					            if($cart_item['product_id'] == $product_id) {
					                $count++; // incrementing items count
					            }
					        }
					    }
					    return $count; // returning matched items count 
					}
					$product_id = get_the_ID();
					// Usage as a condition in an if statement
					if( 0 < matched_cart_items($product_id) ){
					    //echo '<p>There is "'. matched_cart_items($product_id) .'"matched items in cart</p><br>';
					    ?>
					    <a class="lp-button" href="<?php echo site_url().'/cart/'; ?>">View cart</a>
					    <?php
					} else {
					    //echo '<p>NO matched items in cart</p><br>';
					    ?>
					    <button class="lp-button ctm-add-course-to-cart">Add to cart</button>
					    <?php
					}
					?>
				</form>
			</div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(".ctm-add-course-to-cart").click(function(){
					if(jQuery('body').hasClass('logged-in')){
						jQuery('body').removeClass('thim-popup-active');
						jQuery('#thim-popup-login').removeClass('active sign-in');
					}else{
						jQuery('body').addClass('thim-popup-active');
						jQuery('#thim-popup-login').addClass('active sign-in');
						return false;
					}
					var data = jQuery( "#AddData" ).serialize();
						data += '&action=lpWooAddCourseToCart'
						jQuery.ajax({
							url: 'http://stage.studom.online/wp-admin/admin-ajax.php',
							data: data,
							method: 'post',
							dataType: 'json',
							success: function (rs) {
								if (rs.code == 1) {
									if (undefined != rs.redirect_to && rs.redirect_to != '') {
										window.location = rs.redirect_to
									} else {
										jQuery('.ctm-wrap-btn-add-course-to-cart').append( rs.button_view_cart );
										jQuery('#AddData').remove();

										jQuery('div.widget_shopping_cart_content').html(rs.widget_shopping_cart_content);
										jQuery('.minicart_hover .items-number').html(rs.count_items);
									}
								} else {
									alert( rs.message )
								}
							},
							error: function (e) {
								console.log( e )
							},
						});
						return false;
					});	
				});
		</script>
		<style>
			.dnone{ display: none; }
			#popup-sidebar .dnone{ display: block; text-align: center; }
		</style>

		<?php

		if ( is_user_logged_in() ) {
	        $current_user = wp_get_current_user();
	        //printf( 'Personal Message For %s!', esc_html( $current_user->user_firstname ) );
	        $user      = learn_press_get_current_user();
			$course_id = learn_press_get_course_id();
			/*echo "<pre>";
			print_r($user);
			echo "</pre>";
			echo "<pre>";
			print_r($current_user);
			echo "</pre>";
			echo "<pre>";
			print_r($course_id);
			echo "</pre>";*/
			if ( $user->has_course_status( $course_id, array( 'enrolled', 'completed', 'finished' ) ) ) {
		//		echo 'enrolled'.'completed'.'finished';
			}
	    } else {
	    //    echo( 'Non-Personalized Message!' );
	    }
		?>

		<?php /*do_action( 'learn-press/before-add-course-to-cart-form' ); ?>

		<div class="wrap-btn-add-course-to-cart">
			<form name="form-add-course-to-cart" method="post">

				<?php do_action( 'learn-press/before-add-course-to-cart-button' ); ?>

				<input type="hidden" name="course-id" value="<?php echo esc_attr( $course->get_id() ); ?>"/>
				<input type="hidden" name="add-course-to-cart-nonce"
					   value="<?php echo wp_create_nonce( 'add-course-to-cart' ); ?>"/>

				<button class="lp-button btn-add-course-to-cart">
					<?php _e( 'Add to cart', 'learnpress-woo-payment' ); ?>
				</button>

				<?php do_action( 'learn-press/after-add-course-to-cart-button' ); ?>

			</form>
		</div>

		<?php do_action( 'learn-press/after-add-course-to-cart-form' );*/ ?>















		<?php do_action( 'learn-press/after-single-course-curriculum' ); ?>

	</div>
</div>
