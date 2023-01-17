// Setup the calendar with the current date
function data_set(json_start, json_end, json_day, month, year, count) {
  var date = new Date();
  for (var i = 0; i < count; ++i) {
    event_data['events'][i] =
    {
      'start': json_start[i],
      'end': json_end[i],
      'day': json_day[i],
      'month': month,
      'year': year,
      'kind': 'ok',
      'comment': '',
    }
  }
  init_calendar(date);
}

$(document).ready(function () {
  var date = new Date();
  var today = date.getDate();
  // Set current month as active
  $(".months-row").children().eq(date.getMonth()).addClass("active-month");
  init_calendar(date);
  var events = check_events(today, date.getMonth() + 1, date.getFullYear());
  show_events(events, months[date.getMonth()], today);
  // Set click handlers for DOM elements
  $(".right-button").click({ date: date }, next_year);
  $(".left-button").click({ date: date }, prev_year);
  $(".month").click({ date: date }, month_click);
  $("#add-button").click({ date: date }, new_event);
  $("#delete-button").click({ date: date }, delete_event);
  $("#comment-button").click({ date: date }, comment_event);
});

// Display all events of the selected date in card views
function show_events(events, month, day) {
  console.log("events");
  console.log(events);
  console.log(event_data);
  // Clear the dates container
  $(".events-container").empty();
  var year_date = [];
  var month_date = [];
  var day_date = [];
  var comment_date = [];
  var kind_date = [];
  var start_date = [];
  var end_date = [];
  for (var i = 0; i < event_data['events'].length; i++) {
    // input作成
    year_date[i] = $("<input class='day-date' id='day_date' name='year" + i + "' value='" + event_data['events'][i]['year'] + "'></input>");
    month_date[i] = $("<input class='day-date' id='day_date' name='month" + i + "' value='" + event_data['events'][i]['month'] + "'></input>");
    day_date[i] = $("<input class='day-date' id='day_date' name='day" + i + "' value='" + event_data['events'][i]['day'] + "'></input>");
    comment_date[i] = $("<input class='day-date' id='day_date' name='comment" + i + "' value='" + event_data['events'][i]['comment'] + "'></input>");
    kind_date[i] = $("<input class='day-date' id='day_date' name='kind" + i + "' value='" + event_data['events'][i]['kind'] + "'></input>");
    start_date[i] = $("<input class='day-date' id='day_date' name='start" + i + "' value='" + event_data['events'][i]['start'] + "'></input>");
    end_date[i] = $("<input class='day-date' id='day_date' name='end" + i + "' value='" + event_data['events'][i]['end'] + "'></input>");
    //css追加処理
    $(year_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });
    $(month_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });
    $(day_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });
    $(comment_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });
    $(kind_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });
    $(start_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });
    $(end_date[i]).css({ "width": "1px", "height": "1px", "visibility": "hidden", "position": "absolute" });

    console.log("ok");
  }
  $(".events-container").append(year_date);
  $(".events-container").append(month_date);
  $(".events-container").append(day_date);
  $(".events-container").append(start_date);
  $(".events-container").append(end_date);
  $(".events-container").append(kind_date);
  $(".events-container").append(comment_date);
  console.log(month);
  $(".events-container").show(250);


  // If there are no events for this date, notify the user
  if (events.length === 0) {
    var event_card = $("<div class='event-card'></div>");
    var event_name = $("<div class='event-name'>予定は無いよ： " + month + "月 " + day + "日</div>");
    $(event_card).css({ "border-left": "10px solid #FF1744" });
    $(event_card).append(event_name);
    $(".events-container").append(event_card);

    $(".events-container").append(year_date);
    $(".events-container").append(month_date);
    $(".events-container").append(day_date);
    $(".events-container").append(start_date);
    $(".events-container").append(end_date);
    $(".events-container").append(kind_date);
    $(".events-container").append(comment_date);
  }
  // Go through and add each event as a card to the events container
  for (var i = 0; i < events.length; i++) {
    if (events[i]["kind"] == "ok") {
      var event_card = $("<div class='event-card'></div>");
      var event_name = $("<div class='event-name'>希望予定：</div>");
      var event_count = $("<div class='event-count'>" + events[i]["start"] + "～" + events[i]["end"] + "時間</div>");
      if (events[i]["cancelled"] === true) {
        $(event_card).css({
          "border-left": "10px solid #FF1744"
        });
        event_count = $("<div class='event-cancelled'>Cancelled</div>");
      }
      $(event_card).append(event_name).append(event_count);
      $(".events-container").append(event_card);
      // inputの作成
      $(".events-container").append(year_date);
      $(".events-container").append(month_date);
      $(".events-container").append(day_date);
      $(".events-container").append(start_date);
      $(".events-container").append(end_date);
      $(".events-container").append(kind_date);
      $(".events-container").append(comment_date);
    } else {
      var event_card = $("<div class='comment-card'></div>");
      var event_comment = $("<div class='event-name'>" + events[i]["comment"] + "</div>");
      if (events[i]["cancelled"] === true) {
        $(event_card).css({
          "border-left": "10px solid #FF1744"
        });
        event_count = $("<div class='event-cancelled'>Cancelled</div>");
      }
      $(event_card).append(event_comment);
      $(".events-container").append(year_date);
      $(".events-container").append(month_date);
      $(".events-container").append(day_date);
      $(".events-container").append(start_date);
      $(".events-container").append(end_date);
      $(".events-container").append(kind_date);
      $(".events-container").append(comment_date);
      $(".events-container").append(event_card);
    }
  }
}
// Initialize the calendar by appending the HTML dates
function init_calendar(date) {
  $(".tbody").empty();
  $(".events-container").empty();
  var calendar_days = $(".tbody");
  var month = date.getMonth();
  var year = date.getFullYear();
  var day_count = days_in_month(month, year);
  var row = $("<tr class='table-row'></tr>");
  var today = date.getDate();
  // Set date to 1 to find the first day of the month
  date.setDate(1);
  var first_day = date.getDay();
  // 35+firstDay is the number of date elements to be added to the dates table
  // 35 is from (7 days in a week) * (up to 5 rows of dates in a month)
  for (var i = 0; i < 35 + first_day; i++) {
    // Since some of the elements will be blank, 
    // need to calculate actual date from index
    var day = i - first_day + 1;
    // If it is a sunday, make a new row
    if (i % 7 === 0) {
      calendar_days.append(row);
      row = $("<tr class='table-row'></tr>");
    }
    // if current index isn't a day in this month, make it blank
    if (i < first_day || day > day_count) {
      var curr_date = $("<td class='table-date nil'>" + "</td>");
      row.append(curr_date);
    }
    else {
      var curr_date = $("<td class='table-date'>" + day + "</td>");
      var events = check_events(day, month + 1, year);
      if (today === day && $(".active-date").length === 0) {
        curr_date.addClass("active-date");
        show_events(events, months[month], day);
      }
      // If this date has any events, style it with .event-date
      if (events.length !== 0) {
        curr_date.addClass("event-date");
      }
      // Set onClick handler for clicking a date
      curr_date.click({ events: events, month: months[month], day: day }, date_click);
      row.append(curr_date);
    }
  }
  // Append the last row and set the current year
  calendar_days.append(row);
  console.log(row);
  $(".year").text(year);
}

