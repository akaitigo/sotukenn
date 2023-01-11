function registerCheck() {
    if (confirm('本当に登録してもよろしいですか？”OK”を選択すると通知が送信されます') == true) {
        return true;
    } else {
        return false;
    }
}