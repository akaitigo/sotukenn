// Setup the calendar with the current date
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
});

// Display all events of the selected date in card views
function show_events(events, month, day) {
  console.log("events");
  // Clear the dates container
  $(".events-container").empty();
  $(".events-container").show(250);
  console.log(event_data["events"]);
  // If there are no events for this date, notify the user
  if (events.length === 0) {
    var event_card = $("<div class='event-card'></div>");
    var event_name = $("<div class='event-name'>予定は無いよ： " + month + " " + day + "日</div>");
    $(event_card).css({ "border-left": "10px solid #FF1744" });
    $(event_card).append(event_name);
    $(".events-container").append(event_card);
  }
  else {
    // Go through and add each event as a card to the events container
    for (var i = 0; i < events.length; i++) {
      var event_card = $("<div class='event-card'></div>");
      var event_name = $("<div class='event-name'>希望予定：</div>");
      var event_count = $("<div class='event-count'>"+ events[i]["occasion"]  +"～"+ events[i]["invited_count"] + "時間</div>");
      if (events[i]["cancelled"] === true) {
        $(event_card).css({
          "border-left": "10px solid #FF1744"
        });
        event_count = $("<div class='event-cancelled'>Cancelled</div>");
      }
      $(event_card).append(event_name).append(event_count);
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
  $("#dialog input[type=time][id=count]").val('');
  $(".events-container").hide(250);
  $("#dialog").show(250);
  // Event handler for cancel button
  $("#cancel-button").click(function () {
    $("#name").removeClass("error-input");
    $("#count").removeClass("error-input");
    $("#dialog").hide(250);
    $(".events-container").show(250);
  });
  // Event handler for ok button
  $("#ok-button").unbind().click({ date: event.data.date }, function () {
    var date = event.data.date;
    var name = $("#name").val().trim();
    var count =$("#count").val().trim();
    var day = parseInt($(".active-date").html());
    console.log(date);
    // Basic form validation
    if (name.length === 0) {
      $("#name").addClass("error-input");
    }
    else if (count.length === 0) {
      $("#count").addClass("error-input");
    }
    else {
      $("#dialog").hide(250);
      console.log("new event");
      new_event_json(name, count, date, day);
      date.setDate(day);
      init_calendar(date);
    }
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
      event_data['events'].splice( i, 1 );
      console.log(event_data['events']);
      return;
    }
  }
}

// Adds a json event to event_data
function new_event_json(name, count, date, day) {
  var event = {
    "occasion": name,
    "invited_count": count,
    "year": date.getFullYear(),
    "month": date.getMonth() + 1,
    "day": day
  };
  for (let i = 0; i < event_data["events"].length; i++) {
    if (event_data["events"][i]["year"] == event["year"] && event_data["events"][i]["month"] == event["month"] && event_data["events"][i]["day"] == event["day"]) {
      console.log("OK");
      event_data["events"][i] = event;
      return;
    }
  }
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

// Given data for events in JSON format
var event_data = {
  "events": [
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10,
      "cancelled": true
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10,
      "cancelled": true
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10,
      "cancelled": true
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10,
      "cancelled": true
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2023,
      "month": 1,
      "day": 13
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10,
      "cancelled": true
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10,
      "cancelled": true
    },
    {
      "occasion": " Repeated Test Event ",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 10
    },
    {
      "occasion": " Test Event",
      "invited_count": 120,
      "year": 2017,
      "month": 5,
      "day": 11
    }
  ]
};

const months = [
  "1月",
  "2月",
  "3月",
  "4月",
  "5月",
  "6月",
  "7月",
  "8月",
  "9月",
  "10月",
  "11月",
  "12月"
];
