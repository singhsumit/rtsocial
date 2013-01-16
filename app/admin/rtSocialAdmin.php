<?php
/**
 * Description of rtSocialAdmin
 *
 * @author Ankit Gade <ankit.gade@rtcamp.com>
 */
if (!class_exists('rtSocialAdmin')) {

    class rtSocialAdmin{

        public $rtSocial_upgrade;
        public $rtSocial_settings;
        public $rtSocial_options;
        
        public $default_buttons = array(
		array(
			'type' => 'fb-share',
			'callback' => 'facebook.com/sharer.php',
			'post_obj' => null,
			'query' => array(
				'href' => '%permalink%'
			),
			'prefix' => 'share',
			'suffix' => 'on facebook',
			'network' => 'facebook'
		),
		array(
			'type' => 'twitter',
			'callback' => 'twitter.com/share',
			'post_obj' => null,
			'query' => array(
				'url' => '%permalink%',
				'text' => '%title%',
				'via' => '',
				'related' => '',
				'hashtags' => '%rt_s_tw_hashtag%'
			),
			'prefix' => 'Tweet',
			'suffix' => '',
			'network' => 'twitter'
		),
		array(
			'type' => 'linked-in',
			'callback' => 'linkedin.com/shareArticle',
			'post_obj' => null,
			'query' => array(
				'mini' => true,
				'url' => '%permalink%',
				'title' => '%title%',
				'summary' => '%excerpt'
			),
			'prefix' => 'Share',
			'suffix' => 'on Linked In',
			'network' => 'linked in'
		),
		array(
			'type' => 'google',
			'callback' => 'plus.google.com/share',
			'post_obj' => null,
			'query' => array(
				'url' => '%permalink%'
			),
			'prefix' => 'Plus 1',
			'suffix' => 'on Google+',
			'network' => 'google +'
		),
		array(
			'type' => 'pinterest',
			'callback' => 'pinterest.com/pin/create/button/',
			'post_obj' => null,
			'query' => array(
				'url' => '%permalink%',
				'media' => '%thumb%',
				'description' => '%title%'
			),
			'prefix' => 'Pin',
			'suffix' => 'on your Pinterest Board',
			'network' => 'pinterest'
		)
	);

        public function __construct() {

            if (is_admin()) {

                add_action( 'admin_enqueue_scripts', array($this, 'ui') );
                add_action( 'admin_menu', array($this, 'menu') );
            }
            $this->rtSocial_settings = new RTSocialSettings();
        }

        /**
         * Generates the Admin UI
         *
         * @param string $hook
         */
        public function ui($hook) {
            $admin_ajax = admin_url('admin-ajax.php');
            wp_enqueue_script('rtsocial-admin', RTSOCIAL_URL . 'app/assets/js/admin.js');
            wp_localize_script('rtsocial-admin', 'rtsocial_admin_ajax', $admin_ajax);
            wp_enqueue_style('rtsocial-admin', RTSOCIAL_URL . 'app/assets/css/admin.css');
        }

        /**
         * Admin Menu
         *
         * @global string RTSOCIAL_TXT_DOMAIN
         */
        public function menu() {

            add_options_page('RTSocial', 'RTSocial Setting', 'manage_options', 'rtsocial-revised-options', array( $this, 'settings_page' ) );
        }

        /**
         * Render the BuddyPress Media Settings page
         */
        public function settings_page() {
            $this->render_page('rtsocial-revised-options', true);
        }

        /**
         * Renders the setting page
         */
        public function render_page($page){ ?>

            <h2><?php _e( 'RTSocial Options', RTSOCIAL_TXT_DOMAIN ); ?></h2>
            <div class="wrap rtsocial-admin">
                <div title="Click to toggle" class="handlediv"><br></div>                
                <form method="post" action="options.php" name="rtsocial_setting_form" id="rtsocial_setting_form"><?php
                    settings_fields( 'rtsocial_settings' );
                    do_settings_sections( $page );
                    submit_button(); ?>
                </form>
            </div><?php
        }
    }
} ?>