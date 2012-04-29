tinyMCEPopup.requireLangPack();

var PalmateEditCalendarDialog = {
	init : function() {
		this.resize();
		var style = tinyMCEPopup.getWindowArg('style');
		var tags = tinyMCEPopup.getWindowArg('tags');

		document.getElementById('calendar-style').value = style;
		document.getElementById('calendar-tags').value = tags;
	},

	insert : function() {
		var style = tinyMCEPopup.dom.encode(document.getElementById('calendar-style').value);
		var tags = tinyMCEPopup.dom.encode(document.getElementById('calendar-tags').value);
    var settings = 'style="' + style + '" tags="' + tags + '"';

    tinyMCEPopup.editor.plugins.palmateCalendar._changeCalendar( settings );
		tinyMCEPopup.close();
	},

	resize : function() {
	}
};

tinyMCEPopup.onInit.add(PalmateEditCalendarDialog.init, PalmateEditCalendarDialog);
