
// Mock tinymce to get a handler to our plugin
var p = null;
tinymce.create = function(id, instance) {
	p = instance;
	tinymce.plugins = { palmateCalendar : instance };
}
tinymce.PluginManager.add = function(id, instance) {}

// Run tests

test('Convert between Visual and HTML', function() {
	var settings = 'style="medium" tags="scout"';
	var html = p._getHTMLTag( settings );
	var visual = p._getVisualTag( settings );
	ok( p._toVisualEditor(html) == visual );
	ok( p._toHTMLEditor(visual) == html );
})
