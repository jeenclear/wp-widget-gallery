jQuery ( function() 
    { 
		var $params = jQuery;
		var $scripts = ajax_script.ajax_url;
		  
		/**
        * wp media upload javascript function
        **/

        function media_uploader_add ( $metabox, $inputbox ) 
          {

              var $frame,
                  $meta = $metabox,
                  $input= $inputbox;
              
              if ( $frame ) 
              {
                  $frame.open(); 
                  return;
              }

              $frame = wp.media( 
                  {
                      title: 'Select or Upload Media Of Your Chosen Persuasion',
                      button: {
                        text: 'Use this media'
                      },
                      multiple: false
                  }
              );

              $frame.on( 'select', function() 
                  {
                      var $attachment = $frame.state().get('selection').first().toJSON();
                      // $imgContainer.append( '<img src="'+$attachment.url+'" alt="" style="" />' );

                      $input.val( $attachment.url );
                  }
              );

              $frame.open();
          }

        /**
        * wp media upload javascript function - END
        **/
		
		$params( "a#upload-img" ).on( 'click', function(e) 
            {
                media_uploader_add( '', '.form-uploadimage__wrap #images-input' );
            }
        );
		
		$params( "a#remove-img" ).on( 'click', function(e) 
            {
               $params(this).next().attr( 'src','' );
            }
        );
    }
);

