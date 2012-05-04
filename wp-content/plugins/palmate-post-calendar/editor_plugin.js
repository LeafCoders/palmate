
(function() {
	tinymce.create('tinymce.plugins.palmateCalendar', {

		init : function(ed, url) {
			var t = this;
			t.url = url;
			t.didCalClick = false;

			ed.onInit.add(function() {
				ed.dom.loadCSS(url + '/css/content.css');
			});

			// Insert new calendar command
			ed.addCommand('cmd_Palmate_InsCal', function() {
				t._openEditDialog();
			});

			// Add toolbar button to insert calendar
			ed.addButton( 'btn_Palmate_InsCal', {
				cmd : 'cmd_Palmate_InsCal',
				title : ed.getLang('palmate.calendar.insert'),
				image : t.url + '/img/insertcal.png'
			});

			// Set current breadcrumb and show edit calendar dialog
			ed.onPostRender.add( function() {
				if ( ed.theme.onResolveName ) {
					ed.theme.onResolveName.add( function( th, o ) {
						if ( t._isCalClass( ed, o.node ) ) {
							o.name = 'calendar';
							if ( t.didCalClick ) {
								t._openEditDialog();
							}
						}
					});
				}
				t.didCalClick = false;
			});

			// Show calendar edit/del buttons
			ed.onMouseDown.add(function(ed, e) {
				if ( t._isCalClass(ed, e.target) ) {
					// Selection has not been updated here. Delay it to onPostRender event
					t.didCalClick = true;
				}
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
				cm.setActive( 'btn_Palmate_InsCal', t._isCalClass(ed, n) );
			});
		},

		_isCalClass : function(ed, node) {
			return ( node.nodeName == 'IMG' ) && ( ed.dom.hasClass(node, 'palmateCalendar') );
		},

		_getAttr : function(s, n) {
			n = new RegExp(n + '=\"([^\"]+)\"', 'g').exec(s);
			return n ? tinymce.DOM.decode(n[1]) : '';
		},

		_toVisualEditor : function(co) {
			var t = this;
			return co.replace( /\[palmate-calendar([^\]]*)\]/g, function( a, settings ) {
				return t._getVisualTag( settings );
			});
		},

		_toHTMLEditor : function(co) {
			var t = this;
			return co.replace(/(?:<p[^>]*>)*(<img[^>]+>)(?:<\/p>)*/g, function(a,im) {
				var cls = t._getAttr(im, 'class');
				if ( cls.indexOf('palmateCalendar') != -1 ) {
					var settings = tinymce.trim(t._getAttr(im, 'title'));
					return t._getHTMLTag( settings );
				}
				return a;
			});
		},

		_getVisualTag : function( settings ) {
			settings = tinymce.trim(tinymce.DOM.encode(settings));
			return '<img src="' + this.url + '/img/t.gif" class="palmateCalendar mceItem" title="' + settings + '" />';
		},

		_getHTMLTag : function( settings ) {
			return '[palmate-calendar ' + settings + ']';
		},

		_openEditDialog : function() {
			var t = this, ed = tinyMCE.activeEditor, n = ed.selection.getNode();
			var imgNode = n.firstChild != null ? n.firstChild : n;
			var settings = imgNode.nodeName == 'IMG' ? imgNode.getAttribute( "title" ) : "";
			t.didCalClick = false;
			ed.windowManager.open(
				{	file : t.url + '/editcalendar.html', width : 250,	height : 150,	inline : 1 },
				{
					style : t._getAttr( settings, 'style' ),
					tags : t._getAttr( settings, 'tags' )
				}
			);
		},

		_changeCalendar : function( settings ) {
			var t = this, ed = tinyMCE.activeEditor;
			ed.execCommand('mceReplaceContent', false, t._getVisualTag( settings ));
		},
		
		getInfo : function() {
			return {
				longname : 'Palmate Post Calendar Editor Plugin',
				author : 'LeafCoders',
				authorurl : 'http://github.com/LeafCoders/palmate',
				version : "0.1"
			};
		}
	});

	tinymce.PluginManager.add('palmateCalendar', tinymce.plugins.palmateCalendar );

})();
