
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    var backgroundPath = "/assets/1-7b6f79fe844a46987bdbecf6f1756f57c2fb28565ccfe609bec5fda1dc76e43e.jpg" || null;
    $.backstretch(backgroundPath);
    
    /*
        Form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    
    
});
