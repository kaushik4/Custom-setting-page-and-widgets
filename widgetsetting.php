<?php
// Settings Page: WidgetSetting

class WidgetSetting_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wps_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wps_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wps_setup_fields' ) );
               
		//add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
	}

	public function wps_create_settings() {
		$page_title = 'WP Setting & Widget Page';
		$menu_title = 'Widget Setting';
		$capability = 'manage_options';
		$slug = 'WidgetSetting';
		$callback = array($this, 'wps_settings_content');
                $icon = 'dashicons-admin-generic';
		$position = 2;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
		
	}
    
	public function wps_settings_content() { ?>
		<div class="wrap">
			<h1>Widget Setting</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'WidgetSetting' );
					do_settings_sections( 'WidgetSetting' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function wps_setup_sections() {
		add_settings_section( 'WidgetSetting_section', '', array(), 'WidgetSetting' );
	}

	public function wps_setup_fields() {
		$fields = array(
                    array(
                        'section' => 'WidgetSetting_section',
                        'label' => 'Title:',
                        'id' => 'wsp_title',
                        'desc' => 'Enter Title',
                        'type' => 'text',
                    ),
        
                    array(
                        'section' => 'WidgetSetting_section',
                        'label' => 'Description:',
                        'id' => 'wsp_description',
                        'desc' => 'Enter a description',
                        'type' => 'textarea',
                    ),
					
					 array(
                        'section' => 'WidgetSetting_section',
                        'label' => 'Eidtors',
                        'id' => 'wsp_eidtors',
						'desc' => 'Enter Editor Content',
                        'type' => 'wysiwyg',
                    ),
                    array(
                        'section' => 'WidgetSetting_section',
                        'label' => 'Date:',
                        'id' => 'wsp_date',
                        'desc' => 'Enter a date',
                        'type' => 'date',
                    ),
        
                    array(
                        'section' => 'WidgetSetting_section',
                        'label' => 'Image:',
                        'id' => 'wsp_media',
                        'desc' => 'choose image',
                        'type' => 'file',
                        'returnvalue' => 'url'
                    ),
        
                    array(
                        'section' => 'WidgetSetting_section',
                        'label' => 'Color Picker:',
                        'id' => 'wsp_color',
                        'desc' => 'choose color',
                        'type' => 'color',
						
                    )
		);
		foreach( $fields as $field ){
			////echo '<pre>';
			//	print_r($field);
			add_settings_field( $field['id'], $field['label'], array( $this, 'wps_field_callback' ), 'WidgetSetting', $field['section'], $field );
			register_setting( 'WidgetSetting', $field['id'] );
		}
	}
	public function wps_field_callback( $field ) {
		$value = get_option( $field['id'] );
		print_r($value);
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
            
                        case 'media':
                            $field_url = '';
                            if ($value) {
                                if ($field['returnvalue'] == 'url') {
                                    $field_url = $value;
                                } else {
                                    $field_url = wp_get_attachment_url($value);
                                }
                            }
                        
                            break;

            
                        case 'wysiwyg':
						//print_r($value);
						$wsp_eidtors = get_option( 'wsp_eidtors' );
							wp_editor( $wsp_eidtors , strtolower($field['id']),$settings = array('textarea_name'=>'wsp_eidtors','textarea_rows'=>'5') );
                            break;

                        case 'textarea':
                            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
                                $field['id'],
                                $placeholder,
                                $value
                                );
                                break;
            
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
    
    
    
}
new WidgetSetting_Settings_Page();
                