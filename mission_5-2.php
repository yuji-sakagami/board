<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-2</title>
</head>
<body>
    <?php
        // データベースに接続 // DB接続情報消去済み
        $dsn = 'mysql:dbname=co_***_it_3919_com;host=localhost';
        $user = 'co-***.it.3919.c';
        $password = 'PASSWORD';
        $pdo = new PDO($dsn,$user,$password);
        
        // CREATE文：データベース内にテーブルを作成
        $sql = "CREATE TABLE IF NOT EXISTS tb_5_2"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "time datetime,"
        . "pass TEXT"
        .");";
        $stmt = $pdo->query($sql);
        
        
        // INSERT文：データを入力（データレコードの挿入）
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit1'])){
                if (!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["edit_n"]) && !empty($_POST["pass_new"])){  //投稿の追加
                    
                    $sql = $pdo -> prepare("INSERT INTO tb_5_2 (name, comment, time, pass) VALUES (:name, :comment, :time, :pass)");
                    $sql -> bindParam(':name', $name, PDO::PARAM_STR);  // bindParam ... 指定された変数名にパラメータをバインドする
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':time', $time, PDO::PARAM_STR);
                    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                    
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $pass = $_POST["pass_new"];
                    $time = date("Y/m/d H:i:s");
                    $sql -> execute();
                }
            }
        }
        
        
        
        // 投稿の消去
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit2'])){
                if (!empty($_POST["del"]) && !empty($_POST["pass_del"])){  //投稿の削除
                    // データとパスワードの照合
                    $del = $_POST["del"];
                    $pass_del = $_POST["pass_del"];
                    
                    $sql = 'SELECT * FROM tb_5_2 where id=:del';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':del', $del, PDO::PARAM_INT);
                    $stmt->execute();
                    $results = $stmt->fetch();
                    
                    $id = $results['id'];
                    $comment = $results['comment'];
                    $pass = $results['pass'];
                    
                    echo $id;
                    echo $pass;
                    
                    if ($id==$del && $pass==$pass_del){
                        // データの抽出
                        $sql = 'SELECT * FROM tb_5_2';
                        $stmt = $pdo->query($sql);
                        $results = $stmt->fetchAll();
                        // テーブルの消去
                        $sql = 'DROP TABLE tb_5_2';
                        $stmt = $pdo->query($sql);
                        // テーブルの作成
                        $sql = "CREATE TABLE IF NOT EXISTS tb_5_2"
                        ." ("
                        . "id INT AUTO_INCREMENT PRIMARY KEY,"
                        . "name char(32),"
                        . "comment TEXT,"
                        . "time datetime,"
                        . "pass TEXT"
                        .");";
                        $stmt = $pdo->query($sql);
                        
                        // データの挿入
                        foreach ($results as $row){
                            $id = $row['id'];
                            if ($id != $del){
                                $sql = $pdo -> prepare("INSERT INTO tb_5_2 (name, comment, time, pass) VALUES (:name, :comment, :time, :pass)");
                                $sql -> bindParam(':name', $name, PDO::PARAM_STR);  // bindParam ... 指定された変数名にパラメータをバインドする
                                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                                $sql -> bindParam(':time', $time, PDO::PARAM_STR);
                                $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                                
                                $name = $row['name'];
                                $comment = $row['comment'];
                                $time = $row['time'];
                                $pass = $row['pass'];
                                $sql -> execute();
                            }
                        }
                    }
                }
            }
        }
            

        // 編集の選択
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit3'])){
                if (!empty($_POST["edit"]) && !empty($_POST["pass_edit"])){  //投稿の編集を選択
                    // データとパスワードの照合
                    $edit = $_POST["edit"];
                    $pass_edit = $_POST["pass_edit"];
                    
                    $sql = 'SELECT * FROM tb_5_2 where id=:edit';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':edit', $edit, PDO::PARAM_INT);
                    $stmt->execute();
                    $results = $stmt->fetch();
                    
                    $id = $results['id'];
                    $pass = $results['pass'];
                    
                    if ($id==$edit && $pass==$pass_edit){
                        $editnumber = $results['id'];
                        $editname = $results['name'];
                        $editcomment = $results['comment'];
                    }
                }
            }
        }
        
 
        // データの編集
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit1'])){
                if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["edit_n"]) && !empty($_POST["pass_new"])){  //投稿の編集
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $edit_n = $_POST["edit_n"];
                    $pass_new = $_POST["pass_new"];
                    $time = date("Y/m/d H:i:s");
                    
                    $sql = 'UPDATE tb_5_2 SET name=:name, comment=:comment, time=:time, pass=:pass WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $edit_n, PDO::PARAM_STR);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
                    $stmt->bindParam(':pass', $pass_new, PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
        }
                    
                    
    ?>
    
    <form action="" method="post">
        <?= "【　投稿フォーム　】<br>" ?>
        <?= "名前：　　　　" ?>
        <input type="text" name="name" value="<?php if(isset($editname)) {echo $editname;} ?>"><br>
        <?= "コメント：　　" ?>
        <input type="text" name="comment" value="<?php if(isset($editcomment)) {echo $editcomment;} ?>"><br>
        <?= "パスワード：　" ?>
        <input type="password" name="pass_new" ><br>
        <input type="hidden" name="edit_n" value="<?php if(isset($editnumber)) {echo $editnumber;} ?>">
        <input type="submit" name="submit1"><br><br>
        
        <?= "【　削除フォーム　】<br>" ?>
        <?= "投稿番号：　　" ?>
        <input type="number" name="del"><br>
        <?= "パスワード：　" ?>
        <input type="password" name="pass_del"><br>
        <input type="submit" name="submit2"><br><br>
        
        <?= "【　編集フォーム　】<br>" ?>
        <?= "投稿番号：　　" ?>
        <input type="number" name="edit"><br>
        <?= "パスワード：　" ?>
        <input type="password" name="pass_edit"><br>
        <input type="submit" name="submit3"><br>
    </form>
    
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){  //新規投稿のエラー
            if (isset($_POST['submit1'])){
                if (empty($_POST["name"])){
                    echo "!---------------!<br>";
                    echo "Error: Name is Empty.<br>";
                    echo "!---------------!<br><br>";
                }elseif (!empty($_POST["name"]) && empty($_POST["comment"])){
                    echo "!---------------!<br>";
                    echo "Error: Comment is Empty.<br>";
                    echo "!---------------!<br><br>";
                }elseif (!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["pass_new"])){
                    echo "!---------------!<br>";
                    echo "Error: Password is Empty.<br>";
                    echo "!---------------!<br><br>";
                }
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){  //削除フォームのエラー
            if (isset($_POST['submit2'])){
                if (empty($_POST["del"])){
                    echo "!---------------!<br>";
                    echo "Error: Delite-Number is Empty.<br>";
                    echo "!---------------!<br><br>";
                }elseif (!empty($_POST["del"]) && empty($_POST["pass_del"])){
                    echo "!---------------!<br>";
                    echo "Error: Password is Empty.<br>";
                    echo "!---------------!<br><br>";
                }elseif (!empty($_POST["del"]) && !empty($_POST["pass_del"])){
                    // データとパスワードの照合
                    $del = $_POST["del"];
                    $pass_del = $_POST["pass_del"];
                    
                    $sql = 'SELECT * FROM tb_5_2 where id=:del';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':del', $del, PDO::PARAM_INT);
                    $stmt->execute();
                    $results = $stmt->fetch();
                    
                    $id = $results['id'];
                    $pass = $results['pass'];
                    
                    if ($id==$del && $pass!=$pass_del){
                            echo "!---------------!<br>";
                            echo "Error: Password is invalid.<br>";
                            echo "!---------------!<br><br>";
                    }
                }
            }
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){  //編集フォームのエラー
            if (isset($_POST['submit3'])){
                if (empty($_POST["edit"])){
                    echo "!---------------!<br>";
                    echo "Error: Edit-Number is Empty.<br>";
                    echo "!---------------!<br><br>";
                }elseif (!empty($_POST["edit"]) && empty($_POST["pass_edit"])){
                    echo "!---------------!<br>";
                    echo "Error: Password is Empty.<br>";
                    echo "!---------------!<br><br>";
                }elseif (!empty($_POST["edit"]) && !empty($_POST["pass_edit"])){
                    // データとパスワードの照合
                    $edit = $_POST["edit"];
                    $pass_edit = $_POST["pass_edit"];
                    
                    $sql = 'SELECT * FROM tb_5_2 where id=:edit';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':edit', $edit, PDO::PARAM_INT);
                    $stmt->execute();
                    $results = $stmt->fetch();
                    
                    $id = $results['id'];
                    $pass = $results['pass'];
                    
                    if ($id==$edit && $pass==$pass_edit){
                        echo "id".$edit."を編集します<br>";
                    }elseif ($id==$edit && $pass!=$pass_edit){
                        echo "!---------------!<br>";
                        echo "Error: Password is invalid.<br>";
                        echo "!---------------!<br><br>";
                    }
                }
            }
        }
        
        
        echo "<br>-------------------------------------------<br>";
        echo "【　データ一覧　】<br><br>";
        // データの表示
        $sql = 'SELECT * FROM tb_5_2';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].'. ';
            echo $row['name'].' 「';
            echo $row['comment'].'」 ';
            echo $row['time'].'<br>';
            // echo $row['pass'].'<br>';  // 確認用
            echo "<hr>"; // 水平な横線を引く
        } 
    ?>
</body>
</html>