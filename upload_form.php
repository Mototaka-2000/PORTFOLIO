<?php
// フォーム
require_once '../classes/UserLogic.php';
require_once '../dbc/dbc.php';
require_once "dbc.php";
$files = getAllFile();

session_start();

// //エラーメッセージ
$err = [];

 if ($_POST) {
 // POSTデータ処理ここから
 $email = filter_input(INPUT_POST, 'email');
 if (empty($email)) $err['email'] = 'メールアドレスを記入してください。';
 $password = filter_input(INPUT_POST, 'password');
 if (empty($password)) $err['password'] = 'パスワードを記入してください。';
 if (count($err) > 0) {
  $_SESSION = $err;
  header('Location: ../public/login_form.php');
  exit;
  }
  if (UserLogic::login($email, $password) === false) {
  header('Location: ../public/login_form.php');
  exit;
  }
  // POSTデータ処理ここまで
  } else {
  // セッションデータチェック
  if (UserLogic::checkLogin() === false) {
  header('Location: ../public/login_form.php');
  exit;
  }
  }

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>アップロードフォーム</title>
  </head>
  <style>
    body {
      padding: 30px;
      margin: 0 auto;
      width: 50%;
      background-color: #CCFFFF;
    }
    textarea {
      width: 98%;
      height: 60px;
    }
    .file-up {
      margin-bottom: 10px;
    }
    .submit {
      text-align: right;
    }
    .btn {
      display: inline-block;
      border-radius: 3px;
      font-size: 18px;
      background: #67c5ff;
      border: 2px solid #67c5ff;
      padding: 5px 10px;
      color: #fff;
      cursor: pointer;
    }
  </style>

  <body>
    <form enctype="multipart/form-data" action="./file_upload.php" method="POST">
      <div class="file-up">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <input name="img" type="file" accept="image/*" />
        <a href="../public/mypage.php">マイページへ</a>
        </div>

      <div>
        <textarea
          name="caption"
          placeholder="キャプション（140文字以下）"
          id="caption"
        ></textarea>
      </div>

      <div class="submit">
        <input type="submit" value="送信" class="btn" />
      </div>
    </form>
    <div>
      <?php foreach($files as $file): ?>
      <img src=<?php echo "{$file['file_path']}"; ?> alt="">
      <p><?php echo h("{$file['description']}"); ?></p>
      <?php endforeach; ?>
    </div>
  </body>
</html>