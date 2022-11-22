<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    <?php
        $filename="mission_3-5.txt";
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit1'])){
                if (!empty($_POST["name"]) && !empty($_POST["comment"]) && empty($_POST["edit_n"]) && !empty($_POST["pass_new"])){  //投稿の追加
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $pass_new = $_POST["pass_new"];
                    $time = date("Y/m/d H:i");
            
                    if(file_exists($filename)){
                    $index = count(file($filename))+1;
                    }else{
                    $index = 1;
                    }
                    $newdata=$index."<>".$name."<>".$comment."<>".$time."<>".$pass_new;
            
                    $fp = fopen($filename,"a");
                    fwrite($fp,$newdata.PHP_EOL);
                    fclose($fp);
                }
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit2'])){
                if (!empty($_POST["del"]) && !empty($_POST["pass_del"])){  //投稿の削除
                    $del = $_POST["del"];
                    $pass_del = $_POST["pass_del"];
            
                    if (file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){
                            $words = explode("<>",$line);
                            if ($words[0]==$del && $words[4]==$pass_del){
                                $fp = fopen($filename,"w");
                                foreach($lines as $line){
                                    $words = explode("<>",$line);
                                    if ($words[0]==$del){
                                    }else{
                                        if (file_exists($filename)){
                                            $index = count(file($filename))+1;
                                        }else{
                                            $index = 1;
                                        }
                                        $newdata=$index."<>".$words[1]."<>".$words[2]."<>".$words[3]."<>".$words[4];
                    
                                        fwrite($fp,$newdata.PHP_EOL);
                                    }
                                }    
                                fclose($fp);
                            }
                        }
                    }
                }
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit3'])){
                if (!empty($_POST["edit"]) && !empty($_POST["pass_edit"])){  //投稿の編集を選択
                    $edit = $_POST["edit"];
                    $pass_edit = $_POST["pass_edit"];
                    
                    if(file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){
                            $words = explode("<>",$line);
                            if ($words[0]==$edit && $words[4]==$pass_edit){
                                $editnumber = $words[0];
                                $editname = $words[1];
                                $editcomment = $words[2];
                            }
                        }
                    }
                }
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['submit1'])){
                if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["edit_n"]) && !empty($_POST["pass_new"])){  //投稿の編集
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $edit_n= $_POST["edit_n"];
                    $pass_new= $_POST["pass_new"];
                    $time = date("Y/m/d H:i");
            
                    if(file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        $fp = fopen($filename,"w");
                        foreach($lines as $line){
                            $words = explode("<>",$line);
                            if ($words[0]==$edit_n){
                                $editdata=$edit_n."<>".$name."<>".$comment."<>".$time."<>".$pass_new;
                            }else{
                                $editdata=$words[0]."<>".$words[1]."<>".$words[2]."<>".$words[3]."<>".$words[4];
                            }
                            fwrite($fp,$editdata.PHP_EOL);
                        }
                        fclose($fp);
                    }
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
                    $del = $_POST["del"];
                    $pass_del = $_POST["pass_del"];
            
                    if (file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){
                            $words = explode("<>",$line);
                            if ($words[0]==$del && $words[4]!=$pass_del){
                                echo "!---------------!<br>";
                                echo "Error: Password is invalid.<br>";
                                echo "!---------------!<br><br>";
                            }
                        }
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
                    $edit = $_POST["edit"];
                    $pass_edit = $_POST["pass_edit"];
                    
                    if(file_exists($filename)){
                        $lines = file($filename,FILE_IGNORE_NEW_LINES);
                        foreach($lines as $line){
                            $words = explode("<>",$line);
                            if ($words[0]==$edit && $words[4]==$pass_edit){
                                echo $edit."行目を編集します<br>";
                            }elseif ($words[0]==$edit && $words[4]!=$pass_edit){
                                echo "!---------------!<br>";
                                echo "Error: Password is invalid.<br>";
                                echo "!---------------!<br><br>";
                            }
                        }
                    }
                }
            }
        }
        
        echo "<br>-------------------------------------------<br>";
        echo "【　投稿一覧　】<br><br>";
        if(file_exists($filename)){
            $lines = file($filename,FILE_IGNORE_NEW_LINES);
            foreach($lines as $line){
                $words = explode("<>",$line);
                echo $words[0].". ".$words[1]." 「".$words[2]."」 ".$words[3]."<br>";
            }
        }  
    ?>
</body>
</html>