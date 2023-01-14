@include('emp_header')
<div class="emp_box">
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Calendar</title>
        <link rel="stylesheet" href="/css/test3.css" type="text/css">
        <link rel="stylesheet" href="/css/emp_box.css" type="text/css">
        <meta name="description" content="Calendar">
        <meta name="author" content="Charles Anderson">
    </head>

    <body>
        <div class="emp_box">
            <div class="content">
                <div class="calendar-container">
                    <div class="calendar">
                        <div class="year-header">
                            <span class="left-button" id="prev"> &lang; </span>
                            <span class="year" id="label"></span>
                            <span class="right-button" id="next"> &rang; </span>
                        </div>
                        <table class="months-table">
                            <tbody>
                                <tr class="months-row">
                                    <td class="month">1月</td>
                                    <td class="month">2月</td>
                                    <td class="month">3月</td>
                                    <td class="month">4月</td>
                                    <td class="month">5月</td>
                                    <td class="month">6月</td>
                                    <td class="month">7月</td>
                                    <td class="month">8月</td>
                                    <td class="month">9月</td>
                                    <td class="month">10月</td>
                                    <td class="month">11月</td>
                                    <td class="month">12月</td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="days-table">
                            <td class="day">土</td>
                            <td class="day">月</td>
                            <td class="day">火</td>
                            <td class="day">水</td>
                            <td class="day">木</td>
                            <td class="day">金</td>
                            <td class="day">日</td>
                        </table>
                        <div class="frame">
                            <table class="dates-table">
                                <tbody class="tbody">
                                </tbody>
                            </table>
                        </div>
                        <button class="button" id="add-button">Add Event</button>
                        <button class="button" id="delete-button">delet Event</button>
                    </div>
                </div>
                <div class="events-container">
                </div>
                <div class="dialog" id="dialog">
                    <h2 class="dialog-header">予定を入力してね</h2>
                    <form class="form" id="form">
                        <div class="form-container" align="center">
                            <label class="form-label" id="valueFromMyButton" for="name">Event name</label>
                            <input class="input" type="text" id="name" maxlength="36">
                            <label class="form-label" id="valueFromMyButton" for="count">シフト入力</label>
                            <input class="input" type="number" id="count" min="0" max="1000000"
                                maxlength="7">
                            <input type="button" value="Cancel" class="button" id="cancel-button">
                            <input type="button" value="OK" class="button" id="ok-button">
                        </div>
                    </form>
                </div>
                <div class="dialog2" id="dialog2">
                    <h2 class="dialog-header">予定を入力してね</h2>
                    <form class="form" id="form">
                        <div class="form-container" align="center">
                            <label class="form-label" id="valueFromMyButton" for="name">編集</label>
                            <input class="input" type="text" id="name2" maxlength="36">
                            <label class="form-label" id="valueFromMyButton" for="count">編集</label>
                            <input class="input" type="number" id="count2" min="0" max="1000000"
                                maxlength="7">
                            <input type="button" value="Cancel" class="button" id="cancel-button2">
                            <input type="button" value="OK" class="button" id="ok-button2">
                        </div>
                    </form>
                </div>
            </div>
            <!-- Dialog Box-->
            <script src="https://code.jquery.com/jquery-3.2.1.min.js"
                integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
            <script src="app.js"></script>
    </body>

    </html>
</div>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<link type="text/css" rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.min.css">
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script async src="https://code.jquery.com/jquery-3.6.3.js"
    integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/2.1.6/jquery.cycle2.core.min.js"></script>
<script type="text/javascript" src="/js/test3.js"></script>
