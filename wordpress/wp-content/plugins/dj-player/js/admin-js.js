jQuery(function($) {
	djpr_delete_song();
	$('body').on('click', '#upload_djsong_button', djpr_open_media_window);

	$('.djpr_checkbox input').change(function(){
		if($(this).is(':checked')){
			$('#upload_djsong').attr('value', '');
			$('.djpr-medialink').html('');
			$('#djsong_file_metabox .djpr-medialink').find('#upload_djsong_button').remove();
			$('#djsong_file_metabox .djpr-medialink').append('<input class="button-secondary" id="upload_djsong_button" type="button" value="Upload File" />');
			$('.djpr-medialink').css('display', 'none');
			$('#upload_djsong_external').css('display', 'block');
		}else{
			$('#upload_djsong_external').attr('value', '');
			$('#upload_djsong_external').css('display', 'none');
			$('.djpr-medialink').css('display', 'block');
		}
	});

	function djpr_open_media_window() {
			this.window = wp.media({
				title: 'Add file',
				multiple: false,
				library: {
	                type: 'audio/mpeg, audio/vorbis, application/ogg, audio/basic, audio/x-midi, audio/x-pn-realaudio, audio/vnd.rn-realaudio, audio/x-pn-realaudio, audio/vnd.rn-realaudio'
	            },
				button: {text: 'Insert'}
			});

			var self = this;
			this.window.on('select', function() {
				var first = self.window.state().get('selection').first().toJSON();
				$('#upload_djsong_button').remove();
				$('#upload_djsong').val(first.id);
				$('.djpr-medialink').append('<div class="djpr_fileinfo"></div>');			
				$('.djpr_fileinfo').append('<div class="djpr_fileinfo_cont"></div>');			
				$('.djpr_fileinfo_cont').append('<p><b>File URL:</b> '+ first.url +'</p>');			
				$('.djpr_fileinfo_cont').append('<p><b>File Name:</b> '+ first.name +'</p>');
				$('.djpr_fileinfo_cont').append('<p><b>File Size:</b> '+ first.filesize +'</p>');
				$('.djpr_fileinfo_cont').append('<div class="djpr_fileclose">Delete file</div>');
			});

			this.window.open();
			return false;
	}

	function djpr_delete_song() {
		$('body').on('click', '.djpr_fileclose', function(){
			$('.djpr-medialink').html('');
			$('#djsong_file_metabox .djpr-medialink').find('#upload_djsong_button').remove();
			$('#djsong_file_metabox .djpr-medialink').append('<input class="button-secondary" id="upload_djsong_button" type="button" value="Upload File" />');
		});
	}
});