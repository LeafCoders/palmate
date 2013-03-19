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
    url: '/wp-admin/admin-ajax.php',
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
  var hasContent = $(":first-child",element).attr('data-hascontent');
  if (hasContent != 'yes') {
    var year = $(":first-child",element).attr('data-year');
    var week = $(":first-child",element).attr('data-week');
    loadCalendar(year, week, element);
  } else {
    var year = $(":first-child",element).attr('data-year');
    var week = $(":first-child",element).attr('data-week');
    var months = $(":first-child",element).attr('data-months');
    $('.cal-week').html('Vecka ' + week + ', ' + year + '<small>' + months + '</small>');
  }
};

/**
 * Set vivibility of calendar buttons
 */
function updatePalmateCalButtons($page, $numPages) {
  if ($page === 0) {
    $("#calPrevWeekBtn").attr('disabled', 'disabled');
  } else if ($page + 1 === $numPages) {
    $("#calNextWeekBtn").attr('disabled', 'disabled');
  } else {
    $("#calPrevWeekBtn").removeAttr('disabled');
    $("#calNextWeekBtn").removeAttr('disabled');
  }
};
