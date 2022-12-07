<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>通知管理</title>
    </head>
    <body>

        <td>














      <div>
        LINEユーザーID {{ $lineId }}
      </div>

      <form method="post"  action="{{ route('message.create', ['lineUserId' => $lineId]) }}">
        @csrf
        <button name="lineId" value="{{$lineId}}">通知</button>
      </form>
    </body>
</html>
