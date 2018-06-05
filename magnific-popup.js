/** ref: http://dimsemenov.com/plugins/magnific-popup/ */
jQuery(document).ready(function ($) {
	if (typeof site !== 'undefined') {
		small = '<small>'+site.name+' - '+site.description+'</small>';
	}
	$('.lightbox-gallery').each(function() { // the containers for all your galleries
	    $(this).magnificPopup({
	        delegate: 'a.lightbox', // the selector for gallery item
	        type: 'image',
	        gallery: {
	          enabled:true
	        },
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title') + small;
				}
			}        
	    });
	});	
});