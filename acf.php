<?php
add_action('init',function() {
	if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
			'key' => 'group_5e8337e85e2d8',
			'title' => 'Redirection',
			'fields' => array(
				array(
					'key' => 'field_5e8337fe8d7b111',
					'label' => 'Fichier CSV',
					'name' => 'stereo_redirect_csv',
					'type' => 'file',
					'instructions' => 'Colonne #1 : Ancienne URL<br>Colonne #2 : Nouvelle URL.<br><br> Ne pas inclure de nom de domaine, toujours débuter par /, par exemple, si votre ancienne url était : https://exemple.com/service <br>Entrez seulement : /service',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'field_5e8337fe8d7b7',
					'label' => 'Redirection',
					'name' => 'stereo_redirection',
					'type' => 'repeater',
					'instructions' => 'Ne pas inclure de nom de domaine, toujours débuter par /, par exemple, si votre ancienne url était : https://exemple.com/service <br>Entrez seulement : /service',
					'required' => 0,
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
                            'key' => 'field_5c18f8ba9942b',
                            'label' => 'Ancienne page',
                            'name' => 'stereo_old_url',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                        array(
                            'key' => 'field_5c18f8ba9941d',
                            'label' => 'Nouvelle page',
                            'name' => 'stereo_new_url',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'id'
                        ),

                    ),
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-stereo-toolkit',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'field',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
        ));

        acf_add_local_field_group(array(
			'key' => 'group_5e8337e85e2ee',
			'title' => 'Site Tags',
			'fields' => array(

				array(
					'key' => 'field_5e8337fe8daaa',
					'label' => 'Tags',
					'name' => 'stereo_sitetags',
					'type' => 'repeater',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
                    'layout' => 'table',
                    'button_label' => 'Ajouter un tag',
                    'sub_fields' => array(
						array(
                            'key' => 'field_5c18f8ba99bbb',
                            'label' => 'Endroit',
                            'name' => 'stereo_location',
                            'type' => 'select',
                            'instructions' => '',
                            'required' => 1,
							'allow_null' => 0,
							'multiple' => 0,
                            'conditional_logic' => 0,
							'choices' => array(
								'head'	=> 'Head',
								'body'	=> 'Body',
								'footer'	=> 'Footer',
							),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                        ),
                        array(
                            'key' => 'field_5c18f8baabcde',
                            'label' => 'Tag/Script',
                            'name' => 'stereo_tag',
                            'type' => 'textarea',
                            'instructions' => '',
                            'required' => 1,
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
						'value' => 'acf-options-stereo-toolkit',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'left',
			'instruction_placement' => 'field',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
        ));
    endif;
});
