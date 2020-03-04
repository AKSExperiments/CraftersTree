<?php
if ( !class_exists( 'Ovic_Mailchimp' ) ) {
	class Ovic_Mailchimp
	{
		public         $key     = '_ovic_mailchimp_settings';
		public         $options = array();
		private static $instance;

		public static function instance()
		{
			if ( !isset( self::$instance ) && !( self::$instance instanceof Ovic_Mailchimp ) ) {
				self::$instance = new Ovic_Mailchimp;
			}
			self::includes();
			add_action( 'wp_enqueue_scripts', array( self::$instance, 'scripts' ) );
			add_filter( 'ovic_registered_settings', array( self::$instance, 'add_options' ), 10, 1 );
			add_action( 'wp_ajax_submit_mailchimp_via_ajax', array( self::$instance, 'submit_mailchimp_via_ajax' ) );
			add_action( 'wp_ajax_nopriv_submit_mailchimp_via_ajax', array( self::$instance, 'submit_mailchimp_via_ajax' ) );
			add_shortcode( "ovic_mailchimp", array( self::$instance, 'mailchimp_shortcode' ) );

			return self::$instance;
		}

		public function __construct()
		{
			$this->options = get_option( $this->key );
		}

		public static function includes()
		{
			include_once( 'MCAPI.class.php' );
		}

		public function scripts()
		{
			wp_register_script( 'ovic-mailchimp', BIANCO_TOOLKIT_PLUGIN_URL . '/includes/extends/mailchimp/mailchimp.min.js', array( 'jquery' ), '1.0', true );
			wp_localize_script( 'ovic-mailchimp', 'ovic_mailchimp', array(
					'ajaxurl'  => admin_url( 'admin-ajax.php' ),
					'security' => wp_create_nonce( 'ovic_mailchimp' ),
				)
			);
		}

		public function submit_mailchimp_via_ajax()
		{
			if ( !class_exists( 'OVIC_MCAPI' ) ) {
				include_once( 'MCAPI.class.php' );
			}
			$response        = array(
				'html'    => '',
				'message' => '',
				'success' => 'no',
			);
			$email           = isset( $_POST['email'] ) ? $_POST['email'] : '';
			$list_id         = isset( $_POST['list_id'] ) ? $_POST['list_id'] : '';
			$fname           = isset( $_POST['fname'] ) ? $_POST['fname'] : '';
			$lname           = isset( $_POST['lname'] ) ? $_POST['lname'] : '';
			$api_key         = "";
			$success_message = esc_html__( 'Your email added...', 'bianco-toolkit' );
			if ( $this->options ) {
				$api_key = isset( $this->options['api_key'] ) ? $this->options['api_key'] : '';
				if ( isset( $this->options['success_message'] ) && $this->options['success_message'] != "" ) {
					$success_message = $this->options['success_message'];
				}
			}
			if ( $list_id == '' && $this->options ) {
				$list_id = $this->options['email_lists'];
			}
			$response['message'] = esc_html__( 'Failed', 'bianco-toolkit' );
			$merge_vars          = array(
				'FNAME' => $fname,
				'LNAME' => $lname,
			);
			if ( class_exists( 'OVIC_MCAPI' ) ) {
				$api = new OVIC_MCAPI( $api_key );
				if ( $api->subscribe( $list_id, $email, $merge_vars ) === true ) {
					$response['message'] = sanitize_text_field( $success_message );
					$response['success'] = 'yes';
				} else {
					// Sending failed
					$response['message'] = $api->get_error_message();
				}
			}
			wp_send_json( $response );
			die();
		}

		public function add_options( $options )
		{
			if ( isset( $options['extends_options']['sections'] ) ) {
				$options['extends_options']['sections'][$this->key] = array(
					'id'     => $this->key,
					'title'  => __( 'Mailchimp', 'bianco-toolkit' ),
					'fields' => array(
						array(
							'name'    => __( 'Mail Chimp API Key', 'bianco-toolkit' ),
							'desc'    => sprintf( wp_kses( __( 'Enter your mail Chimp API key to enable a newsletter signup option with the registration form.<a href="%s" target="_blank">Click here to get your Mailchimp API key</a>', 'bianco-toolkit' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ), 'https://admin.mailchimp.com/account/api' ),
							'default' => '',
							'id'      => 'api_key',
							'type'    => 'text',
						),
					),
				);
			}
			$lists                                                          = $this->get_email_lists_options();
			$options['extends_options']['sections'][$this->key]['fields'][] = array(
				'name'             => __( 'Email Lists', 'bianco-toolkit' ),
				'desc'             => 'Select an option',
				'id'               => 'email_lists',
				'type'             => 'select',
				'show_option_none' => true,
				'default'          => 'custom',
				'options'          => $lists,
			);
			$options['extends_options']['sections'][$this->key]['fields'][] = array(
				'name'    => __( 'Success message', 'bianco-toolkit' ),
				'default' => __( 'Thanks for Subscribe !', 'bianco-toolkit' ),
				'id'      => 'success_message',
				'type'    => 'text',
			);
			return $options;
		}

		public function email_lists_callback()
		{
			$options = $this->options;
			$lists   = array();
			$api_key = isset( $options['api_key'] ) ? $options['api_key'] : '';
			if ( isset ( $api_key ) && !empty ( $api_key ) ) {
				$mcapi = new OVIC_MCAPI( $api_key );
				if ( $mcapi->get_lists() )
					$lists = (array)$mcapi->get_lists();
			}

			return $lists;
		}

		public function get_email_lists_options()
		{
			$lists          = $this->email_lists_callback();
			$select_options = array();
			if ( !empty( $lists ) ) {
				foreach ( $lists as $key => $list ) {
					$select_options[$list->id] = $list->name;
				}
			}

			return $select_options;
		}

		public function mailchimp_shortcode( $atts, $content = '' )
		{
			$default = array(
				'show_list'   => 'no',
				'field_name'  => 'no',
				'fname_text'  => 'First Name',
				'lname_text'  => 'Last Name',
				'placeholder' => 'Your email letter',
				'button_text' => 'Subscribe',
			);
			$atts    = shortcode_atts( $default, $atts );
			extract( $atts );
			$list_id       = $this->get_email_lists_options();
			$options       = $this->options;
			$list_selected = isset( $options['email_lists'] ) ? $options['email_lists'] : '';
			$class         = array( 'newsletter-form-wrap' );
			if ( $atts['show_list'] == 'yes' ) {
				$class[] = 'has-list-field';
			}
			if ( $atts['field_name'] == 'yes' ) {
				$class[] = 'has-name-field';
			}
			wp_enqueue_script( 'ovic-mailchimp' );
			ob_start();
			?>
            <div class="<?php echo esc_attr( implode( ' ', $class ) ); ?>">
				<?php if ( $atts['show_list'] == 'yes' && !empty( $list_id ) ): ?>
                    <div class="list">
						<?php foreach ( $list_id as $key => $value ): ?>
                            <label for="<?php echo esc_attr( $key ); ?>">
                                <input <?php if ( $list_selected == $key ): ?> checked="checked"<?php endif; ?>
                                        id="<?php echo esc_attr( $key ); ?>" name="list_id"
                                        value="<?php echo esc_attr( $key ); ?>" type="radio">
                                <span class="text"><?php echo esc_html( $value ); ?></span>
                            </label>
						<?php endforeach; ?>
                    </div>
				<?php endif; ?>
				<?php if ( $atts['field_name'] == 'yes' ): ?>
                    <label class="text-field field-fname">
                        <input class="input-text fname" type="text" name="fname"
                               placeholder="<?php echo esc_html( $atts['fname_text'] ); ?>">
                    </label>
                    <label class="text-field field-lname">
                        <input class="input-text lname" type="text" name="lname"
                               placeholder="<?php echo esc_html( $atts['lname_text'] ); ?>">
                    </label>
				<?php endif; ?>
                <label class="text-field field-email">
                    <input class="input-text email email-newsletter" type="email" name="email"
                           placeholder="<?php echo esc_attr( $atts['placeholder'] ); ?>">
                </label>
                <a href="#"
                   class="button btn-submit submit-newsletter"><?php echo esc_html( $atts['button_text'] ); ?></a>
            </div>
			<?php
			$html = ob_get_clean();

			return apply_filters( 'ovic_output_mailchimp_form', $html, $atts, $list_id, $options );
		}
	}
}
$ovic_mailchimp = new Ovic_Mailchimp();
$ovic_mailchimp::instance();
