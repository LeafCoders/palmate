/**
 * Load calendar ajax function
 */
function loadCalendar(year, week, element) {
	var data = {
		action: 'loadCalendarWeek',
		year: year,
		week: week
	};

	$.ajax({
		url: 'wp-admin/admin-ajax.php',
		data: data,
		type: 'post',
		dataType: 'html',
		success: function(html){
		  $(":first-child",element).replaceWith(html);

			var year = $(":first-child",element).attr('data-year');
			var months = $(":first-child",element).attr('data-months');
			var week = $(":first-child",element).attr('data-week');
			$('.cal-week').html('Vecka ' + week + ', ' + year + '<small>' + months + '</small>');
		}
	});
};

/**
 * Swipe calendar callback
 */
function swipeCalendarCallback(index, element) {
	var year = $(":first-child",element).attr('data-year');
	var week = $(":first-child",element).attr('data-week');
  loadCalendar(year, week, element);
};



