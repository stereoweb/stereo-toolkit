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
    endif;
});