$(function () { // 遅延処理
    $('#test').click(
        function () {
            $.ajax({
                headers: {
                    // POSTのときはトークンの記述がないと"419 (unknown status)"になるので注意
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "{{ action('App\Http\Controllers\SettingController@update') }}", // url: は読み込むURLを表す
                data: 
            }).done(function (results) {
                // 通信成功時の処理
                alert('ファイルの取得に成功しました。');
            }).fail(function (err) {
                // 通信失敗時の処理
                alert('ファイルの取得に失敗しました。');
            });
        }
    );
});