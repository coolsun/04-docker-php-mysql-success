(function($){
	
	$.confirm = function(params){
		
		if( $('#confirmOverlay').length || $('#confirmBox').length ){
			// A confirm is already shown on the page:
			return false;
		}
		
		var buttonHTML = '';
		$.each(params.buttons,function(name,obj){
			
			// Generating the markup for the buttons:
			
			buttonHTML += '<a href="#" class="button '+obj['class']+'">'+name+'<span></span></a>';
			
			if(!obj.action){
				obj.action = function(){};
			}
		});

		params.maskdivhead = '<div id="confirmOverlay">';
		params.maskdivtail = '</div>';
		if( params.unmask ) {
			params.maskdivhead = '';
			params.maskdivtail = '';
		}

		if( params.content ) {
			//params.content = '<div>'+params.content+'</div>';
		}
		else {
			params.content = '';
		}

		if( params.width ) {
			params.width = 'width:'+params.width+'px;';
		}
		else {
			params.width = '';
		}

		if( params.offset ) {
			if( params.position ) {
				params.offset = 'position:'+params.position+'; left:'+params.offset+'px;';
				if( params.voffset ) {
					params.offset += ' top:'+params.voffset+'px;';
				}
			}
			else {
				params.offset = 'margin-left:'+params.offset+'px;';
				if( params.voffset ) {
					params.offset += ' margin-bottom:'+params.voffset+'px;';
				}
			}
		}
		else {
			params.offset = '';
		}		

		var closeButton = '<a href="javascript:;" onClick=" $.confirm.hide(); " class="closex" style="vertical-align: top; float: right;"></a>';
		if( params.closeAction ) {
			closeButton = '<a href="javascript:;" onClick=" $.confirm.hide('+params.closeAction+'); " class="closex" style="vertical-align: top; float: right;"></a>';
		}

		if( params.buttonDivCss ) {
			
		}
		else {
			params.buttonDivCss = '';
		}

		if( params.messageIcon ) {
			params.messageIcon = '<img class="confirmBox-icon" src="'+params.messageIcon+'"/>';
		}
		else {
			params.messageIcon = '';
		}
		
		var markup = '';
		if( params.buttons == false ) {
			markup = [
				params.maskdivhead,
				'<div id="confirmBox" style="',params.width,' ',params.offset,'">',
				//'<h1>',params.title,'</h1>',
				'<div style="text-align: left;">',
					params.title,
	                '<a href="javascript:;" onClick=" $.confirm.hide(); " class="closex" style="vertical-align: top; float: right;"></a>',
	            '</div>',
				'<div class="confirmBox-cotent" style="padding: 0px;">',
					params.content,
				'</div>',
				params.maskdivtail
			].join('');

		}
		else {
			markup = [
				params.maskdivhead,
				'<div id="confirmBox" style="',params.width,' ',params.offset,'">',
				//'<h1>',params.title,'</h1>',
				'<div style="text-align: left;">',
					params.title,
	                closeButton,
	            '</div>',
				'<div class="confirmBox-cotent">',
					params.content,
				    params.messageIcon,
				    '<div class="confirmBox-message">',params.message,'</div>',
				'<div id="confirmButtons" style="',params.buttonDivCss,'">',
				buttonHTML,
				'</div>',
				'</div></div>',
				params.maskdivtail
			].join('');
		}

		
		if( params.loadAction ) {
			$(markup).hide().appendTo('body').fadeIn( 100, params.loadAction() );
		}	
		else {
			$(markup).hide().appendTo('body').fadeIn( 100 );
		}
		
		var buttons = $('#confirmBox .button'),
			i = 0;

		$.each(params.buttons,function(name,obj){
			buttons.eq(i++).click(function(){
				
				// Calling the action attribute when a
				// click occurs, and hiding the confirm.
				
				var hideConfirm = true;
				hideConfirm = obj.action();
				if( hideConfirm ) {
					if( obj.nextAction ) {
						$.confirm.hide( obj.nextAction );	
					}
					else {
						$.confirm.hide();
					}
				}
				return false;
			});
		});

		//$(window).on('resize', function() {  $.confirm.hide(); });
		//$('#confirmOverlay').on('click', function() { $.confirm.hide(); } );
	}

	$.confirm.hide = function( action ){
		$('#confirmOverlay').fadeOut(function(){
			$(this).remove();
			if( action ) { action(); }
		});
		$('#confirmBox').fadeOut(function(){
			$(this).remove();
			if( action ) { action(); }
		});
	}
	
})(jQuery);