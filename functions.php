<?php

function thim_child_enqueue_styles() {
	wp_enqueue_style( 'thim-parent-style', get_template_directory_uri() . '/style.css', array(), THIM_THEME_VERSION  );
}

add_action( 'wp_enqueue_scripts', 'thim_child_enqueue_styles', 1000 );

// hide update notifications
function remove_core_updates(){
	global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes

function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// Function to change email address
function wpb_sender_email( $original_email_address ) {
    return 'info@studom.online';
}
add_filter( 'wp_mail_from', 'wpb_sender_email' );

// Function to change sender name
//function wpb_sender_name( $original_email_from ) {
	//return 'Tim Smith';
//}
//add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

/**
 * Function print preload
 */
function thim_print_preload() {
	$enable_preload     = get_theme_mod( 'thim_preload', 'default' );
	$thim_preload_image = get_theme_mod( 'thim_preload_image', false );
	$item_only          = ! empty( $_REQUEST['content-item-only'] ) ? $_REQUEST['content-item-only'] : false;
	if ( ! empty( $enable_preload ) && empty( $item_only ) ) { ?>
		<div id="preload">
			<?php
			if ( $thim_preload_image && $enable_preload == 'image' ) {
				if ( is_numeric( $thim_preload_image ) ) {
					echo wp_get_attachment_image( $thim_preload_image, 'full' );
				} else {
					echo '<img src="' . $thim_preload_image . '" alt="' . esc_html__( 'Preaload Image', 'eduma' ) . '"/>';
				}
			} else {
				//echo '<img src="' . site_url() . '/wp-content/themes/eduma-child/images/logo-rotate.svg" class="ctm-preload-img" alt="' . esc_html__( 'Preaload Image', 'eduma' ) . '"/>';
				switch ( $enable_preload ) {
					case 'style_1':
						$output_preload = '<div class="cssload-loader-style-1">
												<div class="cssload-inner cssload-one"></div>
												<div class="cssload-inner cssload-two"></div>
												<div class="cssload-inner cssload-three"></div>
											</div>';
						break;
					case 'style_2':
						$output_preload = '<div class="cssload-loader-style-2">
											<div class="cssload-loader-inner"></div>
										</div>';
						break;
					case 'style_3':
						$output_preload = '<div class="sk-folding-cube">
											<div class="sk-cube1 sk-cube"></div>
											<div class="sk-cube2 sk-cube"></div>
											<div class="sk-cube4 sk-cube"></div>
											<div class="sk-cube3 sk-cube"></div>
										</div>';
						break;
					case 'wave':
						$output_preload = '<div class="sk-wave">
									        <div class="sk-rect sk-rect1"></div>
									        <div class="sk-rect sk-rect2"></div>
									        <div class="sk-rect sk-rect3"></div>
									        <div class="sk-rect sk-rect4"></div>
									        <div class="sk-rect sk-rect5"></div>
									      </div>';
						break;
					case 'rotating-plane':
						$output_preload = '<div class="sk-rotating-plane"></div>';
						break;
					case 'double-bounce':
						$output_preload = '<div class="sk-double-bounce">
									        <div class="sk-child sk-double-bounce1"></div>
									        <div class="sk-child sk-double-bounce2"></div>
									      </div>';
						break;
					case 'wandering-cubes':
						$output_preload = '<div class="sk-wandering-cubes">
									        <div class="sk-cube sk-cube1"></div>
									        <div class="sk-cube sk-cube2"></div>
									      </div>';
						break;
					case 'spinner-pulse':
						$output_preload = '<div class="sk-spinner sk-spinner-pulse"></div>';
						break;
					case 'chasing-dots':
						$output_preload = '<div class="sk-chasing-dots">
									        <div class="sk-child sk-dot1"></div>
									        <div class="sk-child sk-dot2"></div>
									      </div>';
						break;
					case 'three-bounce':
						$output_preload = '<div class="sk-three-bounce">
									        <div class="sk-child sk-bounce1"></div>
									        <div class="sk-child sk-bounce2"></div>
									        <div class="sk-child sk-bounce3"></div>
									      </div>';
						break;
					case 'cube-grid':
						$output_preload = '<div class="sk-cube-grid">
									        <div class="sk-cube sk-cube1"></div>
									        <div class="sk-cube sk-cube2"></div>
									        <div class="sk-cube sk-cube3"></div>
									        <div class="sk-cube sk-cube4"></div>
									        <div class="sk-cube sk-cube5"></div>
									        <div class="sk-cube sk-cube6"></div>
									        <div class="sk-cube sk-cube7"></div>
									        <div class="sk-cube sk-cube8"></div>
									        <div class="sk-cube sk-cube9"></div>
									      </div>';
						break;
					default:
						$output_preload = '<div class="sk-folding-cube">
											<div class="sk-cube1 sk-cube"></div>
											<div class="sk-cube2 sk-cube"></div>
											<div class="sk-cube4 sk-cube"></div>
											<div class="sk-cube3 sk-cube"></div>
										</div>';
				}
				echo ent2ncr( $output_preload );
			}
			?>
		</div>
	<?php }
}
add_action( 'thim_before_body', 'thim_print_preload' );


class Thim_Login_Popup_Widget extends Thim_Widget {

	public $ins = array();

	function __construct() {
		parent::__construct(
			'login-popup',
			esc_html__( 'Thim: Login Popup', 'eduma' ),
			array(
				'panels_groups' => array( 'thim_builder_so_widgets' ),
				'panels_icon'   => 'thim-widget-icon thim-widget-icon-login-popup'
			),
			array(),
			array(
				'text_register' => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Register Label', 'eduma' ),
					'default' => 'Register',
				),
				'text_login'    => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Login Label', 'eduma' ),
					'default' => 'Login',
				),
				'text_logout'   => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Logout Label', 'eduma' ),
					'default' => 'Logout',
				),
				'text_profile'  => array(
					'type'    => 'text',
					'label'   => esc_html__( 'Profile Label', 'eduma' ),
					'default' => 'Profile',
				),
				'layout'        => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Layout', 'eduma' ),
					'default' => 'base',
					'options' => array(
						'base' => esc_html__( 'Default', 'eduma' ),
						'icon' => esc_html__( 'Icon', 'eduma' ),
					)
				),

				'captcha'   => array(
					'type'        => 'checkbox',
					'label'       => esc_html__( 'Use captcha?', 'eduma' ),
					'description' => esc_html__( 'Use captcha in register and login form.', 'eduma' ) . esc_html__( '(not show when Enable register form of LearnPress.)', 'eduma' ),
					'default'     => false,
				),
				'term'      => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Terms of Service link', 'eduma' ),
					'description' => esc_html__( 'Leave empty to disable this field.', 'eduma' ) . esc_html__( '(not show when Enable register form of LearnPress.)', 'eduma' ),
					'default'     => '',
				),
				'shortcode' => array(
					'type'        => 'text',
					'label'       => esc_html__( 'Shortcode', 'eduma' ),
					'description' => esc_html__( 'Enter shortcode to show in form Login.', 'eduma' ),
					'default'     => '',
				)

			)
		);
	}

	/**
	 * Initialize the CTA widget
	 */
	function get_template_name( $instance ) {
		$this->ins = $instance;
		add_action( 'wp_footer', array( $this, 'thim_display_login_popup_form' ), 5 );

		return 'base';
	}

	function get_style_name( $instance ) {
		return false;
	}

	function thim_display_login_popup_form() {
		$instance = $this->ins;

		if ( ! is_user_logged_in() ) {
			$registration_enabled       = get_option( 'users_can_register' );
			//$lp_register_form = false;
			//if ( class_exists( 'LearnPress' ) && thim_is_new_learnpress( '4.0' ) ) {
				//$lp_register_form = get_theme_mod( 'thim_form_lp_register',false );
				//$lp_enable_register_profile = get_option( 'learn_press_enable_register_profile' );
			//}
			?>
			<div id="thim-popup-login">
				<div
					class="popup-login-wrapper<?php echo ( ! empty( $instance['shortcode'] ) ) ? ' has-shortcode' : ''; ?>">
					<div class="thim-login-container">
						<?php
						if ( ! empty( $instance['shortcode'] ) ) {
							echo do_shortcode( $instance['shortcode'] );
						}
						$current_page_id = get_queried_object_id();
						?>

						<div class="thim-popup-inner">
							<div class="thim-login">
								<h4 class="title"><?php esc_html_e( 'Login with your site account', 'eduma' ); ?></h4>
								<form name="loginpopopform"
									  action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>"
									  method="post">

									<?php do_action( 'thim_before_login_form' ); ?>

									<p class="login-username">
										<input type="text" name="log"
											   placeholder="<?php esc_html_e( 'Username or email', 'eduma' ); ?>"
											   class="input required" value="" size="20"/>
									</p>
									<p class="login-password">
										<input type="password" name="pwd"
											   placeholder="<?php esc_html_e( 'Password', 'eduma' ); ?>"
											   class="input required" value="" size="20"/>
									</p>

									<?php
									/**
									 * Fires following the 'Password' field in the login form.
									 *
									 * @since 2.1.0
									 */
									do_action( 'login_form' );
									?>

									<?php if ( ! empty( $instance['captcha'] ) ): ?>
										<p class="thim-login-captcha">
											<?php
											$value_1 = rand( 1, 9 );
											$value_2 = rand( 1, 9 );
											?>
											<input type="text"
												   data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
												   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
												   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
												   class="captcha-result required"
												   name="thim-eduma-recaptcha-rs"/>
											<input name="thim-eduma-recaptcha[]" type="hidden"
												   value="<?php echo $value_1 ?>"/>
											<input name="thim-eduma-recaptcha[]" type="hidden"
												   value="<?php echo $value_2 ?>"/>
										</p>
									<?php endif; ?>

									<?php echo '<a class="lost-pass-link" href="' . thim_get_lost_password_url() . '" title="' . esc_attr__( 'Lost Password', 'eduma' ) . '">' . esc_html__( 'Lost your password?', 'eduma' ) . '</a>'; ?>
									<p class="forgetmenot login-remember">
										<label for="popupRememberme"><input name="rememberme" type="checkbox"
																			value="forever"
																			id="popupRememberme"/> <?php esc_html_e( 'Remember Me', 'eduma' ); ?>
										</label></p>
									<p class="submit login-submit">
										<input type="submit" name="wp-submit"
											   class="button button-primary button-large"
											   value="<?php esc_attr_e( 'Login', 'eduma' ); ?>"/>
										<input type="hidden" name="redirect_to"
											   value="<?php echo esc_url( thim_eduma_get_current_url() ); ?>"/>
										<input type="hidden" name="testcookie" value="1"/>
										<input type="hidden" name="nonce"
											   value="<?php echo wp_create_nonce( 'thim-loginpopopform' ) ?>"/>
										<input type="hidden" name="eduma_login_user">
									</p>

									<?php do_action( 'thim_after_login_form' ); ?>

								</form>
								<?php
								if ( $registration_enabled ) {
									echo '<p class="link-bottom">' . esc_html__( 'Not a member yet? ', 'eduma' ) . ' <a class="register" href="' . esc_url( thim_get_register_url() ) . '">' . esc_html__( 'Register now', 'eduma' ) . '</a></p>';
								}
								?>
								<?php do_action( 'thim-message-after-link-bottom' ); ?>
							</div>

							<?php if ( $registration_enabled ): ?>
								<div class="thim-register">
											<h4 class="title"><?php echo esc_html_x( 'Register a new account', 'Login popup form', 'eduma' ); ?></h4>
										<form class="<?php if ( get_theme_mod( 'thim_auto_login', true ) ) {
											echo 'auto_login';
										} ?>" name="registerformpopup" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>"
											  method="post" novalidate="novalidate">

											<?php wp_nonce_field( 'ajax_register_nonce', 'register_security' ); ?>

											<p>
												<input placeholder="<?php esc_attr_e( 'Username', 'eduma' ); ?>"
													   type="text" name="user_login" class="input required"/>
											</p>

											<p>
												<input placeholder="<?php esc_attr_e( 'Email', 'eduma' ); ?>"
													   type="email" name="user_email" class="input required"/>
											</p>

											<?php //if ( get_theme_mod( 'thim_auto_login', true ) ) { ?>
												<p>
													<input placeholder="<?php esc_attr_e( 'Password', 'eduma' ); ?>"
														   type="password" name="password" class="input required"/>
												</p>
												<p>
													<input
														placeholder="<?php esc_attr_e( 'Repeat Password', 'eduma' ); ?>"
														type="password" name="repeat_password"
														class="input required"/>
												</p>
											<?php //} ?>

											<?php
											if ( is_multisite() && function_exists( 'gglcptch_login_display' ) ) {
												gglcptch_login_display();
											}

											do_action( 'register_form' );
											?>

											<?php if ( ! empty( $instance['captcha'] ) ) : ?>
												<p class="thim-login-captcha">
													<?php
													$value_1 = rand( 1, 9 );
													$value_2 = rand( 1, 9 );
													?>
													<input type="text"
														   data-captcha1="<?php echo esc_attr( $value_1 ); ?>"
														   data-captcha2="<?php echo esc_attr( $value_2 ); ?>"
														   placeholder="<?php echo esc_attr( $value_1 . ' &#43; ' . $value_2 . ' &#61;' ); ?>"
														   class="captcha-result required"/>
												</p>
											<?php endif; ?>

											<?php if ( ! empty( $instance['term'] ) ): ?>
												<p>
													<input type="checkbox" class="required" name="term"
														   id="termFormFieldPopup">
													<label
														for="termFormFieldPopup"><?php printf( __( 'I accept the <a href="%s" target="_blank">Terms of Service</a>', 'eduma' ), esc_url( $instance['term'] ) ); ?></label>
												</p>
											<?php endif; ?>

											<?php //do_action( 'signup_hidden_fields', 'create-another-site' ); ?>

											<p class="submit">
												<input type="submit" name="wp-submit"
													   class="button button-primary button-large"
													   value="<?php echo esc_attr_x( 'Sign up', 'Login popup form', 'eduma' ); ?>"/>
											</p>
											<!-- <input type="hidden" name="become_teacher" value="0" /> -->
											<input type="hidden" name="redirect_to"
												   value="<?php echo esc_url( thim_eduma_get_current_url() ); ?>"/>
											<!--<input type="hidden" name="modify_user_notification" value="1">-->
											<input type="hidden" name="eduma_register_user">
										</form>
										<?php echo '<p class="link-bottom">' . esc_html_x( 'Are you a member? ', 'Login popup form', 'eduma' ) . ' <a class="login" href="' . esc_url( thim_get_login_page_url() ) . '">' . esc_html_x( 'Login now', 'Login popup form', 'eduma' ) . '</a></p>'; ?>
									<?php do_action( 'thim-message-after-link-bottom' ); ?>
									<div class="popup-message"></div>
								</div>
							<?php endif; ?>
						</div>

						<span class="close-popup"><i class="fa fa-times" aria-hidden="true"></i></span>
							<div class="cssload-container"> <div class="cssload-loading"> <img src="<?php echo site_url() . '/wp-content/themes/eduma-child/images/logo-rotate.svg'; ?>" class="ctm-archive-preload-img" alt="Preaload Image"/> <!--<i></i><i></i><i></i><i></i>--></div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

/**
 * Add instructor registration button to register page and admin bar
 */
remove_action('register_form', 'learn_press_user_become_teacher_registration_form');
function learn_press_user_become_teacher_registration_form_update() {
	if ( LP()->settings->get( 'instructor_registration' ) != 'yes' ) {
		return;
	}
	?>
	<p>
		<label for="become_teacher">
			<input type="checkbox" value=1 name="become_teacher" id="become_teacher">
			<?php esc_html_e( 'Want to become an instructor?', 'learnpress' ); ?> <a href="<?php echo site_url().'/teachers-and-students-terms-conditions/'; ?>" target="_blank">Terms & Conditions</a>
		</label>
	</p>
	<?php
}
add_action('register_form', 'learn_press_user_become_teacher_registration_form_update');

/**
 * Change 'Return to Shop' text on button
*/
add_filter('woocommerce_return_to_shop_text', 'prefix_store_button');
function prefix_store_button() {
	$store_button = "Back to Courses"; // Change text as required
	return $store_button;
}
/**
 * Changes the redirect URL for the Return To Shop button in the cart.
 *
 * @return string
*/
function wc_empty_cart_redirect_url() {
	return site_url().'/courses/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );

function thim_about_author() {
	$lp_info = get_the_author_meta( 'lp_info' );
		$link    = '#';
	if ( get_post_type() == 'lpr_course' ) {
		$link = apply_filters( 'learn_press_instructor_profile_link', '#', $user_id = null, get_the_ID() );
	} elseif ( get_post_type() == 'lp_course' ) {
		$link = learn_press_user_profile_link( get_the_author_meta( 'ID' ) );
	} elseif ( is_single() ) {
		$link = get_author_posts_url( get_the_author_meta( 'ID' ) );
	}
	$instructorID = get_the_author_meta( 'ID' );
	//echo "instructorID : ".$instructorID;
	?>
	<div class="thim-about-author">
		<div class="author-wrapper">
			<div class="author-avatar">
                <a href="<?php echo esc_url( $link ); ?>">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 110, '', esc_attr__('author avatar', 'eduma') ); ?>
                </a>
			</div>
			<div class="author-bio">
				<div class="author-top">
					<a class="name" href="<?php echo esc_url( $link ); ?>">
						<?php echo get_the_author(); ?>
					</a>
					<?php if ( isset( $lp_info['major'] ) && $lp_info['major'] ) : ?>
						<p class="job"><?php echo esc_html( $lp_info['major'] ); ?></p>
					<?php endif; ?>
				</div>
				<?php
					if ( function_exists( 'thim_lp_social_user' ) && get_post_type() == 'lp_course'  ) {
						thim_lp_social_user();
					}
				?>
			</div>
			<div class="author-description">
				<?php
                    //fix error author description cannot line break
					  echo wpautop(get_user_meta(  get_the_author_meta( 'ID' ) , 'description', true ));
				?>
			</div>
		</div>

		<div class="author-chat-module">
			<?php
			if(is_user_logged_in()) {
				if ( get_post_type() == 'lp_course' ) {
					echo do_shortcode('[wise-chat theme="airflow" show_users_counter="1" show_user_name="1" allow_post_links="1" allow_post_images="1" enable_images_uploader="1" enable_twitter_hashtags="1" show_message_submit_button="1" allow_change_user_name="1" emoticons_enabled="4" window_title="Studom Instructor Chat" enable_attachments_uploader="1" messages_time_mode="elapsed" enable_youtube="1" allow_change_text_color="1"]');
				}
			}
			?>
		</div>

	</div>
	<?php
	if ( class_exists( 'LearnPress' ) && function_exists( 'thim_co_instructors' ) ) {
			thim_co_instructors( get_the_ID(), get_the_author_meta( 'ID' ) );
	}
}

function getUserAvatarCoursePage($user, $enabled, $priorityWordPressId = null) {
	$imageSrc = null;

	if ($enabled) {
		if ($user !== null && strlen($user->getExternalId()) > 0) {
			$imageSrc = $user->getAvatarUrl();
		} else if ($priorityWordPressId > 0 || ($user !== null && $user->getWordPressId() !== null)) {
			$imageTag = $priorityWordPressId > 0 ? get_avatar($priorityWordPressId) : get_avatar($user->getWordPressId());
			
			$doc = new DOMDocument();
			@$doc->loadHTML($imageTag);
			$imageTags = $doc->getElementsByTagName('img');
			foreach($imageTags as $tag) {
				$imageSrc = $tag->getAttribute('src');
			}
		} else {
			$imageSrc = $this->options->getIconsURL().'user.png';
		}
	}

	return $imageSrc;
}


add_filter('wc_users_list_html', function($html, $channel, $channelUsers) {
	if ( get_post_type() == 'lp_course' ) {
		$instructorID = get_the_author_meta( 'ID' );
		foreach ($channelUsers as $channelUser) {
			if($instructorID == $channelUser->getUser()->getWordPressId()) {
				$WiseChatRenderer = new WiseChatRenderer();
				$WiseChatUserService = new WiseChatUserService();
				$userIdHash = $WiseChatUserService::getUserHash($channelUser->getUser()->getId());
				$publicID = $WiseChatRenderer->getUserPublicIdForChannel($channelUser->getUser(), $channel);
				$isAllowed = "1";
				$encodedName = htmlspecialchars($channelUser->getUser()->getName(), ENT_QUOTES, 'UTF-8', false);
				if ($channelUser->isActive()) {
					$userClassName .= ' wcUserActive';
				} else {
					$userClassName .= ' wcUserInactive';
				}
				$activityFlagHtml = '<span class="wcUserActivityFlag"></span>';
				$textColorProposal = $channelUser->getUser()->getDataProperty('textColor');
				if (strlen($textColorProposal) > 0) {
					$textColor = $textColorProposal;
				}
				if (strlen($textColor) > 0) {
					$styles = sprintf('style="color: %s"', $textColor);
				}
				$avatarHtml = sprintf('<img src="%s" class="wcUserListAvatar" />', getUserAvatarCoursePage($channelUser->getUser(), true, $priorityWordPressId = null));
				
				$html = '<a href="javascript://" data-info-window="" data-allowed="'.$isAllowed.'" data-public-id="'.$publicID.'" data-hash="'.$userIdHash.'" data-wp-id="'.$channelUser->getUser()->getWordPressId().'" data-name="'.$encodedName.'" class="wcUserInChannel '.$userClassName.'" '.$styles.'>'.$avatarHtml.' '.$encodedName.'</a>';
			}
	    }

		//remove_action("wp_ajax_nopriv_wise_chat_maintenance_endpoint", 'wise_chat_endpoint_maintenance');
		//remove_action("wp_ajax_wise_chat_maintenance_endpoint", 'wise_chat_endpoint_maintenance');

	}
	//$html .= 'Wise Chat Pro custom data here...';
	
	return $html;
}, 11, 3);




function is_current_logged_user_a_teacher() {
	$user = wp_get_current_user();
	$user_roles = (array) $user->roles;

	return in_array( 'lp_teacher', $user_roles );
}

function get_user_id_of_meeting_author( $zoom_api_endpoint = '', $zoom_meeting_id = 0 ) {
	return Zoom_Video_Conferencing_Api::get_user_id( $zoom_api_endpoint, $zoom_meeting_id );
}

function get_post_id_from_zoom_meeting_id( $zoom_meeting_id ) {
	global $wpdb;
	return $wpdb->get_var( "SELECT post_id FROM `$wpdb->postmeta` WHERE `meta_key` LIKE '_meeting_zoom_meeting_id' AND `meta_value` LIKE '{$zoom_meeting_id}' LIMIT 1" );
}

if( is_current_logged_user_a_teacher() ) {

	function remove_post_actions_for_teachers( $actions ) {

		global $post;

		$zoom_meeting_post_id = $post->ID;

		if( get_post_status( $zoom_meeting_post_id ) === 'publish' && get_post_type( $zoom_meeting_post_id ) === 'zoom-meetings'
		 ) {
			unset( $actions['edit'], $actions['inline hide-if-no-js'] );
		}

		return $actions;
	}

	if ( ! current_user_can('manage_options') ) {
		add_filter( 'post_row_actions','remove_post_actions_for_teachers', 10, 1 );
	}

	/*
	* Removes the Edit Post - zoom-meetings option from the admin bar if a single post is being shown and
	* the post is published
	*/
	function pep_before_admin_bar_render() {

		global $wp_admin_bar, $post;
		if ( is_single() && $post->post_status == 'publish' && $post->post_type == 'zoom-meetings' ) $wp_admin_bar->remove_menu('edit');

	}

	add_action( 'wp_before_admin_bar_render' , 'pep_before_admin_bar_render' );

	function restrict_editing_publish_zoom_meeting_post( $allcaps, $cap, $args ) { // Restrict users from editing post based on the age of post

		// Bail out if we're not asking to edit or delete a post ...
		if( ( 'edit_post' != $args[0] && 'delete_post' != $args[0] )
		  // ... or user is admin 
		  || ! empty( $allcaps['manage_options'] )
		  // ... or user already cannot edit the post
		  || empty( $allcaps['edit_posts'] ) )
		    return $allcaps;

		// Load the post data:
		// $post = get_post( $args[2] );

		

		if( isset( $_GET['post'] ) && intval( $_GET['post'] ) > 0 ) {
			$p = get_post( $_GET['post'] );

			if( $p->post_type == 'zoom-meetings' && $p->post_status == 'publish' ) {
				/*$allcaps['edit_zoom-meetings'] = 0;
				$allcaps['edit_zoom-meetingss'] = 0;
				$allcaps['edit_zoom_meetings'] = 0;
				$allcaps['edit_zoom-meeting'] = 0;*/
				$allcaps['edit_published_zoom-meetingss'] = 0;
				$allcaps['edit_published_posts'] = 0;
				/*$allcaps['delete_published_post'] = 0;
				$allcaps['delete_published_posts'] = 0;
				$allcaps['delete_published_zoom-meetingss'] = 0;*/
			}
		}

		/*echo '<pre>';
		print_r($args);echo '</pre>';*/

		return $allcaps;
	}

	add_filter( 'user_has_cap', 'restrict_editing_publish_zoom_meeting_post', 10, 3 );

	function _teacher_zoom_meetings_columns( $columns ) {

		array_shift( $columns );

		return $columns;
	}

	add_filter('manage_edit-zoom-meetings_columns', '_teacher_zoom_meetings_columns');

}

add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
  echo '<style>
    input.regular-text {
	    width: auto !important;
	}
  </style>';
}

