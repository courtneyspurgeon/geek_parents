// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.xtmedia', {

        init : function(ed, url) {
            // Not used currently
		},
		// creates control instances based on the control's id.
		// our button's id is "xtmedia_button"
		createControl : function(id, controlManager) {
			if (id == 'xtmedia_button') {
				// creates the button
				var button = controlManager.createButton('xtmedia_button', {
					title : 'Insert Media', // title of the button
                    // TODO Don't hard-link
					image : jQuery('#dlearn_cwd').text() + '/youtube.png',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Insert External Media', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=xtmedia-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('xtmedia', tinymce.plugins.xtmedia);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="xtmedia-form"><table id="xtmedia-table" class="form-table">\
			<tr>\
				<th><label for="xtmedia-url">Video Url</label></th>\
				<td><input type="text" id="xtmedia-url" name="url" /><br />\
				<small>specify the url to embed.</small></td>\
			</tr>\
			<tr>\
				<th><label for="xtmedia-width">Video Width</label></th>\
				<td><input type="text" name="width" id="xtmedia-width" value="480" /><br />\
			</tr>\
			<tr>\
				<th><label for="xtmedia-height">Video Height</label></th>\
				<td><input type="text" name="height" id="xtmedia-height" value="385" /><br />\
			</tr>\
		</table>\
        <p>Tip: The recommended minimum size is 480x385 for a 4:3 video and 640x385 for 16:9 content.</p>\
		<p class="submit">\
			<input type="button" id="xtmedia-submit" class="button-primary" value="Insert Media" name="submit" />\
		</p>\
		</div>');
		
		var table = form.find('table');
		form.appendTo('body').hide();
		
		// handles the click event of the submit button
		form.find('#xtmedia-submit').click(function(){
            // Pull the url from the form
			var shortcode = "[embed width="+jQuery('#xtmedia-width').val()+" height="+ jQuery('#xtmedia-height').val()+ " ]" + jQuery('#xtmedia-url').val() + "[/embed]";
			
			// inserts the value into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()