// Get the number of days in a given month/year
function days_in_month(month, year) {
  var monthStart = new Date(year, month, 1);
  var monthEnd = new Date(year, month + 1, 1);
  return (monthEnd - monthStart) / (1000 * 60 * 60 * 24);
}

// Event handler for when a date is clicked
function date_click(event) {
  $(".events-container").show(250);
  $("#dialog").hide(250);
  $("#dialog2").hide(250);
  $(".active-date").removeClass("active-date");
  $(this).addClass("active-date");
  show_events(event.data.events, event.data.month, event.data.day);
};

// Event handler for when a month is clicked
function month_click(event) {
  $(".events-container").show(250);
  $("#dialog").hide(250);
  $("#dialog2").hide(250);
  var date = event.data.date;
  $(".active-month").removeClass("active-month");
  $(this).addClass("active-month");
  var new_month = $(".month").index(this);
  date.setMonth(new_month);
  init_calendar(date);
}

// Event handler for when the year right-button is clicked
function next_year(event) {
  $("#dialog").hide(250);
  $("#dialog2").hide(250);
  var date = event.data.date;
  var new_year = date.getFullYear() + 1;
  $("year").html(new_year);
  date.setFullYear(new_year);
  init_calendar(date);
}

// Event handler for when the year left-button is clicked
function prev_year(event) {
  $("#dialog").hide(250);
  $("#dialog2").hide(250);
  var date = event.data.date;
  var new_year = date.getFullYear() - 1;
  $("year").html(new_year);
  date.setFullYear(new_year);
  init_calendar(date);
}

//追加ボタン処理
// Event handler for clicking the new event button
function new_event(event) {
  // remove red error input on click
  $("input").click(function () {
    $(this).removeClass("error-input");
  })
  // empty inputs and hide events
  $("#dialog input[type=text]").val('');
  $("#dialog input[type=time][id=end]").val('');
  $(".events-container").hide(250);
  $("#dialog").show(250);
  // Event handler for cancel button
  $("#cancel-button").click(function () {
    $("#start").removeClass("error-input");
    $("#end").removeClass("error-input");
    $("#dialog").hide(250);
    $(".events-container").show(250);
  });
  // OKボタン
  // Event handler for ok button
  $("#ok-button").unbind().click({ date: event.data.date }, function () {
    var date = event.data.date;
    var start = parseInt($("#start").val().trim());
    var end = parseInt($("#end").val().trim());
    var day = parseInt($(".active-date").html());
    console.log(date);
    // Basic form validation
    if (isNaN(start)) {
      $("#start").addClass("error-input");
      alert("開始時間がありません");
    }
    else if (start > 24) {
      $("#start").addClass("error-input");
      alert("24時を超えています。");

    }
    else if (isNaN(end)) {
      $("#end").addClass("error-input");
      alert("終了時間がありません");
    }
    else if (end > 24) {
      $("#end").addClass("error-input");
      alert("24時を超えています。");
    }
    else if (start > end) {
      $("#start").addClass("error-input");
      $("#end").addClass("error-input");
      alert("開始時間が終了時間を超えています。");
    }
    else if (start == end) {
      $("#start").addClass("error-input");
      $("#end").addClass("error-input");
      alert("開始時間と終了時間が同じです。");
    }
    else {
      $("#dialog").hide(250);
      console.log("new event");
      button = 'ok';
      new_event_json(start, end, date, day, button);
      date.setDate(day);
      init_calendar(date);
      $(".events-container").show(250);
    }


  });
}

