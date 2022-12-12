/* let switchBtn = document.getElementsByTagName('section')[0];
let box1 = document.getElementById('setting');
let box2 = document.getElementById('setting2');
let changeElement = (el) => {
  //el.classList.toggle('active');
  if (box1.style.display == '') {
    box1.style.display = 'none';
  } else {
    box1.style.display = '';
  }
}
let changeElement2 = (el) => {
  //el.classList.toggle('active');
  if (box2.style.display == '') {
    box2.style.display = 'none';
  } else {
    box2.style.display = '';
  }
}
switchBtn.addEventListener('click', () => {
  changeElement(box1);
  changeElement2(box2);
}, false); */
$(function () { // 遅延処理
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'GET',
    url: "settingselect", // url: は読み込むURLを表す
    datatype: "json",
    }).done(function(res){
      // 通信成功時の処理
        const WorkTimeStart = document.getElementById('WorkTimeStart');
        const WorkTimeEnd = document.getElementById('WorkTimeEnd');
        const SubmissionLimit = document.getElementById('SubmissionLimit');
        const cheap = document.getElementById('cheap');
        const option1 = document.createElement('option');
        const option2 = document.createElement('option');
        const option3 = document.createElement('option');
        if(WorkTimeStart.options[24] == null) {
          option1.textContent = (res['workstarttime']);
          option2.textContent = (res['workendtime']);
          option3.textContent = (res['submissionlimit']);
          WorkTimeStart.appendChild(option1);
          WorkTimeEnd.appendChild(option2);
          SubmissionLimit.appendChild(option3);
        }else {
          WorkTimeStart.options[24].val = (res['workstarttime']);
          WorkTimeEnd.options[24].val = (res['workendtime']);
          SubmissionLimit.options[7].val = (res['submissionlimit']);
          WorkTimeStart.options[24].textContent = (res['workstarttime']);
          WorkTimeEnd.options[24].textContent = (res['workendtime']);
          SubmissionLimit.options[7].textContent = (res['submissionlimit']);
        }
        WorkTimeStart.options[24].selected = true;
        WorkTimeEnd.options[24].selected = true;
        SubmissionLimit.options[7].selected = true;
        WorkTimeStart.options[24].hidden = true;
        WorkTimeEnd.options[24].hidden = true;
        SubmissionLimit.options[7].hidden = true;
9
        if((res['vote']) == 1) {
            cheap.checked = true;
        }else {
            cheap.checked = false;
        }

    }).fail(function (err) {
      // 通信失敗時の処理
        alert('ファイルの取得に失敗しました。');
    });
});


$('.open-overlay').click(function () {
  var overlay_navigation = $('.overlay-navigation'),
    nav_item_1 = $('.navigation_li:nth-of-type(1)'),
    nav_item_2 = $('.navigation_li:nth-of-type(2)'),
    nav_item_3 = $('.navigation_li:nth-of-type(3)'),
    nav_item_4 = $('.navigation_li:nth-of-type(4)'),
    top_bar = $('.bar-top'),
    middle_bar = $('.bar-middle'),
    bottom_bar = $('.bar-bottom');

  overlay_navigation.toggleClass('overlay-active');

  if (overlay_navigation.hasClass('overlay-active')) {
    top_bar.removeClass('animate-out-top-bar').addClass('animate-top-bar');
    middle_bar.removeClass('animate-out-middle-bar').addClass('animate-middle-bar');
    bottom_bar.removeClass('animate-out-bottom-bar').addClass('animate-bottom-bar');
    overlay_navigation.removeClass('overlay-slide-up').addClass('overlay-slide-down')
    nav_item_1.removeClass('slide-in-nav-item-reverse').addClass('slide-in-nav-item');
    nav_item_2.removeClass('slide-in-nav-item-delay-1-reverse').addClass('slide-in-nav-item-delay-1');
    nav_item_3.removeClass('slide-in-nav-item-delay-2-reverse').addClass('slide-in-nav-item-delay-2');
    nav_item_4.removeClass('slide-in-nav-item-delay-3-reverse').addClass('slide-in-nav-item-delay-3');
   
    

  } else {
    top_bar.removeClass('animate-top-bar').addClass('animate-out-top-bar');
    middle_bar.removeClass('animate-middle-bar').addClass('animate-out-middle-bar');
    bottom_bar.removeClass('animate-bottom-bar').addClass('animate-out-bottom-bar');
    overlay_navigation.removeClass('overlay-slide-down').addClass('overlay-slide-up')
    nav_item_1.removeClass('slide-in-nav-item').addClass('slide-in-nav-item-reverse');
    nav_item_2.removeClass('slide-in-nav-item-delay-1').addClass('slide-in-nav-item-delay-1-reverse');
    nav_item_3.removeClass('slide-in-nav-item-delay-2').addClass('slide-in-nav-item-delay-2-reverse');
    nav_item_4.removeClass('slide-in-nav-item-delay-3').addClass('slide-in-nav-item-delay-3-reverse');
    
    $(function () { // 遅延処理
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "settingupdate", // url: は読み込むURLを表す
            datatype: "json",
            data: {
              // valueをセット
              "workstarttime": $('#WorkTimeStart').val(),
              "workendtime": $('#WorkTimeEnd').val(),
              "submissionlimit": $('#SubmissionLimit').val(),
              "vote": $('#cheap').prop('checked')
            }
          });
    });
  }
})