/**
 * Add profile tab.
 *
 * @param $tabs
 *
 * @return mixed
 */
function profile_tabs_chat( $tabs ) {
	if ( ! LPC()->is_enable() ) {
		return $tabs;
	}

	$profile      = LP_Profile::instance();
	$current_user = learn_press_get_current_user();

	if ( ! $profile->is_current_user() ) {
		return $tabs;
	}

	if ( ! $current_user->has_role( array( 'administrator', 'lp_teacher' ) ) ) {
		return $tabs;
	}

	$tabs['chat'] = array(
		'title'    => __( 'Chat', 'learnpress-chat' ),
		'callback' => 'chat_tab_content'
	);

	return $tabs;
}
add_filter( 'learn-press/profile-tabs', 'profile_tabs_chat' );

/**
 * @return string
 */
function chat_tab_content() {
	ob_start();
	?>
	<div class="custom-chat-tab"><?php echo do_shortcode('[wise-chat theme="airflow" show_users_counter="1" show_user_name="1" allow_post_links="1" allow_post_images="1" enable_images_uploader="1" enable_twitter_hashtags="1" show_message_submit_button="1" allow_change_user_name="1" emoticons_enabled="4" window_title="Studom Chat" enable_attachments_uploader="1" messages_time_mode="elapsed" enable_youtube="1" allow_change_text_color="1"]'); ?></div>
	<?php
	return ob_get_clean();
}

