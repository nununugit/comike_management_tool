<?php
        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=list1;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM comike_management_doujin where delete_flag=0; ";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[]=$row;
            }
            $sql2="select SUM(target_price) as total from comike_management_doujin WHERE delete_flag=0;";
            $stmt=$dbh->prepare($sql2);
            $stmt->execute();
            $count = $stmt->rowCount();
            while($row2 = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data2[]=$row2;
            }
        }catch(PDOException $e){
            print ($e->getMessage());
            die();
        }
            //テーブルへの登録
        if(isset($_POST['p_initial'])){
            $p_initial = @$_POST['p_initial'];
            $date = @$_POST['date'];
            $p_number = @$_POST['p_number'];
            $twitter = @$_POST['twitter'];
            $c_name = @$_POST['c_name'];
            $t_price = @$_POST['t_price'];
            $t = @$_POST['t'];
            $priority = @$_POST['priority'];
            if (empty($p_initial)||empty($p_number)||empty($t_price)||empty($c_name)){
                echo "<br>";
                echo '<script>alert("入力してね")</script>';
        }else{
            date_default_timezone_set('Asia/Tokyo');
            $timestamp = time() ;
            $now= date( "Y/m/d H:i:s", $timestamp );
            $sql = "INSERT INTO comike_management_doujin VALUES( '',$date,'$p_initial', '$p_number','$c_name','$twitter','$t', '$t_price','$now',0,'$priority' );";
            $result = $dbh ->query($sql);
            if(!$result){
                die($dbh ->error);
            }
            header('Location: ./comic_market_manage.php');
        }
        
        }
        if(isset($_POST['target_company'])){
            $priority = @$_POST['priority'];
            $position = @$_POST['position'];
            $t_company = @$_POST['t_company'];
            $target = @$_POST['t'];
            $t_price1 = @$_POST['t_price'];
            echo $p_initial;
            echo $p_number;
            if (empty($priority)||empty($position)||empty($t_price1)||empty($target)||empty($t_price)){
                echo "<br>";
                echo '<script>alert("入力してね")</script>';
            }else{
            date_default_timezone_set('Asia/Tokyo');
            $timestamp = time() ;
            $now= date( "Y/m/d H:i:s", $timestamp );
            $sql = "INSERT INTO comike_management_company VALUES( '',$priority,'$position', '$t_company','$target' , '$t_price',0 );";
            $result = $dbh ->query($sql);
            if(!$result){
                die($dbh ->error);
            }
            header('Location: ./comic_market_manage.php');
        }
        //個別削除
        }if(isset($_GET['id'])){
                    $id =  @$_GET['id'];
                    $sql = "UPDATE comike_management_doujin SET delete_flag = 1 WHERE target_id=$id;";
                    $result = $dbh ->query($sql);
                    if(!$result){
                        die($dbh ->error);
                    }
                    header('Location: ./comic_market_manage.php');
                }?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href = "./comike_manage.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    </head>
    <body>
    <script src= "comike_jquery.js"></script>
    <nav>
    <ul>
        <li class="current" id="doujinres" ><h3>同人登録</h3></li>
        <li id="doujinlist"><h3>同人リスト</h3></li>
        <li id="companyres"><h3>企業登録</h3></li>
        <li id="companylist"><h3>企業リスト</h3></li>
    </ul>
    </nav>
    <div id="doujin1">
        <form action="comic_market_manage.php"  method="post">
        <div class="form-group"><p>
            <br>
        日付:<br>
        <input type="text" placeholder="何日目？" name="date" size="40">
        </p>
        優先度:<br>
        <input type="text" placeholder="優先度は？(最大9)" name="priority" size="40">
        </p>
        場所:<br>
        <input type="text" placeholder="東西南北、文字" name="p_initial" size="40">
        </p>
        番号:<br>
        <input type="text" placeholder="番号とA or B" name="p_number" size="40">
        </p>
        サークル名:<br>
        <input type="text" placeholder="サークルの名前か作者の名前" name="c_name" size="40">
        </p>
        twitter:<br>
        <input type="text" placeholder="twitterのアカウント" name="twitter" size="40">
        </p>
        
        買うもの:<br>
        <input type="text" placeholder="買うもん" name="t" size="40">
        </p>
        値段:<br>
        <input type="text" placeholder="いくら？" name="t_price" size="40">
        </p>
        </div>
        <input class="btn btn-primary mb-2" type="submit" name="投稿" >
        <input class="btn btn-primary mb-2" type="reset" value="リセット">        
        </form>
        <?php foreach($data2 as $row2){?>
        <?php echo $row2['total'];?>
        <?php }?>

    </div>
        <!-- ここまで同人入力欄 -->

    <div  id="doujin2">
        <div class="table-responsive">
        <?php foreach($data2 as $row2){?>
        <h1 id="center">合計金額　<?php echo $row2['total'];?>円</h1>
        <?php }?>
            <table class="table">
        <thead class="thead-dark">
        <tr><th>日付け</th><th>優先度</th><th>場所</th><th>番号</th><th>サークル名または作者名</th><th>twitter名</th><th>買うもの</th><th>値段</th><th>削除ボタン</th></tr>
        <?php foreach($data as $row){ ?>
            <tr>
            <td id="center"><?php echo htmlentities( $row['date'], ENT_QUOTES, 'UTF-8');?>日目</td>
            <td id="center"><?php echo htmlentities( $row['priority'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row['position_initial'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row['position_number'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row['circle_name'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><a href="<?php echo htmlentities( $row['twitter'], ENT_QUOTES, 'UTF-8');?>">twitterアカウント<a></td>
            <td id="center"><?php echo htmlentities( $row['target'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row['target_price'], ENT_QUOTES, 'UTF-8');?></td>
            
            <td id="center">
            <form action="comic_market_manage.php" method="get">
            <input type="submit" value="削除する" class="btn btn-primary" data-toggle="button" aria-pressed="false" >
            <input type="hidden" name="id" value="<?=$row['target_id']?>">
            </form>    
        </td>
        </tr>
        <?php } ?>        

    </table>
        </div>
        <!-- <ここまで同人リスト> -->
    </div>
    <?php
      try{
            $sql = "SELECT * FROM comike_management_company where delete_flag=0; ";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            while($row_company = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data1[]=$row_company;
            }
        }catch(PDOException $e){
        print ($e->getMessage());
        die();
        }
    ?>

    <div  id="company1">
        <form action="comic_market_manage.php"  method="post">
        <div class="form-group"><p>
            <br>
        優先度:<br>
        <input type="text" placeholder="優先度は？(最大9)" name="priority" size="40">
        </p>
        場所:<br>
        <input type="text" placeholder="東西南北、文字" name="position" size="40">
        </p>
        企業名<br>
        <input type="text" placeholder="会社名" name="t_company" size="40">
        </p>
        買うもの:<br>
        <input type="text" placeholder="買うもん" name="t" size="40">
        </p>
        値段:<br>
        <input type="text" placeholder="いくら？" name="t_price" size="40">
        </p>
        </div>
        <input class="btn btn-primary mb-2" type="submit" name="投稿" >
        <input class="btn btn-primary mb-2" type="reset" value="リセット">        
        </form>
    </div>
        <!-- ここまで企業入力欄 -->

    <div  id="company2">
        <div class="table-responsive">
            <table class="table">
        <thead class="thead-dark">
        <tr><th>優先度</th><th>場所</th><th>会社名</th><th>商品名</th><th>値段</th><th>削除ボタン</th><th>変更ボタン</th></tr>
        <?php foreach($data1 as $row_company){ ?>
            <tr>
            <td id="center"><?php echo htmlentities( $row_company['priority'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row_company['position'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row_company['target_company'], ENT_QUOTES, 'UTF-8');;?></td>
            <td id="center"><?php echo htmlentities( $row_company['target_name'], ENT_QUOTES, 'UTF-8');?></td>
            <td id="center"><?php echo htmlentities( $row_company['target_price'], ENT_QUOTES, 'UTF-8');?></td>
            
            <td id="center">
            <form action="comic_market_manage.php" method="get">
            <input type="submit" value="削除する" class="btn btn-primary" data-toggle="button" aria-pressed="false" >
            <input type="hidden" name="id" value="<?=$row_company['target_id'] ?>">
            </form>    
        </td>
        </tr>
        <?php } ?>        
    </table>
        </div>
        <!-- <ここまで企業リスト> -->
    </div>
 <!-- Bootstrap Javascript(jQuery含む) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        
    </body>
    
</html>