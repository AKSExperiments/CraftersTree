<?php
/**
 * Plugin Name: Import Sample Data
 * Plugin URI: https://kutetehemes.com
 * Description: One Click Import Sample Data.
 * Author: Kutethemes
 * Version: 1.0.0
 * Domain Path: /languages
 * Text Domain: import-sample-data
 * Author URI: https://kutetehemes.com/
 */
if( !class_exists('Import_Sample_Data')){
    class Import_Sample_Data{
        /**
         * Variable to hold the initialization state.
         *
         * @var  boolean
         */
        protected static $initialized = false;

        /**
         * Define plugin version.
         *
         * @var  string
         */
        public static $version = '1.0.0';

        /**
         * Define valid class prefix for autoloading.
         *
         * @var  string
         */
        protected static $prefix = 'Import_Sample_Data_';

        public static function initialize() {
            // Do nothing if pluggable functions already initialized.
            if ( self::$initialized ) {
                return;
            }
            self::setup_constants();
            // Register class autoloader.
            spl_autoload_register( array( __CLASS__, 'autoload' ) );

            Import_Sample_Data_Dashboard::initialize();
            Import_Sample_Data_Sample_Data::initialize();

            // State that initialization completed.
            self::$initialized = true;


        }

        public static function setup_constants(){

            // Plugin version.
            if ( !defined( 'IMPORT_SAMPLE_DATA_VERSION' ) ) {
                define( 'IMPORT_SAMPLE_DATA_VERSION', self::$version );
            }
            // Plugin Folder Path.
            if ( !defined( 'IMPORT_SAMPLE_DATA_PLUGIN_DIR' ) ) {
                define( 'IMPORT_SAMPLE_DATA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            }
            // Plugin Folder URL.
            if ( !defined( 'IMPORT_SAMPLE_DATA_PLUGIN_URL' ) ) {
                define( 'IMPORT_SAMPLE_DATA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            }

        }

        public static function autoload( $class_name ){
            // Verify class prefix.
            if ( 0 !== strpos( $class_name, self::$prefix ) ) {
                return false;
            }

            // Generate file path from class name.
            $base = plugin_dir_path(  __FILE__ ) . '/includes/';
            $path = strtolower( str_replace( '_', '/', substr( $class_name, strlen( self::$prefix ) ) ) );

            // Check if class file exists.
            $standard    = $path . '.php';
            $alternative = $path . '/' . current( array_slice( explode( '/', str_replace( '\\', '/', $path ) ), -1 ) ) . '.php';

            while ( true ) {
                // Check if file exists in standard path.
                if ( @is_file( $base . $standard ) ) {
                    $exists = $standard;

                    break;
                }

                // Check if file exists in alternative path.
                if ( @is_file( $base . $alternative ) ) {
                    $exists = $alternative;

                    break;
                }

                // If there is no more alternative file, quit the loop.
                if ( false === strrpos( $standard, '/' ) || 0 === strrpos( $standard, '/' ) ) {
                    break;
                }

                // Generate more alternative files.
                $standard    = preg_replace( '#/([^/]+)$#', '-\\1', $standard );
                $alternative = implode( '/', array_slice( explode( '/', str_replace( '\\', '/', $standard ) ), 0, -1 ) ) . '/' . substr( current( array_slice( explode( '/', str_replace( '\\', '/', $standard ) ), -1 ) ), 0, -4 ) . '/' . current( array_slice( explode( '/', str_replace( '\\', '/', $standard ) ), -1 ) );
            }

            // Include class declaration file if exists.
            if ( isset( $exists ) ) {
                return include_once $base . $exists;
            }

            return false;
        }
    }
}
Import_Sample_Data::initialize();
//require_once 'sample-settings.php';