function comment_event(event) {
  // remove red error input on click
  $("input").click(function () {
    $(this).removeClass("error-input");
  })
  // empty inputs and hide events
  $("#dialog2 input[type=text]").val('');
  $(".events-container").hide(250);
  $("#dialog2").show(250);
  // Event handler for cancel button
  $("#cancel-button2").click(function () {
    $("#comment").removeClass("error-input");
    $("#dialog2").hide(250);
    $(".events-container").show(250);
  });
  $("#ok-button2").unbind().click({ date: event.data.date }, function () {
    var date = event.data.date;
    var comment = $("#comment").val().trim();
    var day = parseInt($(".active-date").html());

    $("#dialog2").hide(250);
    console.log("comment");
    console.log(comment);
    button = 'comment';
    comment_event_json(comment, date, day, button);
    date.setDate(day);
    init_calendar(date);
  });
}


//削除ボタン処理
// Event handler for clicking the new event button
function delete_event(event) {
  $("#delete-button").unbind({ date: event.data.date })
  var date = event.data.date;
  var day = parseInt($(".active-date").html());
  console.log("new event");
  delete_event_json(date, day);
  date.setDate(day);
  init_calendar(date);
}
function delete_event_json(date, day) {
  var event = {
    "year": date.getFullYear(),
    "month": date.getMonth() + 1,
    "day": day
  };
  for (let i = 0; i < event_data["events"].length; i++) {
    if (event_data["events"][i]["year"] == event["year"] && event_data["events"][i]["month"] == event["month"] && event_data["events"][i]["day"] == event["day"]) {
      console.log("削除");
      console.log(i);
      console.log(event_data['events'][i]);
      event_data['events'].splice(i, 1);
      console.log(event_data['events']);
      return;
    }
  }
}

// Adds a json event to event_data
function new_event_json(start, end, date, day, button) {
  console.log(comment);
  var event = {
    "start": start,
    "end": end,
    "year": date.getFullYear(),
    "month": date.getMonth() + 1,
    "day": day,
    "kind": button,
  };

  for (let i = 0; i < event_data["events"].length; i++) {
    if (event_data["events"][i]["year"] == event["year"] && event_data["events"][i]["month"] == event["month"] && event_data["events"][i]["day"] == event["day"] && event["kind"] == "ok") {
      console.log("OK");
      event_data["events"][i] = event;
      return;
    }
  }
  event_data["events"].push(event);
}

function comment_event_json(comment, date, day, button) {
  var event = {
    "start": '',
    "end": '',
    "comment": comment,
    "year": date.getFullYear(),
    "month": date.getMonth() + 1,
    "day": day,
    "kind": button
  };
  event_data["events"].push(event);
}

// Checks if a specific date has any events
function check_events(day, month, year) {
  var events = [];
  for (var i = 0; i < event_data["events"].length; i++) {
    var event = event_data["events"][i];
    if (event["day"] === day &&
      event["month"] === month &&
      event["year"] === year) {
      events.push(event);
    }
  }
  return events;
}

// データの設定
// Given data for events in JSON format


var event_data = {
  "events": [
    {
      'start': 10,
      'end': 12,
      'comment': "挨拶",
      'kind': "ok",
      'day': 13,
      'month': 1,
      'year': 2023,
    },
    {
      'start': 11,
      'end': 12,
      'comment': "挨拶",
      'kind': "comment",
      'day': 15,
      'month': 1,
      'year': 2023,
    },
    {
      'start': 14,
      'end': 19,
      'comment': "挨拶",
      'kind': "ok",
      'day': 16,
      'month': 1,
      'year': 2023,
    },
    {
      'start': 10,
      'end': 12,
      'comment': "挨拶",
      'kind': "ok",
      'day': 1,
      'month': 1,
      'year': 2023,
    },
    {
      'start': '',
      'end': '',
      'comment': "挨拶",
      'kind': "comment",
      'day': 8,
      'month': 1,
      'year': 2023,
    },
    {
      'start': 14,
      'end': 19,
      'comment': "挨拶",
      'kind': "ok",
      'day': 3,
      'month': 2,
      'year': 2023,
    },
  ]
};




const months = [
  1,
  2,
  3,
  4,
  5,
  6,
  7,
  8,
  9,
  10,
  11,
  12
];
