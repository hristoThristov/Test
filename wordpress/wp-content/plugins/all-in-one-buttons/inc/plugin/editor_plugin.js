/*global ajaxurl:false */
/*global tinymce:false */
(function($) {
	"use strict";
	tinymce.create('tinymce.plugins.aio_buttons', {
		init : function (ed, url) {
		
			var nonce = '';
			if ( nonce === '' ) {
				$.post( ajaxurl, { 'action' : 'ajax_aiobtn_nonce' }, function ( response ) {
					nonce = response;
				});
			}

			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('AIO_Buttons', function () {
				ed.windowManager.open({
					file : ajaxurl + '?action=ajax_aiobtn_dialog&aiobtn_dialog_nonce=' + nonce,
                    width : 1070,
                    height : window.innerHeight-36,
                    inline : 1,
                    maximizable: true
                }, {
					plugin_url : url // Plugin absolute URL
                });
            });

            // Register button
            ed.addButton('aio_buttons', {
                title : 'All In One Buttons',
                cmd : 'AIO_Buttons',
                onPostRender : function() {
                    var ctrl = this;

                    ed.on('NodeChange', function(e) {
                        ctrl.active(e.element.nodeName == 'IMG');
                    });
                },
                image : url + '/tinymce_button.png'
            });

        },

        getInfo : function () {
            return {
                longname : 'All In One Buttons',
                author : 'Brandon Bell',
                authorurl : 'http://www.wpgoods.com/',
                infourl : 'http://www.wpgoods.com/product/all-in-one-buttons/',
                version : "1.4"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('aio_buttons', tinymce.plugins.aio_buttons);
}(jQuery));