<?php

if( !class_exists('Sameple_Settings')){
    class Sameple_Settings{

        public function __construct(){

            // Filter Sample Data Menu
            add_filter('import_sample_data_menu_args',array($this,'import_sample_data_menu_args'));
            add_filter('import_sample_data_packages',array($this,'import_sample_data_packages'));
            add_filter('import_sample_data_required_plugins',array($this,'import_sample_data_required_plugins'));
            add_filter('import_sample_data_demo_site_pattern',array($this,'import_sample_data_demo_site_pattern'));
            add_filter('import_sample_data_theme_option_key',array($this,'import_sample_data_theme_option_key'));

            add_action('import_sample_data_after_install_sample_data',array($this,'import_sample_data_after_install_sample_data'),10,1);
        }

        public function import_sample_data_demo_site_pattern( $demo_site_pattern ){

            $demo_site_pattern = 'https?(%3A|:)[%2F\\\\/]+(rc|demo|envy)\.kutethemes\.net';
            return $demo_site_pattern;
        }
        public function import_sample_data_theme_option_key( $theme_option_key){
            $theme_option_key = 'envy';
            return $theme_option_key;
        }

        public function import_sample_data_required_plugins( $plugins ){
            $plugins = array(
                array(
                    'name'               => 'WPBakery Visual Composer', // The plugin name
                    'slug'               => 'js_composer', // The plugin slug (typically the folder name)
                    'source'             => 'https://plugins.kutethemes.net/js_composer.zip', // The plugin source
                    'source_type'        => 'external',
                    'file_path'          => 'js_composer/js_composer.php',
                ),
                array(
                    'name'      => 'Redux Framework',
                    'slug'      => 'redux-framework',
                    'required'  => true,
                    'file_path' =>'redux-framework/redux-framework.php',
                    'source_type'        => 'repo', // Plugins On wordpress.org
                ),
            );
            return $plugins;
        }

        /**
         * Change Menu Sample dataß.
         *
         * @param   array   $uri     Remote URI for fetching content.
         *
         * @return  array
         */
        public function import_sample_data_menu_args( $args ){

            $args = array(
                'parent_slug'   => 'ovic-dashboard',
                'page_title'    => esc_html__('Sample Data','import-sample-data'),
                'menu_title'    => esc_html__('Sample Data','import-sample-data'),
                'capability'    => 'manage_options',
                'menu_slug'     => 'sample-data',
                'function'      => 'Import_Sample_Data_Dashboard::dashboard'
            );

            return $args;
        }

        public function import_sample_data_packages( $packages ){
            return array(
                'main' => array(
                    'id' => 'main',
                    'name' => 'Fashion Demos',
                    'thumbail' =>'https://via.placeholder.com/400x200',
                    'demo' =>'https://envy.kutethemes.net',
                    'download' => 'http://localhost:8888/sample-data/ex-data.zip',
                    'tags' => array('all','simple'),
                    'main' => true,
                    'sample-page' => array(
                        array(
                            'name' => 'Home Creative',
                            'slug' => 'home-creative',
                            'thumbail' =>'https://via.placeholder.com/180x130',
                            'settings' => array(
                                'used_header' => 'style11',
                                'footer_used' => 2934,
                            )
                        ),
                        array(
                            'name' => 'Home Categories #1',
                            'slug' => 'home',
                            'thumbail' =>'https://via.placeholder.com/180x130',
                            'settings' => array(
                                'used_header'      => 'default',
                                'footer_used' => 541,
                            )
                        ),
                    )
                ),
                //and more...
            );
        }

        public function import_sample_data_after_install_sample_data($package){
            // Do something here!
        }
    }
}

new Sameple_Settings();