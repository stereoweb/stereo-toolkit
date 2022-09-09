jQuery( function($){
    // on upload button click
	$( 'body' ).on( 'click', '.stereo-upload', function( event ){
		event.preventDefault();

		const button = $(this);
        const removebtn = button.parent().find('.stereo-remove-fb-image');
        const img = button.parent().find('img');
        const input = button.parent().find('input');
		const imageId = input.val();

		const custom_uploader = wp.media({
			title: 'Insert image',
			library : {
				type : 'image'
			},
			button: {
				text: 'Use this image'
			},
			multiple: false
		}).on( 'select', function() {
			const attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
            img.attr('src', attachment.url);
            img.css('display', 'block');
            button.css('display', 'none');
            input.val( attachment.id );
            removebtn.css('display', 'block');
            updateMeta(input.attr('name'), attachment.id, input.closest('tr').attr('data-id'));
		})

		// already selected images
		custom_uploader.on( 'open', function() {
			if( imageId ) {
			  const selection = custom_uploader.state().get( 'selection' )
			  attachment = wp.media.attachment( imageId );
			  attachment.fetch();
			  selection.add( attachment ? [attachment] : [] );
			}
		})

		custom_uploader.open()

	});
	// on remove button click
	$( 'body' ).on( 'click', '.stereo-remove-fb-image', function( event ){
		event.preventDefault();
		const button = $(this);
        const input = button.parent().find('input');
		input.val( '' );
		button.parent().find('.stereo-upload').css('display', 'inline-block');
		button.css('display', 'none');
        button.parent().find('img').css('display', 'none');
        updateMeta(input.attr('name'), '', input.closest('tr').attr('data-id'));
	});

    $('body').on('change', '.stereo-form-meta-seo input, .stereo-form-meta-seo textarea', function(event){
        event.preventDefault();
        updateMeta($(this).attr('name'), $(this).val(), $(this).closest('tr').attr('data-id'));
    });

	$('.stereo-form-meta-seo input, .stereo-form-meta-seo textarea').keyup(function(event){
		const value = $(this).val();
		$(this).parent().find('.count').html('count: '+value.length);
	});

    const updateMeta = function( meta, value, post_id ) {
        const button = $(this);
        const data = {
            'action': 'stereo_update_meta',
            'meta': meta,
            'value': value,
            'post_id': post_id
        };
        $.post(ajaxurl, data, function(response) {
            console.log(response);
        });
    }
});