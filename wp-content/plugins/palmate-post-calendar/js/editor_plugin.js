
(function() {
	tinymce.create('tinymce.plugins.palmateCalendar', {

		init : function(ed, url) {
			var t = this;

			t.url = url;

      ed.onInit.add(function() {
        ed.dom.loadCSS(url + '/../css/content.css');
      });

			t._createButtons();

      ed.addCommand('cmd_Palmate_InsCal', function() {
				var vp = tinymce.DOM.getViewPort(),	H = vp.h - 80, W = ( 640 < vp.w ) ? 640 : vp.w;
//        tb_show( 'My Gallery Shortcode', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=mygallery-form' );
        
        var inscalHTML = '<img src="' + url + '/../img/t.gif" class="palmateCalendar mceItem" title="MyTitle" />';
        ed.execCommand( 'mceInsertContent', 0, inscalHTML );
      });

			ed.addCommand('cmd_Palmate_EditCal', function() {
				var el = ed.selection.getNode(), vp = tinymce.DOM.getViewPort(),
				  H = vp.h, W = ( 720 < vp.w ) ? 720 : vp.w;
        
//				var el = ed.selection.getNode(), vp = tinymce.DOM.getViewPort(),
//					H = vp.h - 80, W = ( 640 < vp.w ) ? 640 : vp.w;

				if ( el.nodeName != 'IMG' ) return;
				if ( ed.dom.getAttrib(el, 'class').indexOf('palmateCalendar') == -1 )	return;

				tb_show('', url + '/editcalendar.html?ver=321&TB_iframe=true');
				tinymce.DOM.setStyles('TB_window', {
					'width':( W - 50 )+'px',
					'height':( H - 45 )+'px',
					'margin-left':'-'+parseInt((( W - 50 ) / 2),10) + 'px'
				});

				if ( ! tinymce.isIE6 ) {
					tinymce.DOM.setStyles('TB_window', {
						'top':'20px',
						'marginTop':'0'
					});
				}

				tinymce.DOM.setStyles('TB_iframeContent', {
					'width':( W - 50 )+'px',
					'height':( H - 75 )+'px'
				});
				tinymce.DOM.setStyle( ['TB_overlay','TB_window','TB_load'], 'z-index', '999999' );
			});

      // Set current html path
      ed.onPostRender.add( function() {
        if ( ed.theme.onResolveName ) {
          ed.theme.onResolveName.add( function( th, o ) {
				    if ( t._isCalClass( ed, o.node ) ) {
              o.name = 'calendar';
            }
          });
        }
      });

      // Show calendar edit/del buttons
			ed.onMouseDown.add(function(ed, e) {
				if ( t._isCalClass(ed, e.target) )
					ed.plugins.wordpress._showButtons(e.target, 'btns_Palmate_Calendar');
			});

      // Change content from HTML to Visual editor
			ed.onBeforeSetContent.add(function(ed, o) {
				o.content = t._toVisualEditor(o.content);
			});

      // Change content from Visual to HTML editor
			ed.onPostProcess.add(function(ed, o) {
				if (o.get)
					o.content = t._toHTMLEditor(o.content);
			});
			
      // Activate insert calendar button
      ed.onNodeChange.add(function(ed, cm, n) {
        cm.setActive( 'btns_Palmate_Calendar', t._isCalClass(ed, n) );
      });
		},

		_isCalClass : function(ed, node) {
      return ( node.nodeName == 'IMG' ) && ( ed.dom.hasClass(node, 'palmateCalendar') );
    },

		_toVisualEditor : function(co) {
		  var t = this;
      return co.replace( /\[cal([^\]]*)\]/g, function( a, settings ) {
        // TODO: Trim white spaces
        return '<img src="' + t.url + '/../img/t.gif" class="palmateCalendar mceItem" title="' + tinymce.DOM.encode(settings) + '" />'; //' + url + '/img/trans.gif
      });
		},

		_toHTMLEditor : function(co) {
			function getAttr(s, n) {
				n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
				return n ? tinymce.DOM.decode(n[1]) : '';
			};

			return co.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
				var cls = getAttr(im, 'class');

				if ( cls.indexOf('palmateCalendar') != -1 )
					return '<p>[cal '+tinymce.trim(getAttr(im, 'title'))+']</p>';

				return a;
			});
		},

		_createButtons : function() {
			var t = this, ed = tinyMCE.activeEditor, DOM = tinymce.DOM, editButton, delButton;

      // Add toolbar button to insert calendar
      ed.addButton( 'btn_Palmate_InsCal', {
        cmd : 'cmd_Palmate_InsCal',
        title : ed.getLang('palmate.calendar.insert'),
        image : t.url + '/../img/edit.png'
      });

      // Setup edit/del butons
			DOM.remove('btns_Palmate_Calendar');
			DOM.add(document.body, 'div', {
				id : 'btns_Palmate_Calendar',
				// Must set styles here because div is added to the body, it does not have our content.css styles
				style : 'display: none; position: absolute; padding: 2px; z-index: 999998;'
			});

			editButton = DOM.add('btns_Palmate_Calendar', 'img', {
				id : 'btn_Palmate_EditCal',
				width : '24',
				height : '24',
				src : t.url + '/../img/edit.png',
				title : ed.getLang('palmate.calendar.edit')
			});

			tinymce.dom.Event.add(editButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor;
				ed.windowManager.bookmark = ed.selection.getBookmark('simple');
				ed.execCommand("cmd_Palmate_EditCal");
			});

			delButton = DOM.add('btns_Palmate_Calendar', 'img', {
				id : 'btn_Palmate_DelCal',
				width : '24',
				height : '24',
				src : t.url + '/../img/delete.png',
				title : ed.getLang('palmate.calendar.delete')
			});

			tinymce.dom.Event.add(delButton, 'mousedown', function(e) {
				var ed = tinyMCE.activeEditor, el = ed.selection.getNode();
				if ( el.nodeName == 'IMG' && ed.dom.hasClass(el, 'palmateCalendar') ) {
					ed.dom.remove(el);
					ed.execCommand('mceRepaint');
					return false;
				}
			});

      // Hide edit/del buttons			
			ed.onInit.add(function(ed) {
				tinymce.dom.Event.add(ed.getWin(), 'scroll', function(e) {
          tinymce.DOM.hide('btns_Palmate_Calendar');
				});
				tinymce.dom.Event.add(ed.getBody(), 'dragstart', function(e) {
          tinymce.DOM.hide('btns_Palmate_Calendar');
				});
			});
			ed.onBeforeExecCommand.add(function(ed, cmd, ui, val) {
        tinymce.DOM.hide('btns_Palmate_Calendar');
			});
			ed.onSaveContent.add(function(ed, o) {
        tinymce.DOM.hide('btns_Palmate_Calendar');
			});
			ed.onMouseDown.add(function(ed, e) {
				if ( e.target.nodeName != 'IMG' )
          tinymce.DOM.hide('btns_Palmate_Calendar');
			});
		},

		getInfo : function() {
			return {
				longname : 'Palmate Calendar Settings',
				author : 'LeafCoders',
				authorurl : 'http://github.com/LeafCoders',
				infourl : '',
				version : "0.1"
			};
		}
	});

  tinymce.PluginManager.add('palmateCalendar', tinymce.plugins.palmateCalendar );

})();
