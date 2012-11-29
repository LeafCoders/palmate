/* Author:

*/

/**
 * Load calendar ajax function
 */
function loadCalendar(year, week) {
	var data = {
		action: 'loadCalendar',
		year: year,
		week: week
	};

	$.ajax({
		url: 'wp-admin/admin-ajax.php',
		data: data,
		type: 'post',
		dataType: 'html',
		success: function(html){
		  $('#calendar').html(html);
		}
	});
};



