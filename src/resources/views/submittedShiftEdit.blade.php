<!DOCTYPE html>
<html lang="ja">
    <head>
        <link rel="stylesheet" href="/css/submittedShiftEdit.css" type="text/css">
    </head>
    <body>
        <div class="multiedit">
            <h3>勤務時間</h3>
            <select name="WorkTimeStart">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
            </select>
            <a>～</a>
            <select name="WorkTimeEnd">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
            </select><br><br>
            
            <a>シフトの提出は一か月ごとになります</a><br>
            <h3>シフト提出区間</h3><br>
            <a>～</a><br>
            <h3>シフト提出期限</h3><br>
            <a>迄</a><br><br>
            
            <a href="{{ route('submittedShift') }}" >保存ボタン</a>
        </div>
    </body>
</html>