<?php
add_action('init',function() {
	if( function_exists('acf_add_local_field_group') ):
        acf_add_local_field_group(array(
			'key' => 'group_5e8337e85e2d1',
			'title' => __('Options générale de redirection','stereo-redirection'),
			'fields' => array(
				array(
					'key' => 'field_5e8337fe8d7b9',
					'label' => __('Lien de l\'ancien site','stereo-redirection'),
					'name' => 'stereo_old_link',
					'type' => 'url',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-redirection-stereo',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
        ));

        acf_add_local_field_group(array(
			'key' => 'group_5e8337e85e2d8',
			'title' => __('Redirection','stereo-redirection'),
			'fields' => array(
				array(
					'key' => 'field_5e8337fe8d7b7',
					'label' => __('Redirection','stereo-redirection'),
					'name' => 'stereo_redirection',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
                    'layout' => 'table',
                    'button_label' => 'Ajouter une redirection',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5c18f8ba9941d',
                            'label' => __('Nouvelle page','stereo-redirection'),
                            'name' => 'stereo_new_url',
                            'type' => 'post_object_field',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'id'
                        ),
                        array(
                            'key' => 'field_5c18f8ba9942b',
                            'label' => __('Ancienne page','stereo-redirection'),
                            'name' => 'stereo_new_url',
                            'type' => 'url',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                    ),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-redirection-stereo',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
        ));
    endif;
});