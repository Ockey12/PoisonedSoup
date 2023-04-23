<!DOCTYPE html>

<html lang="ja">

<head>
  <link rel="stylesheet" type="text/css" href="css/register.css">
  <title>
    ユーザ登録
  </title>
  <meta charset="utf-8">
</head>

<body>

  <?php

  if (($_POST['uname'] == null) || ($_POST['pass'] == null)) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>ユーザ名またはパスワードが入力されていません。</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";

    exit;
  }

  $tyouri = (int) $_POST['tyouri'];
  $kikimimi  = (int) $_POST['kikimimi'];
  $mebosi  = (int) $_POST['mebosi'];
  $tyouyaku  = (int) $_POST['tyouyaku'];
  $genngogaku  = (int) $_POST['genngogaku'];
  $igaku  = (int) $_POST['igaku'];
  $iikurume  = (int) $_POST['iikurume'];
  $sinobiaruki  = (int) $_POST['sinobiaruki'];
  $tosyokann  = (int) $_POST['tosyokann'];
  $puroguraminngu  = (int) $_POST['puroguraminngu'];
  $suiei  = (int) $_POST['suiei'];

  if ($tyouri + $kikimimi + $mebosi + $tyouyaku + $genngogaku + $igaku + $iikurume + $sinobiaruki + $tosyokann + $puroguraminngu + $suiei != 100) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>合計が100になるように技能にポイントを割り振ってください。</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";

    exit;
  }

  // データベースへの接続
  @$con = pg_connect("!SECRET!");
  if ($con == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>DATABASE CONNECTION ERROR1</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }


  $sql = "select uname from poisonUnamePassDb where uname = '{$_POST['uname']}'"; // SQLのコマンド文を文字列に格納する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>DATA ACQUISITION ERROR1</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  $rows = pg_num_rows($result);

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  if ($rows > 0) { // 入力されたユーザ名が、データベースの中に１つ以上ある時は「登録済み」

    pg_close($con); // データベースとの接続を閉じる。

    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>そのユーザ名は登録済みです。</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";

    exit;
  }

  $sql = "insert into poisonUnamePassDb values('{$_POST['uname']}','{$_POST['pass']}')"; // テーブルpoisonUnamePassDbに、ユーザ名とパスワードを登録する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>DATA INSERTION ERROR1</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }
  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。


  $sql = "create table {$_POST['uname']}StateDb (sanity int, time int, room text, command text, arm int, skillNameFlag text , itemNameFlag text, findNameFlag text, textNumber int, skillJudgmentFlag int)"; // 正気度、残り時間、部屋、コマンド、腕の状態、スキル番号、フラグ、テキスト番号、スキル判定フラグを保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR1</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}StateDb values(100, 60, 'first', 'text', 1, 'non', 'non', 'non', 0, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR2</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}FirstDb (memoomote int, tizu int, kitanotobira int, minaminotobira int, nisinotobira int, higasinotobira int, kinoutuwa int, memoura int,  dennkyu int, dennkyunonakanoekitai int, dokuirisupu int)"; // 最初の部屋の状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR3</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}FirstDb values(1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR4</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}WestDb (rosoku int, memo int, honndana int, makkuronahonn int, supunoyumenituite int)"; // 西の部屋の状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR5</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}WestDb values(1, 1, 1, 0, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR6</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}NorthDb (mamedennkyu int, gasukonnro int, araiba int, tyoridai int, syokkidana int, memo int, hotyo int, ginnironosupunn int, nabe int, nabenonaka int)"; // 北の部屋の状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR7</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}NorthDb values(1, 1, 1, 1, 1, 1, 1, 0, 1, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR8</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}EastDb (syojo int, syojonihanasikakeru int, syojonihureru int, syojowohipparu int, kamikire int, dannseinoitai int)"; // 東の部屋の状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR9</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}EastDb values(1, 1, 1, 1, 0, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR10</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}SouthDb (kaibutu int, kaibutunitikazuku int, syojowosakiniikaseru int, kataudewokittesasidasu int, husiginazo int, zonokatawaranosekibann int, kamikire int)"; // 南の部屋の状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR11</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}SouthDb values(1, 1, 0, 0, 0, 0, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR12</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}ItemDb (syojo int, hotyo int, ginnnosupunn int, dennkyunonakanodoku int, honnnohyosinodoku int)"; // もちものの状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR13</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "insert into {$_POST['uname']}ItemDb values(0, 0, 0, 0, 0)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR14</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }

  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $sql = "create table {$_POST['uname']}SkillDb (tyouri int, kikimimi int, mebosi int, tyouyaku int, genngogaku int, igaku int, iikurume int, sinobiaruki int, tosyokann int, puroguraminngu int, suiei int)"; // 技能の状態を保存するデータベースを作成する。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR15</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }
  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  $tyouri = (int)$_POST['tyouri'];
  $kikimimi = (int)$_POST['kikimimi'];
  $mebosi = (int)$_POST['mebosi'];
  $tyouyaku = (int)$_POST['tyouyaku'];
  $genngogaku = (int)$_POST['genngogaku'];
  $igaku = (int)$_POST['igaku'];
  $iikurume = (int)$_POST['iikurume'];
  $sinobiaruki = (int)$_POST['sinobiaruki'];
  $tosyokann = (int)$_POST['tosyokann'];
  $puroguraminngu = (int)$_POST['puroguraminngu'];
  $suiei = (int)$_POST['suiei'];

  $sql = "insert into {$_POST['uname']}SkillDb values($tyouri, $kikimimi, $mebosi, $tyouyaku, $genngogaku, $igaku, $iikurume, $sinobiaruki, $tosyokann, $puroguraminngu, $suiei)"; // 初期値を入れる。

  @$result = pg_query($sql); // SQLのコマンドでデータベースに問い合わせする。
  if ($result == false) {
    print "<div class=\"mainContainer\">\n";
    print "<div class=\"mainItems\">\n";
    print "<p>TABLE CREATION ERROR16</p>\n";
    print "<a href=\"register.html\" class=\"comandItem\">←戻る</a>\n";
    print "</div>\n";
    print "</div>\n";
    print "</body>\n";
    print "</html>\n";
    exit;
  }
  pg_free_result($result); // SQLの実行結果を格納していたメモリを解放。

  pg_close($con); // データベースとの接続を閉じる。
  ?>

  <div class="mainContainer">
    <div class="mainItems">
      <p>
        ユーザを登録しました。
      </p>
      <a href="index.html" class="comandItem">
        ←戻る
      </a>
    </div>
  </div>

</body>

</html>