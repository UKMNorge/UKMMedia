// FILTRER INNSLAGSLISTEN
jQuery(document).ready(function(){
	jQuery('#filter_delta').fastLiveFilter('#deltabrukere', 
		{
			callback: function(total, id) { 
				if( 0 == total ) {
					jQuery('#deltabrukere_none').fadeIn();
				} else {
					jQuery('#deltabrukere_none').fadeOut();
				}
			}
		});

	jQuery('#filter_wp').fastLiveFilter('#wpbrukere', 
		{
			callback: function(total, id) { 
				if( 0 == total ) {
					jQuery('#deltabrukere_none').fadeIn();
				} else {
					jQuery('#deltabrukere_none').fadeOut();
				}
			}
		});

});


jQuery(document).on('click', '.selectUser', function(e){
	var liste = jQuery('#'+ jQuery(this).parents('ol').attr('data-target') );
	
	liste.find('.navn').html('Valgt: '+  jQuery(this).html() );
	liste.find('.id').val( jQuery(this).attr('data-id') );
	
	liste.find('.sok').slideUp();
	liste.find('.reset').fadeIn();
});

jQuery(document).on('click', '.users .reset', function(){
	var liste = jQuery(this).parents('div.users');
	
	liste.find('.reset').hide();
	liste.find('.sok').slideDown();
});
