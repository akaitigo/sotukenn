// ページの読み込み完了時にローディング画面をフェードアウト
window.onload = function(){
    $(".js-loader").delay(1500).fadeOut(600); // 画像をフェードアウト
    $(".js-loader-bg").delay(2000).fadeOut(600); // 背景色をフェードアウト
}
  // ページの読み込みが完了しなくても5秒経ったら強制的にローディング画面をフェードアウト
setTimeout("stoploading()", 5000);
  function stoploading() {
    $(".js-loader-bg").fadeOut(600);
}