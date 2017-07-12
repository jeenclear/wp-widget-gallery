<?php if( !class_exists( 'config' ) ) 
{    
    class config 
    {
         public static $name        = "Widget Gallery";
         public static $icon        = "widget-gallery/assets/images/Tools_-_common_fixed-14-16.png";
         public static $plugin_slug = 'widget-gallery';
         public static $folder      = 'widget-gallery';
         public static $shortcode   = 'widget-gallery';
         public static $assets      = 'assets';
         
         protected $values          = array();
        
         function __construct() 
         {
                global $wpdb;
                
                add::action_page( array( $this, 'admin_page' ) );
                
                /** backend style ( admin ) **/
                 
                add::style( true, self::$plugin_slug.__( 'admin-style', 'wp-mvc' ), self::$folder.'/'.self::$assets.'/css/admin.css' );
                
                
                /** frontend style ( front ) **/
                
                add::style( false, self::$plugin_slug.__( 'front-style', 'wp-mvc' ), self::$folder.'/'.self::$assets.'/css/front.css' );
                
                /** backend script **/
                
                add::wp_script( 'jquery' );
                add::wp_script( 'jquery-ui-sortable' );
                add::wp_script( 'jquery-ui-draggable' );
                add::wp_script( 'jquery-ui-droppable' );
                
                add::wp_script( 'jquery-ui-core' );
                add::wp_script( 'jquery-ui-dialog' );
                add::wp_script( 'jquery-ui-slider' );
                
                add::script( true, self::$plugin_slug.'admin-script', self::$folder.'/'.self::$assets.'/js/admin.js' );
                add::script( true, self::$plugin_slug.'sort-script', self::$folder.'/'.self::$assets.'/js/sort.js' );
                
                add::script( true, self::$plugin_slug.'ajax_handler', self::$folder.'/'.self::$assets.'/js/ajax.js' );
                add::localize_script( true, self::$plugin_slug.'ajax_handler', 'ajax_script', self::get_localize_script_arrays() );
				add::admin_scripts( array( $this, 'admin_scripts_handler' ) );
                
                /** frontend script  **/
                
                add::script( false, self::$plugin_slug.'front-script', self::$folder.'/'.self::$assets.'/js/front.js' );
                
                /** actions option ( callback ) **/
                
                add::action_loaded( array( $this,'update_db_check' ) );
                
                /** actions shortcode ( callback ) **/
                
                add::shortcode( self::$shortcode.'_shortcode_page', array( $this, self::$shortcode.'_shortcode' ) ); 
                
                /** actions ajax actions ( callback ) **/
              
                add::action_ajax( array( $this, 'ajaxs_functions' ) ); 

                /** actions widget ( create ) **/
                
                add::widget_init( array( $this, 'register_widgets_function' ) );
         }
		 
		 public function admin_scripts_handler ( ) 
         {
                add::wp_media( true );   
         }
         
         public static function get_localize_script_arrays () 
         {
                return array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'admin_url' => admin_url(), '' => '' );   
         }
         
         public static function install () 
         {
                global $wpdb;
                
                $prefix = $wpdb->prefix;
                    
                $charset_collate = $wpdb->get_charset_collate();
                    
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                
                $sql_1 = "CREATE TABLE recipes (
				  recipe_id INT NOT NULL,
				  recipe_name VARCHAR(30) NOT NULL,
				  PRIMARY KEY (recipe_id),
				  UNIQUE (recipe_name)
				);

				INSERT INTO recipes 
					(recipe_id, recipe_name) 
				VALUES 
					(1,'Tacos'),
					(2,'Tomato Soup'),
					(3,'Grilled Cheese');"; 
                
                $sqls = array( $sql_1 );
                
                
                if( isset( $sqls ) and is_array( $sqls ) ) foreach( $sqls as $sql ) : 
                        
                dbDelta( $sql ); endforeach;
                
         }

         /**
            WP register widgtet
         **/
         
         function register_widgets_function () 
         {
            register_widget( 'Add_Widget' );
         }
    }    
    
}
?>