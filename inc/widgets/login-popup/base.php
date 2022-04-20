<div class="thim-link-login thim-login-popup">
	<?php
	$layout               = isset( $instance['layout'] ) ? $instance['layout'] : 'base';
	$profile_text         = $logout_text = $login_text = $register_text = '';
	$registration_enabled = get_option( 'users_can_register' );

	if ( 'base' == $layout ) {
		$profile_text  = isset( $instance['text_profile'] ) ? $instance['text_profile'] : '';
		$logout_text   = isset( $instance['text_logout'] ) ? $instance['text_logout'] : '';
		$login_text    = isset( $instance['text_login'] ) ? $instance['text_login'] : '';
		$register_text = isset( $instance['text_register'] ) ? $instance['text_register'] : '';
	} else {
		$profile_text = '<i class="ion-android-person"></i>';
		$logout_text  = '<i class="ion-ios-redo"></i>';
		$login_text   = '<i class="ion-android-person"></i>';
	}

	// Login popup link output
	if ( is_user_logged_in() ) {
		global $current_user;
		wp_get_current_user() ;
		?>
		<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children tc-menu-item tc-menu-depth-0 tc-menu-align-left tc-menu-layout-default last-menu-item ctm-profile-menu">
			<a href="javascript:;" class="tc-menu-inner"><?php echo $current_user->user_login; ?></a>
			<!-- <span class="icon-toggle"><i class="fa fa-angle-down"></i></span> -->
			<ul class="sub-menu">
				<?php
				if ( class_exists( 'LearnPress' ) && $profile_text ) {
					if ( thim_is_new_learnpress( '1.0' ) ) {
						echo '<li class="menu-item menu-item-type-custom menu-item-object-custom tc-menu-item tc-menu-depth-1 tc-menu-align-left">';
							echo '<a class="profile" href="' . esc_url( learn_press_user_profile_link() ) . '">' . ( $profile_text ) . '</a>';
						echo '</li>';
					} else {
						echo '<li class="menu-item menu-item-type-custom menu-item-object-custom tc-menu-item tc-menu-depth-1 tc-menu-align-left">';
							echo '<a class="profile" href="' . esc_url( apply_filters( 'learn_press_instructor_profile_link', '#', get_current_user_id(), '' ) ) . '">' . ( $profile_text ) . '</a>';
						echo '</li>';	
					}
				}

				if ( $login_text ) {
					?>
					<li class="menu-item menu-item-type-custom menu-item-object-custom tc-menu-item tc-menu-depth-1 tc-menu-align-left">
						<a class="logout" href="<?php echo esc_url( wp_logout_url( apply_filters( 'thim_default_logout_redirect', thim_eduma_get_current_url() ) ) ); ?>"><?php echo( $logout_text ); ?></a>
					</li>	
					<?php
				}
				?>
			</ul>
		</li>	
		<?php
	} else {
		if ( $registration_enabled && 'base' == $layout ) {
			if ( $register_text ) {
				echo '<a class="register js-show-popup" href="' . esc_url( thim_get_register_url() ) . '">' . ( $register_text ) . '</a>';
			}
		}

		if ( $login_text ) {
			echo '<a class="login js-show-popup" href="' . esc_url( thim_get_login_page_url() ) . '">' . ( $login_text ) . '</a>';
		}
	}
	// End login popup link output
	?>

	
	<!-- <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children tc-menu-item tc-menu-depth-0 tc-menu-align-left tc-menu-layout-default last-menu-item">
		<a href="javascript:;" class="tc-menu-inner"></a>
		<span class="icon-toggle"><i class="fa fa-angle-down"></i></span>
		<ul class="sub-menu">
			<li class="menu-item menu-item-type-custom menu-item-object-custom tc-menu-item tc-menu-depth-1 tc-menu-align-left">
				<a href="#" class="tc-menu-inner tc-megamenu-title">test</a>
			</li>
			<li class="menu-item menu-item-type-custom menu-item-object-custom tc-menu-item tc-menu-depth-1 tc-menu-align-left">
				<a href="#" class="tc-menu-inner tc-megamenu-title">test</a>
			</li>
		</ul>
	</li> -->




</div>
<?php