/**
 * @param $endpoints
 *
 * @return array
 */
function profile_tab_endpoints_chat( $endpoints ) {
	$endpoints[] = 'chat';

	return $endpoints;
}
add_filter( 'learn_press_profile_tab_endpoints', 'profile_tab_endpoints_chat' );


/**
 * Filter profile title
 *
 * @param $tab_title
 * @param $key
 *
 * @return string
 */
function thim_tab_profile_filter_title( $tab_title, $key ) {

	switch ( $key ) {
		case 'withdrawals':
			$tab_title = '<i class="fa fa-money-bill-alt"></i><span class="text">' . $tab_title . '</span>';
			break;
		case 'chat':
			$tab_title = '<i class="fa fa-comments"></i><span class="text">' . $tab_title . '</span>';
			break;
	}

	return $tab_title;
}
add_filter( 'learn_press_profile_withdrawals_tab_title', 'thim_tab_profile_filter_title', 100, 2 );
add_filter( 'learn_press_profile_chat_tab_title', 'thim_tab_profile_filter_title', 100, 2 );


/* Limit media library access to instructor*/

add_action('pre_get_posts','users_own_attachments');
function users_own_attachments( $wp_query_obj ) {

    global $current_user, $pagenow;

    $is_attachment_request = ($wp_query_obj->get('post_type')=='attachment');

    if( !$is_attachment_request )
        return;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ) )
        return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->ID );

    return;
}


