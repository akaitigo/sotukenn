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
        LINEユーザーID {{ $lineUserId }}
      </div>
      <ul>
      @foreach($messages as $message)
        <li>
          @if(empty($message->line_message_id))
            WEBアプリメッセージ {{ $message->text }}
          @else
            LINEメッセージ {{ $message->text }}
          @endif
        </li>
      @endforeach
      </ul>
      <form method="post" action="{{ route('message.create', ['lineUserId' => $lineUserId]) }}">
        @csrf
        <input type="text" name="message">
        <button type="submit">送信</button>
      </form>
    </body>
</html>
