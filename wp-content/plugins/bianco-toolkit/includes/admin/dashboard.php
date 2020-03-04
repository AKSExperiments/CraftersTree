<?php
if ( !class_exists( 'Ovic_Dashboard' ) ) {
	class  Ovic_Dashboard
	{
		public $tabs = array();
		public $theme_name;

		public function __construct(){
			$this->set_tabs();
			$this->theme_name = wp_get_theme()->get( 'Name' );
			add_action( 'admin_menu', array( $this, 'admin_menu' ), 5 );
		}

		public function admin_menu(){
			if ( current_user_can( 'edit_theme_options' ) ) {
				add_menu_page( __( 'Bianco', 'bianco-toolkit' ), __( 'Bianco', 'bianco-toolkit' ), 'manage_options', 'ovic-dashboard', array( $this, 'welcome' ), BIANCO_TOOLKIT_PLUGIN_URL . '/assets/images/icon-menu.png', 2 );
				add_submenu_page( 'ovic-dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'ovic-dashboard', array( $this, 'welcome' ) );
			}
		}

		public function set_tabs(){
			$tabs = array(
				'dashboard'   => esc_html__( 'Welcome', 'bianco-toolkit' ),
			);
			$tabs       = apply_filters( 'ovic_registered_dashboard_tabs', $tabs );
			if(count($tabs)>1){
				$this->tabs = $tabs;
			}
		}

		function ovic_import(){
			do_action( 'importer_page_content' );
		}

		public function dashboard(){
			global $wpdb;

			$txt_intro	= sprintf("%s %s", __('Welcome to','bianco-toolkit'), ucfirst( esc_html( $this->theme_name ) ) );
			$image = get_theme_file_uri( '/screenshot.jpg' );
			if ( !file_exists( get_template_directory() . '/screenshot.jpg' ) )
				$image = get_theme_file_uri( '/screenshot.png' );

			$system_info = '';
			$changelog   = $this->print_changelog();

		    $theme_data   = wp_get_theme();
		    $theme        = $theme_data->Name . ' ' . $theme_data->Version;
		    $parent_theme = $theme_data->Template;
		    if ( ! empty( $parent_theme ) ) {
		      $parent_theme_data = wp_get_theme( $parent_theme );
		      $parent_theme      = $parent_theme_data->Name . ' ' . $parent_theme_data->Version;
		    }

		    $system_info  = '### Begin System Infos (Generated ' . date( 'Y-m-d H:i:s' ) . ') ###' . "";
		    $system_info .= '<br><br>------------ SITE INFO ------------ <br>';
		    $system_info .= 'Site URL:                 ' . site_url() . '<br>';
		    $system_info .= 'Home URL:                 ' . home_url() . '<br>';
		    $system_info .= 'Multisite:                ' . ( is_multisite() ? 'Yes' : 'No' ) . '<br>';

		    $locale = get_locale();
		    $system_info .= '<br><br>------------ WORDPRESS CONFIGS ------------<br>';
		    $system_info .= 'WP Version:               ' . get_bloginfo( 'version' ) . '<br>';
		    $system_info .= 'Language:                 ' . ( !empty( $locale ) ? $locale : 'en_US' ) . '<br>';
		    $system_info .= 'Permalink Structure:      ' . ( get_option( 'permalink_structure' ) ? get_option( 'permalink_structure' ) : 'Default' ) .'<br>';
		    $system_info .= 'Active Theme:             ' . $theme . '<br>';
		    if ( $parent_theme !== $theme ) {
		      $system_info .= 'Parent Theme:             ' . $parent_theme . '<br>';
		    }
		    $system_info .= 'Show On Front:            ' . get_option( 'show_on_front' ) . '<br>';
		    if( get_option( 'show_on_front' ) == 'page' ) {
		      $front_page_id = get_option( 'page_on_front' );
		      $blog_page_id = get_option( 'page_for_posts' );

		      $system_info .= 'Page On Front:            ' . ( $front_page_id != 0 ? get_the_title( $front_page_id ) . ' (#' . $front_page_id . ')' : 'Unset' ) . '<br>';
		      $system_info .= 'Page For Posts:           ' . ( $blog_page_id != 0 ? get_the_title( $blog_page_id ) . ' (#' . $blog_page_id . ')' : 'Unset' ) . '<br>';
		    }

		    $system_info .= 'ABSPATH:                  ' . ABSPATH . "\n";

		    $system_info .= 'WP_DEBUG:                 ' . ( defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' : 'Disabled' : 'Not set' ) . '<br>';
		    $system_info .= 'WP Memory Limit:          ' . ( $this->ovic_let_to_num( WP_MEMORY_LIMIT )/( 1024 ) ) ."MB" . '<br>';
		    $system_info .= '<br>------------ BIANCO TOOLKIT ------------ ' . '<br>';
		    $system_info .= 'Version:                  ' . BIANCO_TOOLKIT_VERSION . '<br>';
		    $updates = get_plugin_updates();
		    $muplugins = get_mu_plugins();
		    if( count( $muplugins ) > 0 ) {
		      $system_info .= '<br>' . '------------ MU PLUGINS ------------ ' .'<br>';

		      foreach( $muplugins as $plugin => $plugin_data ) {
		        $system_info .= $plugin_data['Name'] . ': ' . $plugin_data['Version'] . '<br>';
		      }
		    }
		    $system_info .= '<br><br>------------ WP ACTIVE PLUGINS ------------ ' . '<br>';

		    $plugins = get_plugins();
		    $active_plugins = get_option( 'active_plugins', array() );

		    foreach( $plugins as $plugin_path => $plugin ) {
		      if( !in_array( $plugin_path, $active_plugins ) )
		        continue;

		      $update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
		      $system_info .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . '<br>';
		    }
		    $system_info .= '<br><br>------------ WP INACTIVE PLUGINS ------------ ' . '<br>';

		    foreach( $plugins as $plugin_path => $plugin ) {
		      if( in_array( $plugin_path, $active_plugins ) )
		        continue;

		      $update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
		      $system_info .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . '<br>';
		    }

		    if( is_multisite() ) {
		      $system_info .= '<br><br>------------ NETWORK ACTIVE PLUGINS ------------ ' . '<br>';

		      $plugins = wp_get_active_network_plugins();
		      $active_plugins = get_site_option( 'active_sitewide_plugins', array() );

		      foreach( $plugins as $plugin_path ) {
		        $plugin_base = plugin_basename( $plugin_path );

		        if( !array_key_exists( $plugin_base, $active_plugins ) )
		          continue;

		        $update = ( array_key_exists( $plugin_path, $updates ) ) ? ' (needs update - ' . $updates[$plugin_path]->update->new_version . ')' : '';
		        $plugin  = get_plugin_data( $plugin_path );
		        $system_info .= $plugin['Name'] . ': ' . $plugin['Version'] . $update . '<br>';
		      }
		    }

		    $system_info .= '<br><br>------------ WEBSERVER CONFIGS ------------' . '<br>';
		    $system_info .= 'PHP Version:              ' . PHP_VERSION . '<br>';
		    $system_info .= 'MySQL Version:            ' . $wpdb->db_version() . '<br>';
		    $system_info .= 'Webserver Info:           ' . $_SERVER['SERVER_SOFTWARE'] . '<br>';
		    $system_info .= '<br><br>------------ PHP CONFIGS ------------' . '<br>';
		    $system_info .= 'Memory Limit:             ' . ini_get( 'memory_limit' ) . '<br>';
		    $system_info .= 'Upload Max Size:          ' . ini_get( 'upload_max_filesize' ) . '<br>';
		    $system_info .= 'Post Max Size:            ' . ini_get( 'post_max_size' ) . '<br>';
		    $system_info .= 'Upload Max Filesize:      ' . ini_get( 'upload_max_filesize' ) . '<br>';
		    $system_info .= 'Time Limit:               ' . ini_get( 'max_execution_time' ) . '<br>';
		    $system_info .= 'Max Input Vars:           ' . ini_get( 'max_input_vars' ) . '<br>';
		    $system_info .= 'Display Errors:           ' . ( ini_get( 'display_errors' ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A' ) . '<br>';
		    $system_info .= 'PHP Arg Separator:        ' . ini_get( 'arg_separator.output' ) . '<br>';
		    $system_info .= 'PHP Allow URL File Open:  ' . ini_get( 'allow_url_fopen' ) . '<br>';

		    $system_info .= '<br><br>### End System Info ###';
			?>
            <div class="dashboard-container">
            	<div class="wpp-content">
            		<section>
		            	<div class="ov-thumbnail">
		            		<figure><img src="<?php echo esc_url( $image ); ?>" alt="ovic"></figure>
		            	</div>
		            	<div class="notices">
		            		<h1 class="txt-intro"><?php echo $txt_intro; ?></h1>
		            		<h3 class="about-text">Thanks for using our theme, we have worked very hard to release a great product
		                    and we will do our absolute best to support this theme and fix all the issues. </h3>
		            	</div>
		            </section>

					<section>
						<div class="bianco-tab">
							<ul class="bianco-tabs">
								<li><a href="#"><?php _e('Changelog Info','bianco-toolkit') ?></a></li>
								<li><a href="#"><?php _e('System Info','bianco-toolkit') ?></a></li>
							</ul>

							<div class="bianco-tab_content">

								<div class="bianco-tabs_item">
				            		<div class="src-info">
				            			<?php echo $changelog; ?>
				            		</div>
								</div>

								<div class="bianco-tabs_item">
				            		<div class="src-info">
				            			<p><?php echo $system_info ?></p>
				            		</div>
								</div>
								
							</div>
						</div>
					</section>
					
	            	
            	</div>
            </div>
			<?php
			$this->support();
		}

		private function print_changelog() {
			$THEME_BASE = get_template_directory().'/';
			if( ! is_readable($THEME_BASE."changelog.txt") ) {
				echo '<p>The changelog in readme.txt is not readable.</p>';
				return;
			}

			$html = '';
			$stylelines = explode("\n", implode('', file($THEME_BASE."changelog.txt")));
			$read = false;
			$is_title = false;
			$current_theme = wp_get_theme();
			$theme_ver = $current_theme->version;

			foreach ($stylelines as $line) {
				$is_title = 0 === strpos($line, '*****');
				if ( $is_title ) {
					$html .= sprintf( '<strong>%1$s</strong><br/>', esc_attr( $line ) );
				} else {
					$html .= sprintf( '<i>%1$s</i><br/>', esc_attr( $line ) );
				}
			}

			$changelog = "<p>{$html}</p>";
			return $changelog;
		}

		

		/**
		 * Does Size Conversions
		 */
		private function ovic_let_to_num( $v ) {
		    $l   = substr( $v, -1 );
		    $ret = substr( $v, 0, -1 );

		    switch ( strtoupper( $l ) ) {
		      case 'P': // fall-through
		      case 'T': // fall-through
		      case 'G': // fall-through
		      case 'M': // fall-through
		      case 'K': // fall-through
		        $ret *= 1024;
		        break;
		      default:
		        break;
		    }
		    return $ret;
		}

		public function welcome(){
			$tab = 'dashboard';
			if ( isset( $_GET['tab'] ) ) {
				$tab = $_GET['tab'];
			}
			?>
            <div class="ovic-wrap">
                <div id="tabs-container" role="tabpanel">
                	<?php if(count($this->tabs)): ?>
                		<div class="nav-tab-wrapper">
						<?php foreach ( $this->tabs as $key => $value ): ?>
                            <a class="nav-tab <?php if ( $tab == $key ): ?> nav-tab-active<?php endif; ?>"
                               href="admin.php?page=ovic-dashboard&tab=<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></a>
						<?php endforeach; ?>
	                    </div>
                	<?php endif; ?>
                    <div class="tab-content">
						<?php
						ob_start();
						$this->$tab();
						$content_tab = ob_get_clean();
						$content_tab = apply_filters( 'ovic_dashboard_tab_content', $content_tab, $tab );
						echo $content_tab;
						?>
                    </div>
                </div>
            </div>
			<?php
		}

		public function support(){
			$my_theme = wp_get_theme();
			global $wp_theme_directories;
			if ( empty( $stylesheet ) )
				$stylesheet = get_stylesheet();
			if ( empty( $theme_root ) ) {
				$theme_root = get_raw_theme_root( $stylesheet );
				if ( false === $theme_root )
					$theme_root = WP_CONTENT_DIR . '/themes';
                elseif ( !in_array( $theme_root, (array)$wp_theme_directories ) )
					$theme_root = WP_CONTENT_DIR . $theme_root;
			}
			$file_stylesheet = $theme_root . '/' . $stylesheet . '/style.css';
			$theme_info      = get_file_data( $file_stylesheet, array( 'market' => 'Market' ) );
			$market          = ( isset( $theme_info['market'] ) ) ? $theme_info['market'] : '';
			if ( $market == '' ) {
				$link_doc = '//help.kutethemes.com/docs/' . $my_theme->get( 'TextDomain' );
				$link_sp  = '//kutethemes.com/supports/';
			} else {
				$link_doc = '//' . $my_theme->get( 'TextDomain' ) . '.kutethemes.net/documentation/';
				$link_sp  = '//support.kutethemes.net/support-system';
			}
			if ( $market == 'Templatemonster' )
				return;
			ob_start();
			?>
            <div class="rp-row support-tabs">
                <div class="rp-col">
                    <div class="support-item">
                        <h3><?php esc_html_e( 'Documentation', 'bianco-toolkit' ); ?></h3>
                        <p><?php esc_html_e( 'Here is our user guide for ' . ucfirst( esc_html( $this->theme_name ) ) . ', including basic setup steps, as well as ' . ucfirst( esc_html( $this->theme_name ) ) . ' features and elements for your reference.', 'bianco-toolkit' ); ?></p>
                        <a target="_blank"
                           href="<?php echo esc_url( $link_doc ); ?>"
                           class="button button-primary"><?php esc_html_e( 'Read Documentation', 'bianco-toolkit' ); ?></a>
                    </div>
                </div>
                <div class="rp-col closed">
                    <div class="support-item">
                        <h3><?php esc_html_e( 'Video Tutorials', 'bianco-toolkit' ); ?></h3>
                        <p class="coming-soon"><?php esc_html_e( 'Video tutorials is the great way to show you how to setup ' . ucfirst( esc_html( $this->theme_name ) ) . ' theme, make sure that the feature works as it\'s designed.', 'bianco-toolkit' ); ?></p>
                        <a href="#"
                           class="button button-primary disabled"><?php esc_html_e( 'See Video', 'bianco-toolkit' ); ?></a>
                    </div>
                </div>
                <div class="rp-col">
                    <div class="support-item">
                        <h3><?php esc_html_e( 'Forum', 'bianco-toolkit' ); ?></h3>
                        <p><?php esc_html_e( 'Can\'t find the solution on documentation? We\'re here to help, even on weekend. Just click here to start chatting with us!', 'bianco-toolkit' ); ?></p>
                        <a target="_blank" href="<?php echo esc_url( $link_sp ); ?>"
                           class="button button-primary"><?php esc_html_e( 'Request Support', 'bianco-toolkit' ); ?></a>
                    </div>
                </div>
            </div>
			<?php
			$content = ob_get_clean();
			echo apply_filters( 'ovic_dashboard_support_tab_content', $content );
		}
	}

	new Ovic_Dashboard();
}