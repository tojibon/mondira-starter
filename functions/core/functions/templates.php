<?php 
/**
*
* General template function file using by Mondira themes.
*
* @since version 1.0
* @last modified 28 Feb, 2015
* @author Jewel Ahmed<tojibon@gmail.com>
* @author url http://www.codeatomic.com 
*/

if(!function_exists('mondira_get_permalink')) {
    function mondira_get_permalink($link, $default=''){
        if(!empty($link)){
            $link_array = explode('||',$link);
            switch($link_array[0]){
                case 'page':
                    return get_page_link($link_array[1]);
                case 'cat':
                    return get_category_link($link_array[1]);
                case 'post':
                    return get_permalink($link_array[1]);
                case 'portfolio':
                    return get_permalink($link_array[1]);
                case 'manually':
                    return $link_array[1];
            }
        }
        return $default;
    }
}

if(!function_exists('mondira_get_post_templates')) {
    function mondira_get_post_templates()  {
        $themes = wp_get_themes();
        
        $theme = wp_get_theme();
        $templates = $themes[ $theme ][ 'Template Files' ];

        $post_templates = array();

        if ( is_array( $templates ) ) {
            $theme_root = dirname(get_theme_root());
            $base = array( trailingslashit(get_template_directory()), trailingslashit(get_stylesheet_directory()) );

            foreach ( $templates as $template ) {
                // Some setups seem to pass the templates without the theme root,
                // so we conditionally prepend the root for the theme files.
                if ( stripos( $template, $theme_root ) === false )
                    $template = $theme_root . $template;
                $basename = str_replace($base, '', $template);

                // Don't allow template files in subdirectories
                if ( false !== strpos($basename, '/') )
                    continue;

                // Get the file data and collapse it into a single string
                $template_data = implode( '', file( $template ));

                $name = '';
                if ( preg_match( '|Template Name Posts:(.*)$|mi', $template_data, $name ) ){
                    echo $name[1];
                    exit;
                    $name = _cleanup_header_comment( $name[1] );
                }
                    

                if ( !empty( $name ) )
                    $post_templates[trim( $name )] = $basename;
            }
        }

        return $post_templates;
    }  
}    