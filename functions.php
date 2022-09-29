<?php
    
    function wpfollow_theme_support (){

        add_theme_support('title-tag'); //membuat title dinamis
        add_theme_support('custom-logo');
        add_theme_support('post-thumbnails');

    }
    add_action('after_setup_theme', 'wpfollow_theme_support');
    
    function wpfollow_menus(){

        $locations = array (
            'primary' => "Desktop Primary Left Sidebar",
            'footer' => "Footer Menu Items"
        );
        register_nav_menus($locations);
    }
    add_action('init','wpfollow_menus');
    
    function wpfollow_register_styles (){

        $version = wp_get_theme()->get( 'Version' );
        wp_enqueue_style('wpfollow-style',get_template_directory_uri() . "/style.css", array('wpfollow-bootstrap'),$version, 'all');
        wp_enqueue_style('wpfollow-bootstrap',"https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(),'4.4.1', 'all');
        wp_enqueue_style('wpfollow-fontawesome',"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(),'5.13.0', 'all');

    }
    add_action( 'wp_enqueue_scripts','wpfollow_register_styles');

    function wpfollow_register_scripts (){

        wp_enqueue_script('wpfollow-jquery','https://code.jquery.com/jquery-3.4.1.slim.min.js',array(),'3.4.1',true);
        wp_enqueue_script('wpfollow-popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',array(),'1.16.0',true);
        wp_enqueue_script('wpfollow-bootsrtap','https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js',array(),'4.4.1',true);
        wp_enqueue_script('wpfollow-main',get_template_directory_uri()."/assets/js/main.js", array(),'1.0',true);

    }
    add_action( 'wp_enqueue_scripts','wpfollow_register_scripts');

    function wpfollow_widget_areas(){

        register_sidebar(
            array(
                'before_title' => '',
                'after_title' => '',
                'before_widget' => '',
                'after_widget' => '',
                'name' => 'Sidebar Area',
                'id' => 'sidebar-1',
                'description' => 'Sidebar Widget Area'
            )
        );

        register_sidebar(
            array(
                'before_title' => '',
                'after_title' => '',
                'before_widget' => '',
                'after_widget' => '',
                'name' => 'Footer Area',
                'id' => 'footer-1',
                'description' => 'Footer Widget Area'
            )
        );
    }

    add_action('widgets_init','wpfollow_widget_areas');

    if ( ! class_exists( 'WPB_Comment_Author_Role_Label' ) ) :
        class WPB_Comment_Author_Role_Label {
        public function __construct() {
        add_filter( 'get_comment_author', array( $this, 'wpb_get_comment_author_role' ), 10, 3 );
        add_filter( 'get_comment_author_link', array( $this, 'wpb_comment_author_role' ) );
        }
          
        // Get comment author role 
        function wpb_get_comment_author_role($author, $comment_id, $comment) { 
        $authoremail = get_comment_author_email( $comment); 
        // Check if user is registered
        if (email_exists($authoremail)) {
        $commet_user_role = get_user_by( 'email', $authoremail );
        $comment_user_role = $commet_user_role->roles[0];
        // HTML output to add next to comment author name
        $this->comment_user_role = ' <span class="comment-author-label comment-author-label-'.$comment_user_role.'">' . ucfirst($comment_user_role) . '</span>';
        } else { 
        $this->comment_user_role = '';
        } 
        return $author;
        } 
          
        // Display comment author                   
        function wpb_comment_author_role($author) { 
        return $author .= $this->comment_user_role; 
        } 
        }
        new WPB_Comment_Author_Role_Label;
        endif;
?>