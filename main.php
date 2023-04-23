<!-- 翁長春樹 -->

<?php
include_once("auth.inc");
auth();
?>

<!DOCTYPE html>

<html lang="ja">

<head>
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <title>
    毒入りスープ
  </title>
  <meta charset="utf-8">
</head>

<body>

  <?php

  // データベースへの接続
  @$con = pg_connect("!SECRET!");
  if ($con == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>DATABASE CONNECTION ERROR1</p>\n";
    print "<a href=\"index.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  $uname = $_SERVER['PHP_AUTH_USER'];

  // 送られてきた情報をデータベースに記録する
  if (isset($_GET['sanity'])) { // sanityを更新する
    $sql = "update " . $uname . "statedb set sanity='" . $_GET['sanity'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['time'])) { // timeを更新する
    if ($_GET['time'] <= 0) {
      $sql = "update " . $uname . "statedb set time=0";
    } else {
      $sql = "update " . $uname . "statedb set time=" . $_GET['time'];
    }

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['command'])) { // commandを更新する
    $sql = "update " . $uname . "statedb set command='" . $_GET['command'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['room'])) { // roomを更新する

    if ($_GET['room'] == "first") { // 東の部屋から最初の部屋に初めて移動したとき、少女を調べられなくしてもちものに加える

      $sql = "select * from " . $uname . "statedb"; // ユーザの状態をとってくる。
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }

      $room = pg_fetch_result($result, 0, 2);

      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

      if ($room == "east") {

        $sql = "select * from " . $uname . "eastdb"; // 東の部屋の状態をとってくる

        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる
          exit;
        }

        $syojo = pg_fetch_result($result, 0, 0); // とってきた東の部屋の状態を変数に入れる

        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

        if ($syojo == 1) {
          $sql = "update " . $uname . "eastdb set syojo=0, syojonihanasikakeru=0, syojonihureru=0, syojowohipparu=0"; // 東の部屋で少女を調べられなくする 
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

          $sql = "update " . $uname . "itemdb set syojo=1"; // もちものに少女を加える
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

          $sql = "update " . $uname . "southdb set syojowosakiniikaseru=1"; // 東の部屋で少女を調べられなくする 
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

          $sql = "update " . $uname . "statedb set command='text', textnumber=490"; // 少女がついてくることを表示するようにする
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      }
    }

    $sql = "update " . $uname . "statedb set room='" . $_GET['room'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['arm'])) { // armを更新する
    $sql = "update " . $uname . "statedb set arm='" . $_GET['arm'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['skillNameFlag'])) { // skillNameFlagを更新する
    $sql = "update " . $uname . "statedb set skillnameflag='" . $_GET['skillNameFlag'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['itemNameFlag'])) { // itemNameFlagを更新する
    $sql = "update " . $uname . "statedb set itemnameflag='" . $_GET['itemNameFlag'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['findNameFlag'])) { // findNameFlagを更新する
    $sql = "update " . $uname . "statedb set findnameflag='" . $_GET['findNameFlag'] . "'";
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['textNumber'])) { // textNumberを更新する
    $sql = "update " . $uname . "statedb set textnumber=" . $_GET['textNumber'];
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  if (isset($_GET['skillJudgmentFlag'])) { // skilljudgmentflagを更新する
    $sql = "update " . $uname . "statedb set skilljudgmentflag=" . $_GET['skillJudgmentFlag'];
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  }

  $sql = "select * from " . $uname . "statedb"; // ユーザの状態をとってくる。
  @$result = pg_query($sql);
  if ($result == false) {
    print "DATA ACQUISITION ERROR\n";
    pg_close($con); // データベースとの接続を閉じる。
    exit;
  }

  $sanity = pg_fetch_result($result, 0, 0); // とってきたユーザの状態を変数に入れる。
  $time = pg_fetch_result($result, 0, 1);
  $room = pg_fetch_result($result, 0, 2);
  $command = pg_fetch_result($result, 0, 3);
  $arm = pg_fetch_result($result, 0, 4);
  $skillNameFlag = pg_fetch_result($result, 0, 5);
  $itemNameFlag = pg_fetch_result($result, 0, 6);
  $findNameFlag = pg_fetch_result($result, 0, 7);
  $textNumber = pg_fetch_result($result, 0, 8);
  $skillJudgmentFlag = pg_fetch_result($result, 0, 9);

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  if ($skillJudgmentFlag == 1) { // 100面ダイスの判定を行う

    $sql = "select " . $skillNameFlag . " from " . $uname . "skilldb"; // 技能の状態をとってくる。
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }

    $skill = pg_fetch_result($result, 0, 0); // とってきた技能の状態を変数に入れる。

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $dice = mt_rand(1, 100);
    if ($skill >= $dice) { // 成功
      if ($command == "skill") {
        $command = "skillSuccess";
      } else {
        $command = "findHowSkillSuccess";
      }
    } else {
      if ($command == "skill") {
        $command = "skillFailure";
      } else {
        $command = "findHowSkillFailure";
      }
    }

    $sql = "update " . $uname . "statedb set command='" . $command . "'"; // commandを更新する
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "statedb set skilljudgmentflag=0"; // skilljudgmentflagを更新する
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  }

  print "<div class=\"mainContainer\">\n";

  print "<div class=\"stateContainer\">\n";

  print "<div class=\"stateItem\">\n"; // 正気度を表示
  print "<p>正気度:" . $sanity . "</p>\n";
  print "</div>\n";

  print "<div class=\"stateItem\">\n"; // 残り時間を表示
  print "<p>残り時間:" . $time . "分</p>\n";
  print "</div>\n";

  print "</div>\n";

  if (($sanity <= 0) && (($command == "command") || ($command == "find") || ($command == "skill") || ($command == "item") || ($command == "sanityDecrease"))) { // 正気度が0以下のときsanity0へ
    $command = "sanity0";

    $sql = "update " . $uname . "statedb set command='" . $command . "'"; // commandを更新する
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
  } else if (($time <= 0) && (($command == "command") || ($command == "find") || ($command == "skill") || ($command == "item"))) { // 残り時間が0分以下のときtextへ
    if (($command != "badEnd") && ($textNumber != 461)) {
      if ($room == "south") {
        $command = "text";
        $textNumber = 470;
      } else {
        $command = "text";
        $textNumber = 460;
      }

      $sql = "update " . $uname . "statedb set command='" . $command . "'"; // commandを更新する
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

      $sql = "update " . $uname . "statedb set textnumber='" . $textNumber . "'"; // textnumberを更新する
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    }
  }

  if (($command == "sanity0") || ($command == "badEnd")) { // 背景画像を決める

    $alt = "badend";
    $image = "badend.jpg";
  } else if (($textNumber == 461) || ($textNumber == 470)) {

    $alt = "Chaugnar Faugn";
    $image = "ChaugnarFaugn.jpg";
  } else if ((($textNumber >= 481) && ($textNumber <= 487)) || ($command == "trueEnd")) {

    $alt = "white";
    $image = "white.jpg";
  } else if ($room == 'first') {

    $sql = "select * from " . $uname . "firstdb"; // 最初の部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $memoomote = pg_fetch_result($result, 0, 0); // とってきた最初の部屋の状態を変数に入れる。
    $tizu = pg_fetch_result($result, 0, 1);
    $kitanotobira = pg_fetch_result($result, 0, 2);
    $minaminotobira = pg_fetch_result($result, 0, 3);
    $nisinotobira = pg_fetch_result($result, 0, 4);
    $higasinotobira = pg_fetch_result($result, 0, 5);
    $kinoutuwa = pg_fetch_result($result, 0, 6);
    $memoura = pg_fetch_result($result, 0, 7);
    $dennkyu = pg_fetch_result($result, 0, 8);
    $dennkyunonakanoekitai = pg_fetch_result($result, 0, 9);
    $dokuirisupu = pg_fetch_result($result, 0, 10);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $alt = "最初の部屋";

    if ($dennkyunonakanoekitai >= 1) {
      $image = "firstDennkyu.jpg";
    } else {
      $image = "first.jpg";
    }
  } else if ($room == 'west') {

    $sql = "select * from " . $uname . "westdb"; // 西の部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $rosoku = pg_fetch_result($result, 0, 0); // とってきた西の部屋の状態を変数に入れる
    $memo = pg_fetch_result($result, 0, 1);
    $honndana = pg_fetch_result($result, 0, 2);
    $makkuronahonn = pg_fetch_result($result, 0, 3);
    $supunoyumenituite = pg_fetch_result($result, 0, 4);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $alt = "西の部屋";

    if ($makkuronahonn >= 1) {
      $image = "westMakkuronahonn.png";
    } else {
      $image = "west.png";
    }
  } else if ($room == 'north') {

    $sql = "select * from " . $uname . "northdb"; // 北の部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $mamedennkyu = pg_fetch_result($result, 0, 0); // とってきた北の部屋の状態を変数に入れる
    $gasukonnro = pg_fetch_result($result, 0, 1);
    $araiba = pg_fetch_result($result, 0, 2);
    $tyoridai = pg_fetch_result($result, 0, 3);
    $syokkidana = pg_fetch_result($result, 0, 4);
    $memo = pg_fetch_result($result, 0, 5);
    $hotyo = pg_fetch_result($result, 0, 6);
    $ginnironosupunn = pg_fetch_result($result, 0, 7);
    $nabe = pg_fetch_result($result, 0, 8);
    $nabenonaka = pg_fetch_result($result, 0, 9);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $alt = "北の部屋";

    if (($nabenonaka >= 1) && ($hotyo == 0)) {
      $image = "northNabenonakaHotyo.png";
    } else if ($nabenonaka >= 1) {
      $image = "northNabenonaka.png";
    } else if ($hotyo == 0) {
      $image = "northHotyo.png";
    } else {
      $image = "north.png";
    }
  } else if ($room == 'east') {

    $sql = "select * from " . $uname . "eastdb"; // 東の部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $syojo = pg_fetch_result($result, 0, 0); // とってきた東の部屋の状態を変数に入れる
    $syojonihanasikakeru = pg_fetch_result($result, 0, 1);
    $syojonihureru = pg_fetch_result($result, 0, 2);
    $syojowohipparu = pg_fetch_result($result, 0, 3);
    $kamikire = pg_fetch_result($result, 0, 4);
    $dannseinoitai = pg_fetch_result($result, 0, 5);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $alt = "東の部屋";

    if (($syojo >= 1) && ($kamikire >= 1)) {
      $image = "eastSyojoKamikire.jpg";
    } else if ($syojo >= 1) {
      $image = "eastSyojo.jpg";
    } else if ($kamikire >= 1) {
      $image = "eastKamikire.jpg";
    } else {
      $image = "east.jpg";
    }
  } else {

    $sql = "select * from " . $uname . "southdb"; // 南の部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $kaibutu = pg_fetch_result($result, 0, 0); // とってきた南の部屋の状態を変数に入れる
    $kaibutunitikazuku = pg_fetch_result($result, 0, 1);
    $syojowosakiniikaseru = pg_fetch_result($result, 0, 2);
    $kataudewokittesasidasu = pg_fetch_result($result, 0, 3);
    $husiginazo = pg_fetch_result($result, 0, 4);
    $zonokatawaranosekibann = pg_fetch_result($result, 0, 5);
    $kamikire = pg_fetch_result($result, 0, 6);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    if (($kaibutu == 0) && ($zonokatawaranosekibann == 0)) {

      $sql = "update " . $uname . "southdb set zonokatawaranosekibann=1";
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    }

    $alt = "南の部屋";

    if (($kaibutu >= 1) && ($husiginazo >= 1)) {
      $image = "southKaibutuHusiginazo.jpg";
    } else if ($kaibutu >= 1) {
      $image = "southKaibutu.jpg";
    } else if ($husiginazo >= 1) {
      $image = "southHusiginazo.jpg";
    } else {
      $image = "south.jpg";
    }
  }

  print "<img src=\"images/" . $image . "\" alt=\"" . $alt . "\">\n"; // 背景画像を表示

  if ($command == "command") { // コマンドを決める

    print "<div class=\"comandContainer\">\n";

    print "<a href=\"main.php?command=find\" class=\"comandItem\">\n";
    print "＜しらべる＞\n";
    print "</a>\n";

    print "<a href=\"main.php?command=skill\" class=\"comandItem\">\n";
    print "＜技能＞\n";
    print "</a>\n";

    print "<a href=\"main.php?command=item\" class=\"comandItem\">\n";
    print "＜もちもの＞\n";
    print "</a>\n";

    print "<a href=\"main.php?command=move\" class=\"comandItem\">\n";
    print "＜部屋をいどうする＞\n";
    print "</a>\n";

    if (($room == "first") && ($dokuirisupu == 1)) {
      print "<a href=\"main.php?command=text&textNumber=480\" class=\"comandItem warning\">\n";
      print "＜毒入りスープを飲む＞\n";
      print "</a>\n";
    }

    print "</div>\n";
  } else if ($command == "find") {

    print "<div class=\"comandContainer\">\n";

    if ($room == "first") { // 最初の部屋のとき

      print "<a href=\"main.php?command=findHow&findNameFlag=memoomote&textNumber=10\" class=\"comandItem\">\n";
      print "＜メモ(表)＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=tizu\" class=\"comandItem\">\n";
      print "＜地図＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=kitanotobira\" class=\"comandItem\">\n";
      print "＜北の扉＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=minaminotobira\" class=\"comandItem\">\n";
      print "＜南の扉＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=nisinotobira\" class=\"comandItem\">\n";
      print "＜西の扉＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=higasinotobira\" class=\"comandItem\">\n";
      print "＜東の扉＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=kinoutuwa\" class=\"comandItem\">\n";
      print "＜木の器＞\n";
      print "</a>\n";

      if ($memoura == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=memoura\" class=\"comandItem\">\n";
        print "<メモ(裏)＞\n";
        print "</a>\n";
      }

      if ($dennkyu == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=dennkyu\" class=\"comandItem\">\n";
        print "<電球＞\n";
        print "</a>\n";
      }

      if ($dennkyunonakanoekitai == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=dennkyunonakanoekitai\" class=\"comandItem\">\n";
        print "<電球の中の液体＞\n";
        print "</a>\n";
      }
    } else if ($room == "east") { // 東の部屋のとき

      if ($syojo == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=syojo\" class=\"comandItem\">\n";
        print "<少女＞\n";
        print "</a>\n";
      }

      if ($syojonihanasikakeru == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=syojonihanasikakeru\" class=\"comandItem\">\n";
        print "<少女に話しかける＞\n";
        print "</a>\n";
      }

      if ($syojonihureru == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=syojonihureru\" class=\"comandItem\">\n";
        print "<少女に触れる＞\n";
        print "</a>\n";
      }

      if ($syojowohipparu == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=syojowohipparu\" class=\"comandItem\">\n";
        print "<少女を引っ張る＞\n";
        print "</a>\n";
      }

      if ($kamikire == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=kamikire&textNumber=170\" class=\"comandItem\">\n";
        print "<紙切れ＞\n";
        print "</a>\n";
      }

      if ($dannseinoitai == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=dannseinoitai\" class=\"comandItem\">\n";
        print "<男性の遺体＞\n";
        print "</a>\n";
      }
    } else if ($room == "west") { // 西の部屋のとき

      print "<a href=\"main.php?command=findHow&findNameFlag=rosoku\" class=\"comandItem\">\n";
      print "<ろうそく＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=memo\" class=\"comandItem\">\n";
      print "<メモ＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=honndana\" class=\"comandItem\">\n";
      print "<本棚＞\n";
      print "</a>\n";

      if ($makkuronahonn == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=makkuronahonn\" class=\"comandItem\">\n";
        print "<真っ黒な本＞\n";
        print "</a>\n";
      }

      if ($supunoyumenituite == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=supunoyumenituite&textNumber=220\" class=\"comandItem\">\n";
        print "『スープの夢について』\n";
        print "</a>\n";
      }
    } else if ($room == "north") { // 北の部屋のとき

      print "<a href=\"main.php?command=findHow&findNameFlag=mamedennkyu\" class=\"comandItem\">\n";
      print "<豆電球＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=gasukonnro\" class=\"comandItem\">\n";
      print "<ガスコンロ＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=araiba\" class=\"comandItem\">\n";
      print "<洗い場＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=tyoridai\" class=\"comandItem\">\n";
      print "<調理台＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=syokkidana\" class=\"comandItem\">\n";
      print "<食器棚＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=findHow&findNameFlag=memo\" class=\"comandItem\">\n";
      print "<メモ＞\n";
      print "</a>\n";

      if ($hotyo == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=hotyo\" class=\"comandItem\">\n";
        print "<包丁＞\n";
        print "</a>\n";
      }

      if ($ginnironosupunn == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=ginnironosupunn\" class=\"comandItem\">\n";
        print "<銀色のスプーン＞\n";
        print "</a>\n";
      }

      if ($nabe == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=nabe\" class=\"comandItem\">\n";
        print "<鍋＞\n";
        print "</a>\n";
      }

      if ($nabenonaka == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=nabenonaka\" class=\"comandItem\">\n";
        print "<鍋の中＞\n";
        print "</a>\n";
      }
    } else { // 南の部屋のとき

      if ($kaibutu == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=kaibutu\" class=\"comandItem\">\n";
        print "<怪物＞\n";
        print "</a>\n";
      }

      if ($kaibutunitikazuku == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=kaibutunitikazuku&textNumber=340\" class=\"comandItem warning\">\n";
        print "<怪物に近づく＞\n";
        print "</a>\n";
      }

      if ($syojowosakiniikaseru == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=syojowosakiniikaseru&textNumber=350\" class=\"comandItem warning\">\n";
        print "<少女を先に行かせる＞\n";
        print "</a>\n";
      }

      if ($kataudewokittesasidasu == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=kataudewokittesasidasu&textNumber=360\" class=\"comandItem warning\">\n";
        print "<腕を怪物に差し出す＞\n";
        print "</a>\n";
      }

      if ($husiginazo == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=husiginazo\" class=\"comandItem\">\n";
        print "<不思議な像＞\n";
        print "</a>\n";
      }

      if ($zonokatawaranosekibann == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=zonokatawaranosekibann\" class=\"comandItem\">\n";
        print "<像の傍らの石版＞\n";
        print "</a>\n";
      }

      if ($kamikire == 1) {
        print "<a href=\"main.php?command=findHow&findNameFlag=kamikire\" class=\"comandItem\">\n";
        print "<紙切れ＞\n";
        print "</a>\n";
      }
    }

    print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
    print "←戻る\n";
    print "</a>\n";

    print "</div>\n";
  } else if ($command == "findHow") {

    $time = $time - 1 * $arm;

    print "<div class=\"comandContainer\">\n";

    print "<a href=\"main.php?time=" . $time . "&command=findHowSkill\" class=\"comandItem\">\n";
    print "<技能をつかう＞\n";
    print "</a>\n";

    print "<a href=\"main.php?time=" . $time . "&command=findHowItem\" class=\"comandItem\">\n";
    print "<もちものをつかう＞\n";
    print "</a>\n";

    print "<a href=\"main.php?time=" . $time . "&command=findHowExp\" class=\"comandItem\">\n";
    print "<そのまましらべる＞\n";
    print "</a>\n";

    print "<a href=\"main.php?command=find\" class=\"comandItem\">\n";
    print "←戻る\n";
    print "</a>\n";

    print "</div>\n";
  } else if ($command == "findHowSkill") {

    $sql = "select * from " . $uname . "skilldb"; // もちものの部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $tyouri = pg_fetch_result($result, 0, 0); // とってきた技能の状態を変数に入れる
    $kikimimi = pg_fetch_result($result, 0, 1);
    $mebosi = pg_fetch_result($result, 0, 2);
    $tyouyaku = pg_fetch_result($result, 0, 3);
    $genngogaku = pg_fetch_result($result, 0, 4);
    $igaku = pg_fetch_result($result, 0, 5);
    $iikurume = pg_fetch_result($result, 0, 6);
    $sinobiaruki = pg_fetch_result($result, 0, 7);
    $tosyokann = pg_fetch_result($result, 0, 8);
    $puroguraminngu = pg_fetch_result($result, 0, 9);
    $suiei = pg_fetch_result($result, 0, 10);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    print "<div class=\"comandContainer\">\n";

    if ($tyouri > 0) {
      print "<a href=\"main.php?skillNameFlag=tyouri&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜調理＞\n";
      print "</a>\n";
    }

    if ($kikimimi > 0) {
      print "<a href=\"main.php?skillNameFlag=kikimimi&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜利き耳＞\n";
      print "</a>\n";
    }

    if ($mebosi > 0) {
      print "<a href=\"main.php?skillNameFlag=mebosi&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜目星＞\n";
      print "</a>\n";
    }

    if ($tyouyaku > 0) {
      print "<a href=\"main.php?skillNameFlag=tyouyaku&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜跳躍＞\n";
      print "</a>\n";
    }

    if ($genngogaku > 0) {
      print "<a href=\"main.php?skillNameFlag=genngogaku&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜言語学＞\n";
      print "</a>\n";
    }

    if ($igaku > 0) {
      print "<a href=\"main.php?skillNameFlag=igaku&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜医学＞\n";
      print "</a>\n";
    }

    if ($iikurume > 0) {
      print "<a href=\"main.php?skillNameFlag=iikurume&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜言いくるめ＞\n";
      print "</a>\n";
    }

    if ($sinobiaruki > 0) {
      print "<a href=\"main.php?skillNameFlag=sinobiaruki&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜忍び歩き＞\n";
      print "</a>\n";
    }

    if ($tosyokann > 0) {
      print "<a href=\"main.php?skillNameFlag=tosyokann&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜図書館＞\n";
      print "</a>\n";
    }

    if ($puroguraminngu > 0) {
      print "<a href=\"main.php?skillNameFlag=puroguraminngu&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜プログラミング＞\n";
      print "</a>\n";
    }

    if ($suiei > 0) {
      print "<a href=\"main.php?skillNameFlag=suiei&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜水泳＞\n";
      print "</a>\n";
    }

    print "<a href=\"main.php?command=findHow\" class=\"comandItem\">\n";
    print "←戻る\n";
    print "</a>\n";

    print "</div>\n";
  } else if ($command == "findHowSkillSuccess") {

    if ($skillNameFlag == "tyouri") { // 技能の名前

      $skillName = "調理";
    } else if ($skillNameFlag == "kikimimi") {

      $skillName = "利き耳";
    } elseif ($skillNameFlag == "mebosi") {

      $skillName = "目星";
    } elseif ($skillNameFlag == "tyouyaku") {

      $skillName = "跳躍";
    } elseif ($skillNameFlag == "genngogaku") {

      $skillName = "言語学";
    } elseif ($skillNameFlag == "igaku") {

      $skillName = "医学";
    } elseif ($skillNameFlag == "iikurume") {

      $skillName = "言いくるめ";
    } elseif ($skillNameFlag == "sinobiaruki") {

      $skillName = "忍び歩き";
    } elseif ($skillNameFlag == "tosyokann") {

      $skillName = "図書館";
    } elseif ($skillNameFlag == "puroguraminngu") {

      $skillName = "プログラミング";
    } elseif ($skillNameFlag == "suiei") {

      $skillName = "水泳";
    }

    $text = "　" . $skillName . "に成功した。";

    if (($findNameFlag == "memoura") && (($skillNameFlag == "mebosi") || ($skillNameFlag == "igaku"))) { // メモ(裏)で目星か医学が成功したとき
      $nextCommand = "findHowSkillSuccessExp";
    } else if (($findNameFlag == "dennkyu") && ($skillNameFlag == "mebosi")) { // 電球で目星が成功したとき
      $nextCommand = "findHowSkillSuccessExp";
    } else if (($findNameFlag == "dennkyunonakanoekitai") && ($skillNameFlag == "igaku")) { // 電球の中の液体で医学が成功したとき

      $nextCommand = "findHowSkillSuccessExp";
    } else if (($findNameFlag == "minaminotobira") && ($skillNameFlag == "kikimimi")) { // 南の扉で利き耳が成功したとき

      $nextCommand = "findHowSkillSuccessExp";
    } else if (($findNameFlag == "honndana") && ($skillNameFlag == "tosyokann")) {

      $nextCommand = "findHowSkillSuccessExp";
    } else if (($findNameFlag == "husiginazo") && ($skillNameFlag == "mebosi")) {

      $nextCommand = "findHowSkillSuccessExp";
    } else {

      $nextCommand = "findHowExp";
    }

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=" . $nextCommand . "\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "findHowSkillSuccessExp") { // 詳しい説明

    if (($findNameFlag == "memoura") && (($skillNameFlag == "mebosi") || ($skillNameFlag == "igaku"))) { // メモ(裏)で目星か医学が成功したとき
      $nextCommand = "sanityDecrease";
      $text = "　スープの正体は人間の血のようだ。途端に、スープから鉄錆のような悪臭が感じられるようになった。";
    } else if (($findNameFlag == "dennkyu") && ($skillNameFlag == "mebosi")) { // 電球で目星が成功したとき

      $nextCommand = "find";
      $text = "　電球を取り外すと、中に黒い液体が入っている。";

      $sql = "update " . $uname . "firstdb set dennkyu=0"; // 電球を調べられないようにする
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

      $sql = "update " . $uname . "firstdb set dennkyunonakanoekitai=1"; // 電球の中の液体を調べられるようにする
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    } else if (($findNameFlag == "dennkyunonakanoekitai") && ($skillNameFlag == "igaku")) { // 電球の中の液体で医学が成功したとき
      $nextCommand = "sanityDecrease";
      $text = "　この真っ黒な液体は猛毒のようだ。触りたくはないが、電球に入れたままなら持ち運べるだろう。";

      $sql = "update " . $uname . "firstdb set dennkyunonakanoekitai=2"; // 電球の中の液体を調べられないようにする
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

      $sql = "update " . $uname . "itemdb set dennkyunonakanodoku=1"; // もちものに電球の中の毒を追加
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    } else if (($findNameFlag == "minaminotobira") && ($skillNameFlag == "kikimimi")) {

      $nextCommand = "sanityDecrease";
      $text = "　部屋の向こうからなにかの荒い呼吸音と、ズルズルと重いものを引きずるような音が聞こえる。";
    } else if (($findNameFlag == "honndana") && ($skillNameFlag == "tosyokann")) {

      $nextCommand = "find";
      $text = "　本棚の中に他の本と様子がちがう真っ黒な本を見つけたので、取り出してみた。";

      $sql = "update " . $uname . "westdb set makkuronahonn=1"; // 真っ黒な本を調べられるようにする
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    } else if (($findNameFlag == "makkuronahonn") && ($skillNameFlag == "igaku")) {

      $nextCommand = "sanityDecrease";
      $text = "　これは黒い蓮から作られた毒薬のようだ。体内に摂取してしまうと、呼吸と心拍が激しくなっていき、やがて心臓が疲れ果てて死んでしまうだろう。";

      $sql = "update " . $uname . "itemdb set honnnohyosinodoku=1"; // もちものに本の表紙の毒を追加
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    } else if (($findNameFlag == "husiginazo") && ($skillNameFlag == "mebosi")) {

      $nextCommand = "find";
      $text = "　像の近くに紙切れを見つけた。";

      $sql = "update " . $uname . "southdb set kamikire=1"; // 紙切れを調べられるようにする
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    }

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem warning\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=" . $nextCommand . "\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "findHowSkillFailure") {

    if ($skillNameFlag == "tyouri") { // 技能の名前

      $skillName = "調理";
    } else if ($skillNameFlag == "kikimimi") {

      $skillName = "利き耳";
    } elseif ($skillNameFlag == "mebosi") {

      $skillName = "目星";
    } elseif ($skillNameFlag == "tyouyaku") {

      $skillName = "跳躍";
    } elseif ($skillNameFlag == "genngogaku") {

      $skillName = "言語学";
    } elseif ($skillNameFlag == "igaku") {

      $skillName = "医学";
    } elseif ($skillNameFlag == "iikurume") {

      $skillName = "言いくるめ";
    } elseif ($skillNameFlag == "sinobiaruki") {

      $skillName = "忍び歩き";
    } elseif ($skillNameFlag == "tosyokann") {

      $skillName = "図書館";
    } elseif ($skillNameFlag == "puroguraminngu") {

      $skillName = "プログラミング";
    } elseif ($skillNameFlag == "suiei") {

      $skillName = "水泳";
    }

    $text = "　" . $skillName . "に失敗した。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=findHowExp\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "findHowExp") {

    if ($room == "first") { // 最初の部屋のとき

      if ($findNameFlag == "memoomote") { // メモ(表)のとき

        if ($memoura == 0) { // メモ(裏)を調べられるようにする
          $sql = "update " . $uname . "firstdb set memoura=1";
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }

        if ($textNumber == 10) {

          $text = "〜帰りたいなら　一時間以内に　毒入りスープを飲め。";
          $nextTextNumber = 11;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 11) {

          $text = "　飲まないと　君じゃあここから　出られない。";
          $nextTextNumber = 12;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 12) {

          $text = "　一時間以内に　飲めなかったら　お迎えが来るぞ〜";
          $nextTextNumber = -1;
          $nextCommand = "find";
        }
      } else if ($findNameFlag == "tizu") { // 地図のとき

        $text = "〜ここはスープの部屋　北の部屋は調理室　南の部屋は礼拝室　西の部屋は書物庫　東の部屋は下僕の部屋〜";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "kinoutuwa") { // 木の器のとき

        $text = "　中には赤いスープが入っている。においは感じられない。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "dennkyu") { // 電球のとき

        $text = "　天井から電球が吊り下げられているが、電球は光っておらず真っ黒だ。なら、どうしてこの部屋は明るいのだろう。";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      } else if ($findNameFlag == "kitanotobira") { // 北の扉のとき

        $text = "　真っ白な押し扉だ。鍵はかかっていないようだ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "nisinotobira") { // 西の扉のとき

        $text = "　扉はきれいな木でできている。鍵はかかっていないようだ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "higasinotobira") { // 東の扉のとき

        $text = "　扉は錆びた鉄でできている。鍵はかかっていないようだ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "minaminotobira") { // 南の扉のとき

        $text = "　鉄格子の小窓がついた、重くて厚そうな鉄扉だ。ドアノブや鍵はついていない。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "memoura") { // メモ(裏)のとき

        $text = "〜あたたかい　□□□□の　□□　スープ　さめない　うちに　めしあがれ〜";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else { // 電球の中の液体のとき
        $text = "　わずかに甘い香りのする、真っ黒で粘り気がある液体だ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      }
    } else if ($room == "east") { // 東の部屋のとき

      if ($findNameFlag == "syojo") { // 少女のとき

        $text = "　私と同じ白いボロキレを着た少女だ。ボロキレには血がついており、片手には拳銃を握っている。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "syojonihanasikakeru") { // 少女に話しかけるとき

        $text = "　話しかけると、少女はこちらを向いた。声は聞こえているようだが、返事はない。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "syojonihureru") { // 少女に触れるとき

        $text = "　手を伸ばすと、少女は怯えた様子でこちらを見ている。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "syojowohipparu") { // 少女を引っ張とき

        $text = "　少女の手を掴むと、少女はこちらに拳銃を向けた。";
        $nextTextNumber = -1;
        $nextCommand = "deadend";
      } else if ($findNameFlag == "kamikire") { // 紙切れのとき

        if ($textNumber == 170) {

          $text = "〜それは　名前のない　あなたの　下僕です。言われたことは　嫌でも　絶対に従います。";
          $nextTextNumber = -1;
          $nextCommand = "findHowExp";
        } else {

          $text = "　無口だけど　人懐っこい　良い子なので　可愛がって　あげてください〜";
          $nextTextNumber = -1;
          $nextCommand = "find";
        }
      } else {

        $text = "　遺体は頭部が欠けており、首からは血が飛び散っている。";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      }
    } else if ($room == "west") { // 西の部屋のとき

      if ($findNameFlag == "rosoku") { // ろうそくのとき

        $text = "　キャンドル皿に乗せられたろうそくがうっすらと部屋を照らしている。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "memo") { // メモのとき

        $text = "〜本はとっても大事なものだから持ち出したら駄目〜";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "honndana") { // 本棚のとき

        $text = "　いろんな本が丁寧に収められている。本のジャンルはバラバラなようだ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "makkuronahonn") { // 真っ黒な本のとき

        $text = "　表紙には『スープの夢について』と書かれている。触れてみると、本はべったりと湿っていて、甘い香りのする黒い液体が手に付着した";
        $nextTextNumber = -1;
        $nextCommand = "find";

        if ($supunoyumenituite == 0) {
          $sql = "update " . $uname . "westdb set supunoyumenituite=1"; // 『スープの夢について』を調べられるようにする
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      } else { // 『スープの夢について』のとき

        if ($textNumber == 220) {

          $text = "〜真ん中の部屋・・・ちゃんとしたスープを飲まないと出られない。メモの裏にはスープの正体が記されている。";
          $nextTextNumber = 221;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 221) {

          $text = "　上の部屋・・・調味料や食器がたくさん置いてある。予備のスープがちょっとだけ鍋にある。";
          $nextTextNumber = 222;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 222) {

          $text = "　右の部屋・・・とっても良い子が待っている。いいものを持っているよ。";
          $nextTextNumber = 223;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 223) {

          $text = "　左の部屋・・・本はとっても大事なものだから持ち出したら駄目。";
          $nextTextNumber = 224;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 224) {

          $text = "　下の部屋・・・神様が眠っている。毒の資料がある。番人は活きのいいものを食べなきゃいなくならない。";
          $nextTextNumber = -1;
          $nextCommand = "findHowExp";
        } else {

          $text = "　大事なこと・・・死ぬ覚悟をして飲むように〜";
          $nextTextNumber = -1;
          $nextCommand = "find";
        }
      }
    } else if ($room == "north") { // 北の部屋のとき

      if ($findNameFlag == "mamedennkyu") { // 豆電球のとき

        $text = "　いくつもの豆電球が設置されており、部屋は真昼のように明るい。豆電球は取り外せないようだ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "gasukonnro") { // ガスコンロのとき

        $text = "　つまみを捻ってみたが火はつかなかった。なら、どうしてスープはあたたかいのだろう。";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      } else if ($findNameFlag == "araiba") { // 洗い場のとき

        $text = "　水が流れた跡がない。しばらく使われていないようだ。";
        $nextTextNumber = -1;
        $nextCommand = "find";
      } else if ($findNameFlag == "tyoridai") { // 調理台のとき

        $text = "　この部屋の中で、調理台だけがひどく汚れている。ここでいったい何を調理したのだろう。";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";

        $sql = "select * from " . $uname . "itemdb"; // もちものの部屋の状態をとってくる

        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる
          exit;
        }

        $hotyoItem = pg_fetch_result($result, 0, 1); // とってきたもちものの部屋の状態を変数に入れる

        if (($hotyoItem == 0) && ($hotyo == 0)) {

          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
          $sql = "update " . $uname . "northdb set hotyo=1"; // 包丁を調べられるようにする
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      } else if ($findNameFlag == "hotyo") { // 包丁のとき

        $text = "　武器として使えるかもしれない。念のため持っておこう。";
        $nextTextNumber = -1;
        $nextCommand = "find";

        $sql = "update " . $uname . "northdb set hotyo=0"; // 包丁を調べられないようにする
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

        $sql = "update " . $uname . "itemdb set hotyo=1"; // 持ち物に包丁を追加
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

        $sql = "update " . $uname . "southdb set kataudewokittesasidasu=1"; // 南の部屋で片腕を切って差し出せるようにする
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
      } else if ($findNameFlag == "syokkidana") { // 食器棚のとき

        $text = "　銀色の食器がたくさん入っている。";
        $nextTextNumber = -1;
        $nextCommand = "find";

        $sql = "select * from " . $uname . "itemdb"; // もちものの部屋の状態をとってくる

        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる
          exit;
        }

        $ginnnosupunnItem = pg_fetch_result($result, 0, 2); // とってきたもちものの部屋の状態を変数に入れる

        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

        if (($ginnnosupunnItem == 0) && ($ginnironosupunn == 0)) {

          $sql = "update " . $uname . "northdb set ginnironosupunn=1"; // 銀色のスプーンを調べられるようにする
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      } else if ($findNameFlag == "ginnironosupunn") { // 銀色のスプーンのとき

        $text = "　小さいがずっしりと重い。銀でできているようだ。一本くらい持ち出してもいいだろう。";
        $nextTextNumber = -1;
        $nextCommand = "find";

        $sql = "update " . $uname . "northdb set ginnironosupunn=0"; // 銀色のスプーンを調べられないようにする
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

        $sql = "update " . $uname . "itemdb set ginnnosupunn=1"; // 持ち物に銀のスプーンを追加
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
      } else if ($findNameFlag == "nabe") { // 鍋のとき

        $text = "　蓋がしてある大きな鍋だ。蓋を開けてみよう。";
        $nextTextNumber = -1;
        $nextCommand = "find";

        $sql = "update " . $uname . "northdb set nabe=0"; // 鍋を調べられないようにする
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

        $sql = "update " . $uname . "northdb set nabenonaka=1"; // 鍋の中を調べられるようにする
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
      } else if ($findNameFlag == "nabenonaka") { // 鍋の中のとき

        $text = "　中はバラバラの死体でいっぱいになっており、鍋の底には血が溜まっている";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      } else { // メモのとき

        $text = "〜だいじな　調味料は　現在　在庫切れ〜";
        $nextTextNumber = -1;
        $nextCommand = "find";
      }
    } else { // 南の部屋のとき

      if ($findNameFlag == "kaibutu") { // 怪物のとき

        $text = "　部屋の中には、一枚だけの翼を持つ巨大なクサリヘビのような怪物がいる。怪物から強い殺気が感じられる。";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      } else if ($findNameFlag == "kaibutunitikazuku") { // 怪物に近づくとき

        if ($textNumber == 340) {

          $text = "　怪物は容赦なくこちらに襲いかかってきた。";
          $nextTextNumber = -1;
          $nextCommand = "findHowExp";
        } else {

          $text = "　怪物は私を押さえつけ、私の体を食べ始めた。";
          $nextTextNumber = -1;
          $nextCommand = "sanityDecrease";

          $sql = "update " . $uname . "southdb set kaibutu=0, kaibutunitikazuku=0, syojowosakiniikaseru=0, kataudewokittesasidasu=0, zonokatawaranosekibann=1"; // 南の部屋から怪物を消す
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      } else if ($findNameFlag == "syojowosakiniikaseru") { // 少女を先に行かせるとき

        if ($textNumber == 350) {

          $text = "　命令すると、少女は怪物に近づいていった。";
          $nextTextNumber = 351;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 351) {

          $text = "　怪物は少女に襲いかかり、少女を食べ始めた。";
          $nextTextNumber = 352;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 352) {

          $text = "　部屋の中には少女が初めて発した声、断末魔が響き渡る。";
          $nextTextNumber = -1;
          $nextCommand = "findHowExp";
        } else {

          $text = "　少女を食べた怪物は満足し、部屋からいなくなった。";
          $nextTextNumber = -1;
          $nextCommand = "sanityDecrease";

          $sql = "update " . $uname . "itemdb set syojo=0"; // 持ち物から少女を消す
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

          $sql = "update " . $uname . "southdb set kaibutu=0, kaibutunitikazuku=0, syojowosakiniikaseru=0, kataudewokittesasidasu=0, zonokatawaranosekibann=1"; // 南の部屋から怪物を消す
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      } else if ($findNameFlag == "kataudewokittesasidasu") { // 片腕を切って差し出すとき

        if ($textNumber == 360) {

          $text = "　ひどい痛みに耐えながら、私は包丁で自らの片腕を切り落とした。";
          $nextTextNumber = 361;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 361) {

          $text = "　切り落とした片腕を差し出すと、怪物はそちらに飛びついた。";
          $nextTextNumber = 362;
          $nextCommand = "findHowExp";
        } else if ($textNumber == 362) {

          $text = "　腕を食べた怪物は満足し、部屋からいなくなった。";
          $nextTextNumber = -1;
          $nextCommand = "findHowExp";
        } else {

          $text = "　片腕になってしまった私は、これから何かを調べるのに今までよりも時間がかかってしまうだろう。";
          $nextTextNumber = -1;
          $nextCommand = "sanityDecrease";

          $sql = "update " . $uname . "statedb set arm=2"; // 腕の状態を更新
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

          $sql = "update " . $uname . "southdb set kaibutu=0, kaibutunitikazuku=0, syojowosakiniikaseru=0, kataudewokittesasidasu=0, zonokatawaranosekibann=1"; // 南の部屋から怪物を消す
          @$result = pg_query($sql);
          if ($result == false) {
            print "DATA ACQUISITION ERROR\n";
            pg_close($con); // データベースとの接続を閉じる。
            exit;
          }
          pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
        }
      } else if ($findNameFlag == "zonokatawaranosekibann") {

        $text = "〜これは夢の神チャウグナー・フォーン。ここはチャウグナー・フォーンが気まぐれで魅せる夢の中〜";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      } else if ($findNameFlag == "husiginazo") { // 不思議な像のとき

        $text = "　体は人間で頭は象の形をしている不思議な像だ。";
        $nextTextNumber = -1;
        $nextCommand = "sanityDecrease";
      } else if ($findNameFlag == "kamikire") { // 紙切れのとき

        $text = "〜真ん中の　弱々しい　太陽の中。もしくは　黒染めの　夢の知識。　そこに調味料は隠れている〜";
        $nextTextNumber = -1;
        $nextCommand = "find";
      }
    }

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?&command=" . $nextCommand . "&textNumber=" . $nextTextNumber . "\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "findHowItem") {

    $sql = "select * from " . $uname . "itemdb"; // もちものの部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $syojoItem = pg_fetch_result($result, 0, 0); // とってきたもちものの部屋の状態を変数に入れる
    $hotyoItem = pg_fetch_result($result, 0, 1);
    $ginnnosupunnItem = pg_fetch_result($result, 0, 2);
    $dennkyunonakanodokuItem = pg_fetch_result($result, 0, 3);
    $honnnohyosinodokuItem = pg_fetch_result($result, 0, 4);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    print "<div class=\"comandContainer\">\n";

    $nextCommand = "findHowItemFailure";

    if ($syojoItem == 1) {
      print "<a href=\"main.php?command=" . $nextCommand . "&itemNameFlag=syojo\" class=\"comandItem\">\n";
      print "＜少女＞\n";
      print "</a>\n";
    }

    if ($hotyoItem == 1) {
      print "<a href=\"main.php?command=" . $nextCommand . "&itemNameFlag=hotyo\" class=\"comandItem\">\n";
      print "＜包丁＞\n";
      print "</a>\n";
    }

    if ($ginnnosupunnItem == 1) {

      if (($findNameFlag == "dennkyunonakanoekitai") || ($findNameFlag == "makkuronahonn")) { // 対象が毒のとき
        $nextCommand = "findHowItemSuccess";
      }
      print "<a href=\"main.php?command=" . $nextCommand . "&itemNameFlag=ginnnosupunn\" class=\"comandItem\">\n";
      print "＜銀のスプーン＞\n";
      print "</a>\n";
    }

    if ($dennkyunonakanodokuItem == 1) {

      if (($findNameFlag == "kinoutuwa") && ($dokuirisupu == 0)) { // 対象が木の器のとき
        $nextCommand = "findHowItemSuccess";
      }
      print "<a href=\"main.php?command=" . $nextCommand . "&itemNameFlag=dennkyunonakanodoku\" class=\"comandItem\">\n";
      print "＜電球の中の液体＞\n";
      print "</a>\n";
    }

    if ($honnnohyosinodokuItem == 1) {

      if (($findNameFlag == "kinoutuwa") && ($dokuirisupu == 0)) { // 対象が木の器のとき
        $nextCommand = "findHowItemSuccess";
      }
      print "<a href=\"main.php?command=" . $nextCommand . "&itemNameFlag=honnnohyosinodoku\" class=\"comandItem\">\n";
      print "＜本の表紙の毒＞\n";
      print "</a>\n";
    }

    print "<a href=\"main.php?command=findHow\" class=\"comandItem\">\n";
    print "←戻る\n";
    print "</a>\n";

    print "</div>\n";
  } else if ($command == "findHowItemSuccess") {

    if ($findNameFlag == "kinoutuwa") { // 木の器に毒を選んだとき

      $text = "　スープに毒を入れた。";

      $sql = "update " . $uname . "firstdb set dokuirisupu=1"; // コマンドに＜毒入りスープを飲む＞を追加
      @$result = pg_query($sql);
      if ($result == false) {
        print "DATA ACQUISITION ERROR\n";
        pg_close($con); // データベースとの接続を閉じる。
        exit;
      }
      pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
    } else { // 毒に銀のスプーンを選んだとき
      $text = "　スプーンが黒に変色した。ボロキレで拭っても色は戻りそうにない。";
    }

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem warning\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=sanityDecrease\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "findHowItemFailure") {

    $text = "　いまは使えないようだ。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=findHow\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "skill") {

    $sql = "select * from " . $uname . "skilldb"; // もちものの部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $tyouri = pg_fetch_result($result, 0, 0); // とってきた技能の状態を変数に入れる
    $kikimimi = pg_fetch_result($result, 0, 1);
    $mebosi = pg_fetch_result($result, 0, 2);
    $tyouyaku = pg_fetch_result($result, 0, 3);
    $genngogaku = pg_fetch_result($result, 0, 4);
    $igaku = pg_fetch_result($result, 0, 5);
    $iikurume = pg_fetch_result($result, 0, 6);
    $sinobiaruki = pg_fetch_result($result, 0, 7);
    $tosyokann = pg_fetch_result($result, 0, 8);
    $puroguraminngu = pg_fetch_result($result, 0, 9);
    $suiei = pg_fetch_result($result, 0, 10);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    print "<div class=\"comandContainer\">\n";

    if ($tyouri > 0) {
      print "<a href=\"main.php?skillNameFlag=tyouri&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜調理＞\n";
      print "</a>\n";
    }

    if ($kikimimi > 0) {
      print "<a href=\"main.php?skillNameFlag=kikimimi&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜利き耳＞\n";
      print "</a>\n";
    }

    if ($mebosi > 0) {
      print "<a href=\"main.php?skillNameFlag=mebosi&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜目星＞\n";
      print "</a>\n";
    }

    if ($tyouyaku > 0) {
      print "<a href=\"main.php?skillNameFlag=tyouyaku&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜跳躍＞\n";
      print "</a>\n";
    }

    if ($genngogaku > 0) {
      print "<a href=\"main.php?skillNameFlag=genngogaku&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜言語学＞\n";
      print "</a>\n";
    }

    if ($igaku > 0) {
      print "<a href=\"main.php?skillNameFlag=igaku&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜医学＞\n";
      print "</a>\n";
    }

    if ($iikurume > 0) {
      print "<a href=\"main.php?skillNameFlag=iikurume&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜言いくるめ＞\n";
      print "</a>\n";
    }

    if ($sinobiaruki > 0) {
      print "<a href=\"main.php?skillNameFlag=sinobiaruki&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜忍び歩き＞\n";
      print "</a>\n";
    }

    if ($tosyokann > 0) {
      print "<a href=\"main.php?skillNameFlag=tosyokann&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜図書館＞\n";
      print "</a>\n";
    }

    if ($puroguraminngu > 0) {
      print "<a href=\"main.php?skillNameFlag=puroguraminngu&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜プログラミング＞\n";
      print "</a>\n";
    }

    if ($suiei > 0) {
      print "<a href=\"main.php?skillNameFlag=suiei&skillJudgmentFlag=1\" class=\"comandItem\">\n";
      print "＜水泳＞\n";
      print "</a>\n";
    }

    print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
    print "←戻る\n";
    print "</a>\n";

    print "</div>\n";
  } else if ($command == "skillFailure") {

    if ($skillNameFlag == "tyouri") { // 技能の名前

      $skillName = "調理";
    } else if ($skillNameFlag == "kikimimi") {

      $skillName = "利き耳";
    } elseif ($skillNameFlag == "mebosi") {

      $skillName = "目星";
    } elseif ($skillNameFlag == "tyouyaku") {

      $skillName = "跳躍";
    } elseif ($skillNameFlag == "genngogaku") {

      $skillName = "言語学";
    } elseif ($skillNameFlag == "igaku") {

      $skillName = "医学";
    } elseif ($skillNameFlag == "iikurume") {

      $skillName = "言いくるめ";
    } elseif ($skillNameFlag == "sinobiaruki") {

      $skillName = "忍び歩き";
    } elseif ($skillNameFlag == "tosyokann") {

      $skillName = "図書館";
    } elseif ($skillNameFlag == "puroguraminngu") {

      $skillName = "プログラミング";
    } elseif ($skillNameFlag == "suiei") {

      $skillName = "水泳";
    }

    $text = "　" . $skillName . "に失敗した。";
    $time = $time - 1;

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?time=" . $time . "&command=skill\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "skillSuccess") {

    if ($skillNameFlag == "tyouri") { // 技能の名前

      $skillName = "調理";
    } else if ($skillNameFlag == "kikimimi") {

      $skillName = "利き耳";
    } elseif ($skillNameFlag == "mebosi") {

      $skillName = "目星";
    } elseif ($skillNameFlag == "tyouyaku") {

      $skillName = "跳躍";
    } elseif ($skillNameFlag == "genngogaku") {

      $skillName = "言語学";
    } elseif ($skillNameFlag == "igaku") {

      $skillName = "医学";
    } elseif ($skillNameFlag == "iikurume") {

      $skillName = "言いくるめ";
    } elseif ($skillNameFlag == "sinobiaruki") {

      $skillName = "忍び歩き";
    } elseif ($skillNameFlag == "tosyokann") {

      $skillName = "図書館";
    } elseif ($skillNameFlag == "puroguraminngu") {

      $skillName = "プログラミング";
    } elseif ($skillNameFlag == "suiei") {

      $skillName = "水泳";
    }

    $text = "　" . $skillName . "に成功した。";
    $time = $time - 1;

    if (($room == "east") && ($skillNameFlag == "mebosi") && ($kamikire == 0)) { // 東の部屋で目星に成功したとき

      if ($kamikire == 0) {

        $sql = "update " . $uname . "eastdb set kamikire=1";
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
      }

      if ($dannseinoitai == 0) {

        $sql = "update " . $uname . "eastdb set dannseinoitai=1";
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
      }

      print "<div class=\"textContainer\">\n";
      print "<span class=\"textItem\" id=\"ityped\"></span>\n";
      print "<a href=\"main.php?time=" . $time . "&command=skillSuccessMore\" class=\"next\">\n";
      print "つぎへ→\n";
      print "</a>\n";
      print "</div>\n";
    } else if (($room == "south") && ($skillNameFlag == "mebosi") && ($husiginazo == 0)) { // 南の部屋で目星に成功したとき

      if ($husiginazo == 0) {

        $sql = "update " . $uname . "southdb set husiginazo=1";
        @$result = pg_query($sql);
        if ($result == false) {
          print "DATA ACQUISITION ERROR\n";
          pg_close($con); // データベースとの接続を閉じる。
          exit;
        }
        pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。
      }

      print "<div class=\"textContainer\">\n";
      print "<span class=\"textItem\" id=\"ityped\"></span>\n";
      print "<a href=\"main.php?time=" . $time . "&command=skillSuccessMore\" class=\"next\">\n";
      print "つぎへ→\n";
      print "</a>\n";
      print "</div>\n";
    } else {

      print "<div class=\"textContainer\">\n";
      print "<span class=\"textItem\" id=\"ityped\"></span>\n";
      print "<a href=\"main.php?time=" . $time . "&command=skillSuccessNoeffect\" class=\"next\">\n";
      print "つぎへ→\n";
      print "</a>\n";
      print "</div>\n";
    }
  } else if ($command == "skillSuccessMore") {

    $text = "　この部屋はもっと調べられそうだ。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=skill\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "skillSuccessNoeffect") {

    $text = "　しかし何も起こらなかった。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=skill\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "item") {

    $sql = "select * from " . $uname . "itemdb"; // もちものの部屋の状態をとってくる

    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる
      exit;
    }

    $syojoItem = pg_fetch_result($result, 0, 0); // とってきたもちものの部屋の状態を変数に入れる
    $hotyoItem = pg_fetch_result($result, 0, 1);
    $ginnnosupunnItem = pg_fetch_result($result, 0, 2);
    $dennkyunonakanodokuItem = pg_fetch_result($result, 0, 3);
    $honnnohyosinodokuItem = pg_fetch_result($result, 0, 4);

    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    print "<div class=\"comandContainer\">\n";

    if ($syojoItem == 1) {
      print "<a href=\"main.php?command=text&textNumber=400\" class=\"comandItem\">\n";
      print "＜少女＞\n";
      print "</a>\n";
    }

    if ($hotyoItem == 1) {
      print "<a href=\"main.php?command=text&textNumber=410\" class=\"comandItem\">\n";
      print "＜包丁＞\n";
      print "</a>\n";
    }

    if ($ginnnosupunnItem == 1) {
      print "<a href=\"main.php?command=text&textNumber=420\" class=\"comandItem\">\n";
      print "＜銀のスプーン＞\n";
      print "</a>\n";
    }

    if ($dennkyunonakanodokuItem == 1) {
      print "<a href=\"main.php?command=text&textNumber=430\" class=\"comandItem\">\n";
      print "＜電球の中の液体＞\n";
      print "</a>\n";
    }

    if ($honnnohyosinodokuItem == 1) {
      print "<a href=\"main.php?command=text&textNumber=440\" class=\"comandItem\">\n";
      print "＜本の表紙の毒＞\n";
      print "</a>\n";
    }

    print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
    print "←戻る\n";
    print "</a>\n";

    print "</div>\n";
  } else if ($command == "move") {

    $time = $time - 1;

    if ($room == 'first') {

      print "<div class=\"comandContainer\">\n";

      print "<a href=\"main.php?command=command&room=east&time=" . $time . "\" class=\"comandItem\">\n";
      print "＜東の部屋＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=command&room=west&time=" . $time . "\" class=\"comandItem\">\n";
      print "＜西の部屋＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=command&room=north&time=" . $time . "\" class=\"comandItem\">\n";
      print "＜北の部屋＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=command&room=south&time=" . $time . "\" class=\"comandItem\">\n";
      print "＜南の部屋＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
      print "←戻る\n";
      print "</a>\n";

      print "</div>\n";
    } else if ($room == "south") {

      if ($kaibutu == 1) { // 南の部屋に番人がいるとき

        print "<div class=\"comandContainer\">\n";

        print "<a href=\"main.php?command=text&time=" . $time . "&textNumber=500\" class=\"comandItem\">\n";
        print "＜最初の部屋＞\n";
        print "</a>\n";

        print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
        print "←戻る\n";
        print "</a>\n";
      } else {

        print "<div class=\"comandContainer\">\n";

        print "<a href=\"main.php?command=command&room=first&time=" . $time . "\" class=\"comandItem\">\n";
        print "＜最初の部屋＞\n";
        print "</a>\n";

        print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
        print "←戻る\n";
        print "</a>\n";
      }
    } else {

      print "<div class=\"comandContainer\">\n";

      print "<a href=\"main.php?command=command&room=first&time=" . $time . "\" class=\"comandItem\">\n";
      print "＜最初の部屋＞\n";
      print "</a>\n";

      print "<a href=\"main.php?command=command\" class=\"comandItem\">\n";
      print "←戻る\n";
      print "</a>\n";
    }
  } else if ($command == "text") {

    if ($textNumber == 0) { // プロローグ

      $text = "　目を覚ますと、そこは薄暗い部屋の中だった。壁も床もコンクリートでできた、四方に扉がある部屋だ。";
      $nextCommand = "text";
      $nextTextNumber = 1;
    } else if ($textNumber == 1) {

      $text = "　身につけているのは一枚のぼろきれのみで、ほかには何も持っていない。";
      $nextCommand = "text";
      $nextTextNumber = 2;
    } else if ($textNumber == 2) {

      $text = "　部屋の中央にはテーブルがあり、その上には何かが入った木製の器と紙切れがある。";
      $nextCommand = "text";
      $nextTextNumber = 3;
    } else if ($textNumber == 3) {

      $text = "　なにか手がかりを得られるかもしれない。調べてみよう。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 400) { // もちもの 少女

      $text = "　虚ろな目をした少女が私のボロキレを掴んでいる。どうやら私についてきたいようだ。";
      $nextCommand = "text";
      $nextTextNumber = 401;
    } else if ($textNumber == 401) {

      $text = "　声をかけてみても、頷いたり首を振ったりするだけで、決して言葉を口にしようとしない。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 410) { // もちもの 包丁`

      $text = "　北の部屋にあった、ごく普通の包丁だ。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 420) { // もちもの 銀のスプーン

      $text = "　銀でできたスプーンだが、きっと武器にはならないだろう。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 430) { // もちもの 電球の中の液体

      $text = "　電球の中に、ほんのりと甘い香りのする、粘り気のある黒い液体が入っている。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 440) { // もちもの 本の表紙の毒

      $text = "　黒い蓮から作られた猛毒だ。傷口につかないようにしよう。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 460) { // 時間切れのとき

      $text = "　南の部屋から、なにかが動く音がする。";
      $nextCommand = "text";
      $nextTextNumber = 461;
    } else if ($textNumber == 461) {

      $text = "　扉を破り、巨大な像がこちらに襲いかかってきた。";
      $nextCommand = "badEnd";
      $nextTextNumber = -1;
    } else if ($textNumber == 470) { // 南の部屋で時間切れのとき

      $text = "　部屋の中の像が動き出し、こちらに襲いかかってきた。";
      $nextCommand = "badEnd";
      $nextTextNumber = -1;
    } else if ($textNumber == 480) { // true end

      $text = "　スープを飲み干すと、毒がじわじわと体内に回り始めた。";
      $nextCommand = "text";
      $nextTextNumber = 481;
    } else if ($textNumber == 481) {

      $text = "　やがて、私の視界は真っ白になった。";
      $nextCommand = "text";
      $nextTextNumber = 482;
    } else if ($textNumber == 482) {

      $text = "　・・・・・・";
      $nextCommand = "text";
      $nextTextNumber = 483;
    } else if ($textNumber == 483) {

      $text = "　どこからか、吠えるような声が響いてくる。";
      $nextCommand = "text";
      $nextTextNumber = 484;
    } else if ($textNumber == 484) {

      $text = "「勇敢なる者よ！　現へと還るがいい！」";
      $nextCommand = "text";
      $nextTextNumber = 485;
    } else if ($textNumber == 485) {

      $text = "　・・・・・・";
      $nextCommand = "text";
      $nextTextNumber = 486;
    } else if ($textNumber == 486) {

      $text = "　私は、昨夜眠っていた場所で目を覚ました。";
      $nextCommand = "text";
      $nextTextNumber = 487;
    } else if ($textNumber == 487) {

      $text = "　無事に朝を迎えたのだ。";
      $nextCommand = "trueEnd";
      $nextTextNumber = -1;
    } else if ($textNumber == 490) {

      $text = "　私が東の部屋を後にすると、少女は立ち上がり私についてきた。";
      $nextCommand = "text";
      $nextTextNumber = 491;
    } else if ($textNumber == 491) {

      $text = "　どうやら、私と行動を共にするようだ。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    } else if ($textNumber == 500) {

      $text = "　怪物に回り込まれ、扉に近づくことができない。";
      $nextCommand = "command";
      $nextTextNumber = -1;
    }

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?command=" . $nextCommand . "&textNumber=" . $nextTextNumber . "\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "sanityDecrease") { // 正気度が減少したとき

    if (($findNameFlag == "memoura") && (($skillNameFlag == "mebosi") || ($skillNameFlag == "igaku"))) { // メモ(裏)で目星か医学が成功したとき

      $nextCommand = "find";
      $sanityDecrease = 15;
    } else if ($findNameFlag == "dennkyu") { // 電球を調べたとき

      $nextCommand = "find";
      $sanityDecrease = 10;
    } else if (($findNameFlag == "minaminotobira") && ($skillNameFlag == "kikimimi")) { // 南の扉で利き耳が成功したとき

      $nextCommand = "find";
      $sanityDecrease = 20;
    } else if (($findNameFlag == "dennkyunonakanoekitai") && ($skillNameFlag == "igaku")) {

      $nextCommand = "find";
      $sanityDecrease = 20;
    } else if (($findNameFlag == "kinoutuwa") && (($itemNameFlag == "dennkyunonakanodoku") || ($itemNameFlag == "honnnohyosinodoku"))) { // スープに毒を入れたとき

      $nextCommand = "find";
      $sanityDecrease = 20;
    } else if ((($findNameFlag == "dennkyunonakanoekitai") || ($findNameFlag == "makkuronahonn")) && ($itemNameFlag == "ginnnosupunn")) { // スプーンが変色したとき

      $nextCommand = "find";
      $sanityDecrease = 10;
    } else if ($findNameFlag == "dannseinoitai") {

      $nextCommand = "find";
      $sanityDecrease = 30;
    } else if (($findNameFlag == "honndana") && ($skillNameFlag == "tosyokann")) {

      $nextCommand = "find";
      $sanityDecrease = 20;
    } else if ($findNameFlag == "gasukonnro") {

      $nextCommand = "find";
      $sanityDecrease = 10;
    } else if ($findNameFlag == "tyoridai") {

      $nextCommand = "find";
      $sanityDecrease = 10;
    } else if ($findNameFlag == "nabenonaka") {

      $nextCommand = "find";
      $sanityDecrease = 30;
    } else if ($findNameFlag == "kaibutu") {

      $nextCommand = "find";
      $sanityDecrease = 10;
    } else if ($findNameFlag == "kaibutunitikazuku") {

      $nextCommand = "sanityDecrease";
      $sanityDecrease = 20;
    } else if ($findNameFlag == "syojowosakiniikaseru") {

      $nextCommand = "find";
      $sanityDecrease = 20;
    } else if ($findNameFlag == "kataudewokittesasidasu") {

      $nextCommand = "find";
      $sanityDecrease = 20;
    } else if ($findNameFlag == "zonokatawaranosekibann") {

      $nextCommand = "find";
      $sanityDecrease = 10;
    } else if ($findNameFlag == "husiginazo") {

      $nextCommand = "find";
      $sanityDecrease = 10;
    }

    $text = "　正気度が" . $sanityDecrease . "減少した。";

    $sanity = $sanity - $sanityDecrease;

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem warning\" id=\"ityped\"></span>\n";
    print "<a href=\"main.php?time=" . $time . "&sanity=" . $sanity . "&command=" . $nextCommand . "\" class=\"next\">\n";
    print "つぎへ→\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "trueEnd") {

    $sql = "update " . $uname . "statedb set sanity=100, time=60, room='first', command='text', arm=1, skillNameFlag='non', itemNameFlag='non', findNameFlag='non', textNumber=0, skillJudgmentFlag=0"; // ユーザの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "firstdb set memoomote=1, tizu=1, kitanotobira=1, minaminotobira=1, nisinotobira=1, higasinotobira=1, kinoutuwa=1, memoura=0, dennkyu=1, dennkyunonakanoekitai=0, dokuirisupu=0"; // 最初の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "westdb set rosoku=1, memo=1, honndana=1, makkuronahonn=0, supunoyumenituite=0"; // 西の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "northdb set mamedennkyu=1, gasukonnro=1, araiba=1, tyoridai=1, syokkidana=1, memo=1, hotyo=1, ginnironosupunn=0, nabe=1, nabenonaka=0"; // 北の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "eastdb set syojo=1, syojonihanasikakeru=1, syojonihureru=1, syojowohipparu=1, kamikire=0, dannseinoitai=0"; // 東の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "southdb set kaibutu=1, kaibutunitikazuku=1, syojowosakiniikaseru=0, kataudewokittesasidasu=0, husiginazo=0, zonokatawaranosekibann=0, kamikire=0"; // 南の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "itemdb set syojo=0, hotyo=0, ginnnosupunn=0, dennkyunonakanodoku=0, honnnohyosinodoku=0"; // もちものの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $text = "　あの妙な部屋はどこにもなく、負ったはずの怪我はすべて消えていた。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem \" id=\"ityped\"></span>\n";
    print "<a href=\"index.html\" class=\"next\">\n";
    print "ホームへ\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "badEnd") { // badend

    $sql = "update " . $uname . "statedb set sanity=100, time=60, room='first', command='text', arm=1, skillNameFlag='non', itemNameFlag='non', findNameFlag='non', textNumber=0, skillJudgmentFlag=0"; // ユーザの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "firstdb set memoomote=1, tizu=1, kitanotobira=1, minaminotobira=1, nisinotobira=1, higasinotobira=1, kinoutuwa=1, memoura=0, dennkyu=1, dennkyunonakanoekitai=0, dokuirisupu=0"; // 最初の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "westdb set rosoku=1, memo=1, honndana=1, makkuronahonn=0, supunoyumenituite=0"; // 西の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "northdb set mamedennkyu=1, gasukonnro=1, araiba=1, tyoridai=1, syokkidana=1, memo=1, hotyo=1, ginnironosupunn=0, nabe=1, nabenonaka=0"; // 北の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "eastdb set syojo=1, syojonihanasikakeru=1, syojonihureru=1, syojowohipparu=1, kamikire=0, dannseinoitai=0"; // 東の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "southdb set kaibutu=1, kaibutunitikazuku=1, syojowosakiniikaseru=0, kataudewokittesasidasu=0, husiginazo=0, zonokatawaranosekibann=0, kamikire=0"; // 南の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "itemdb set syojo=0, hotyo=0, ginnnosupunn=0, dennkyunonakanodoku=0, honnnohyosinodoku=0"; // もちものの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $text = "　私は、なすすべもなく殺されてしまった。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem warning\" id=\"ityped\"></span>\n";
    print "<a href=\"index.html\" class=\"next\">\n";
    print "ホームへ\n";
    print "</a>\n";
    print "</div>\n";
  } else if ($command == "sanity0") { // 正気度が0以下

    $sql = "update " . $uname . "statedb set sanity=100, time=60, room='first', command='text', arm=1, skillNameFlag='non', itemNameFlag='non', findNameFlag='non', textNumber=0, skillJudgmentFlag=0"; // ユーザの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR1\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "firstdb set memoomote=1, tizu=1, kitanotobira=1, minaminotobira=1, nisinotobira=1, higasinotobira=1, kinoutuwa=1, memoura=0, dennkyu=1, dennkyunonakanoekitai=0, dokuirisupu=0"; // 最初の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR2\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "westdb set rosoku=1, memo=1, honndana=1, makkuronahonn=0, supunoyumenituite=0"; // 西の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR3\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "northdb set mamedennkyu=1, gasukonnro=1, araiba=1, tyoridai=1, syokkidana=1, memo=1, hotyo=1, ginnironosupunn=0, nabe=1, nabenonaka=0"; // 北の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR4\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "eastdb set syojo=1, syojonihanasikakeru=1, syojonihureru=1, syojowohipparu=1, kamikire=0, dannseinoitai=0"; // 東の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR5\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "southdb set kaibutu=1, kaibutunitikazuku=1, syojowosakiniikaseru=0, kataudewokittesasidasu=0, husiginazo=0, zonokatawaranosekibann=0, kamikire=0"; // 南の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR6\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "itemdb set syojo=0, hotyo=0, ginnnosupunn=0, dennkyunonakanodoku=0, honnnohyosinodoku=0"; // もちものの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR7\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $text = "　正気を失った私は、自ら死を選んだ。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem warning\" id=\"ityped\"></span>\n";
    print "<a href=\"index.html\" class=\"next\">\n";
    print "ホームへ\n";
    print "</a>\n";
    print "</div>\n";
  } else { // 少女に拳銃で撃たれたとき

    $sql = "update " . $uname . "statedb set sanity=100, time=60, room='first', command='text', arm=1, skillNameFlag='non', itemNameFlag='non', findNameFlag='non', textNumber=0, skillJudgmentFlag=0"; // ユーザの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR1\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "firstdb set memoomote=1, tizu=1, kitanotobira=1, minaminotobira=1, nisinotobira=1, higasinotobira=1, kinoutuwa=1, memoura=0, dennkyu=1, dennkyunonakanoekitai=0, dokuirisupu=0"; // 最初の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR2\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "westdb set rosoku=1, memo=1, honndana=1, makkuronahonn=0, supunoyumenituite=0"; // 西の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR3\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "northdb set mamedennkyu=1, gasukonnro=1, araiba=1, tyoridai=1, syokkidana=1, memo=1, hotyo=1, ginnironosupunn=0, nabe=1, nabenonaka=0"; // 北の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR4\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "eastdb set syojo=1, syojonihanasikakeru=1, syojonihureru=1, syojowohipparu=1, kamikire=0, dannseinoitai=0"; // 東の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR5\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "southdb set kaibutu=1, kaibutunitikazuku=1, syojowosakiniikaseru=0, kataudewokittesasidasu=0, husiginazo=0, zonokatawaranosekibann=0, kamikire=0"; // 南の部屋の状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR6\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $sql = "update " . $uname . "itemdb set syojo=0, hotyo=0, ginnnosupunn=0, dennkyunonakanodoku=0, honnnohyosinodoku=0"; // もちものの状態を初期化
    @$result = pg_query($sql);
    if ($result == false) {
      print "DATA ACQUISITION ERROR7\n";
      pg_close($con); // データベースとの接続を閉じる。
      exit;
    }
    pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

    $text = "　銃弾を浴びた私の意識は途絶えてしまった。";

    print "<div class=\"textContainer\">\n";
    print "<span class=\"textItem warning\" id=\"ityped\"></span>\n";
    print "<a href=\"index.html\" class=\"next\">\n";
    print "ホームへ\n";
    print "</a>\n";
    print "</div>\n";
  }

  print "</div>\n";

  pg_close($con); // データベースとの接続を閉じる

  if (($command == "text") || ($command == "skillFailure") || ($command == "skillSuccess") || ($command == "skillSuccessMore") || ($command == "skillSuccessNoeffect") || ($command == "findHowSkillSuccess") || ($command == "findHowSkillFailure") || ($command = "findHowSkillSuccessExp") || ($command = "findHowExp") || ($command == "findHowItemSuccess") || ($command = "findHowItemFailure") || ($command == "sanityDecrease") || ($command == "trueEnd") || ($command == "badEnd")) { // 文字にアニメーションをつける
    print "<script src=\"https://unpkg.com/ityped@1.0.3\"></script>";
    print "<script>\n";
    print "ityped.init(document.querySelector(\"#ityped\"), {\n";
    print "strings: ['" . $text . "'],\n"; //表示させたい文字の設定 区切りはカンマ 
    print "startDelay: 200,\n"; //アニメーション開始までの遅延、大きいほど遅れる
    print "typeSpeed: 30,\n"; //表示させるスピード、大きいほどゆっくり
    print "loop: false,\n"; //ループ
    print "backSpeed: 80,\n"; //戻るスピード
    print "backDelay: 150,\n"; //戻る時間指定
    print "showCursor: false,\n"; //カーソル表示
    print "})\n";
    print "</script>\n";
  }

  ?>

</body>

</html>