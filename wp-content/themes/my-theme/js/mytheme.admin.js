jQuery( document ).ready( function( $ ) {
    let mediaUploader;

    $( '#upload-button' ).on( 'click', e => {
        e.preventDefault();

        if ( mediaUploader ) {
            mediaUploader.open();
            return;    
        }

        mediaUploader = wp.media.frames.file_frame = wp.media( {
            title: 'Choose profile picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        } );

        mediaUploader.on( 'select', () => {
            const attachment = mediaUploader.state().get( 'selection' ).first().toJSON();
            $( '#profile-picture' ).val( attachment.url );
            $( '#profile-picture-preview' ).css( 'background-image', 'url(' + attachment.url + ')' );
        } );

        mediaUploader.open();

    } );


    $( '#remove-picture' ).on( 'click', e => {
        e.preventDefault();
        
        let remove = confirm( 'Delete profile picture?' );
        if ( remove ) {
            $( '#profile-picture' ).val( '' );
            $( '.mytheme-general-form' ).submit();
        }

         return;

    } );


} );