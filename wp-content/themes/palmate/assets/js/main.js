/**
 * Request and render palmate calendar
 */
function PalmateCalendar(rangeMode, selector, requestUrl) {
  var rowDivider = '<tr><td colspan="3" class="cal-divider"></td></tr>';
  var emptyDay = '<td colspan="2"></td>';
  var weekDayNames = [ '', 'mån', 'tis', 'ons', 'tor', 'fre', 'lör', 'sön'];
  var monthNames = [ '', 'januari', 'februari', 'mars', 'april', 'maj', 'juni', 'juli', 'augusti', 'september', 'oktober', 'november', 'december'];

  var calendarElement = $(selector);
  var rangeOffset = 0;

  function calendarHeader(calendar) {
    if (rangeMode == 'week') {
      return 'Vecka ' + calendar.week + ', ' + calendar.year + '<small>' + calendarMonths(calendar) + '</small>';
    } else {
      var month = calendarMonths(calendar);
      return month.charAt(0).toUpperCase() + month.slice(1) + '<small>' + calendar.year + '</small>';
    }
  }

  function dayBox(day) {
    var rowSpan = 1;
    if (day.events.length > 0) {
      rowSpan = day.events.length;
      for (var index = 0; index < day.events.length; index++) {
        if (day.events[index].description) {
          rowSpan++;
        }
      }
    }
    var sundayClass = day.weekDay == 7 ? ' cal-sunday' : '';
    return '<td rowspan="' + rowSpan + '" class="cal-date' + sundayClass + '"><div>' + parseInt(day.date.substr(8,2), 10) + '<p>' + weekDayNames[day.weekDay] + '</p></div></td>';
  }

  function eventTitle(event) {
    return '<td class="cal-time">' + event.startTime.substr(11,5) + '</td><td class="cal-event">' + event.title + '</td>';
  }

  function eventDescription(event) {
    return '</tr><tr><td></td><td class="cal-desc">' + event.description.replace(/\n/gi, '<br>') + '</td>';
  }

  function calendarMonths(calendar) {
    var startMonth = parseInt(calendar.fromDate.substr(5,2), 10);
    var endMonth = parseInt(calendar.untilDate.substr(5,2), 10);
    if (startMonth != endMonth) {
      return [monthNames[startMonth], monthNames[endMonth]].join(' - ');
    } else {
      return monthNames[startMonth];
    }
  }

  function requestCalendar() {
    calendarElement.find('.cal-btn-prev').addClass('disabled');
    calendarElement.find('.cal-btn-next').addClass('disabled');
    calendarElement.find('.cal-content').css('opacity', 0.5);

    $.ajax({
      url: requestUrl,
      data: { rangeMode : rangeMode, rangeOffset : rangeOffset },
      type: 'get',
      dataType: 'json',
      success: function(calendarData) {
        renderCalendar(calendarData);
        calendarElement.find('.cal-btn-prev').removeClass('disabled');
        calendarElement.find('.cal-btn-next').removeClass('disabled');
        calendarElement.find('.cal-content').css('opacity', 1.0);
      }
    });
  }

  function renderCalendar(calendarData) {
    var calHtml = [];
    calHtml.push('<table><tbody>');
    for (var index = 0; index < calendarData.days.length; index++) {
      var day = calendarData.days[index];
      calHtml.push(rowDivider);

      calHtml.push('<tr>');
      calHtml.push(dayBox(day));
      if (day.events) {
        for (var eventIndex = 0; eventIndex < day.events.length; eventIndex++) {
          var event = day.events[eventIndex];
          if (eventIndex > 0) {
            calHtml.push('</tr><tr>');
          }
          calHtml.push(eventTitle(event));
          if (event.description) {
            calHtml.push(eventDescription(event));
          }
        }
      } else {
        calHtml.push(emptyDay);
      }
      calHtml.push('</tr>');
    };
    calHtml.push('</tbody></table>');
  
    calendarElement.find('.cal-header').html(calendarHeader(calendarData));
    calendarElement.find('.cal-content').html(calHtml.join(''));
  }

  function showPrev() {
    rangeOffset--;
    requestCalendar();
  }

  function showNext() {
    rangeOffset++;
    requestCalendar();
  }
  
  return {
    init     : requestCalendar,
    showPrev : showPrev,
    showNext : showNext
  }
}


/**
* Replace map image with iframe of OpenStreetMap content
* Android 2.3 devices has a bug with iframes that positioned them at start of page
*/
function replaceWithMap() {
  var mapextent = $("#map").attr('data-mapextent');
  var markerpos = $("#map").attr('data-markerpos');
  $("#map").replaceWith('<iframe width="100%" height="300px" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.openstreetmap.org/export/embed.html?bbox=' + mapextent + '&amp;layer=mapquest&amp;marker=' + markerpos + '" style="border: 1px solid black"></iframe>');
}


/**
* Expand next element and removes the specified element
*/
function expandNextElem(element) {
  $(element).css({"display": "none"});
  $(element).next().css({"max-height": ""});
}

/**
* Removes email spam fix after document is ready
*/
function email_at_replace() {
  $(function() {
    setTimeout(function() {
      $("i.email-at").replaceWith("@");
    }, 2000);
  });
}
