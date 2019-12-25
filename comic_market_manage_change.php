<?php

        //MySQLサーバへの接続とデータベースの選択
        $dsn='mysql:dbname=list1;host=localhost;charset=utf8';
        $user='root';
        $password= '';
        $id=@$_POST['id1'];
        try{
            $dbh =new PDO($dsn,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM comike_management_doujin where target_id ='$id'; ";
            $stmt=$dbh->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $data[]=$row;
            }
        }catch(PDOException $e){
            print ($e->getMessage());
            die();
        }
    if(isset($_POST['change'])){
        date_default_timezone_set('Asia/Tokyo');
        $timestamp = time() ;
        $now= date( "Y/m/d H:i:s", $timestamp );
        $date = @$_POST['date'];
        $p_initial = @$_POST['p_initial'];
        $p_number = @$_POST['p_number'];
        $twitter = @$_POST['twitter'];
        $c_name = @$_POST['c_name'];
        $t_price = @$_POST['t_price'];
        $t = @$_POST['t'];
        $priority = @$_POST['priority'];
        $id= @$_POST['id'];
         $sql = "UPDATE comike_management_doujin SET date='$date' , position_initial ='$p_initial' , position_number = '$p_number' , circle_name = '$c_name' , twitter = '$twitter' , target ='$t' , target_price = '$t_price', timestamp  = '$now', priority='$priority' WHERE target_id= '$id';";
         $result = $dbh ->query($sql);
         echo $sql;
         if(!$result){
             die($dbh ->error);
         }
        header('Location: ./comic_market_manage.php');
        }
    

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<form action="comic_market_manage_change.php"  method="post">
        <div class="form-group"><p>
            <br>
            <?php foreach($data as $row){?>
        日付:<br>
        <input type="text" placeholder="何日目？" name="date" size="40" value="<?=$row['date']; ?>">
        </p>
        優先度:<br>
        <input type="text" placeholder="優先度は？(最大9)" name="priority" size="40" value="<?=$row['priority']; ?>">
        </p>
        場所:<br>
        <input type="text" placeholder="東西南北、文字" name="p_initial" size="40" value="<?=$row['position_initial']; ?>">
        </p>
        番号:<br>
        <input type="text" placeholder="番号とA or B" name="p_number" size="40" value="<?=$row['position_number']; ?>">
        </p>
        サークル名:<br>
        <input type="text" placeholder="サークルの名前か作者の名前" name="c_name" size="40" value="<?=$row['circle_name']; ?>">
        </p>
        twitter:<br>
        <input type="text" placeholder="twitterのアカウント" name="twitter" size="40" value="<?=$row['twitter']; ?>">
        </p>
        
        買うもの:<br>
        <input type="text" placeholder="買うもん" name="t" size="40" value="<?=$row['target']; ?>">
        </p>
        値段:<br>
        <input type="text" placeholder="いくら？" name="t_price" size="40" value="<?=$row['target_price']; ?>">
        </p>
        </div>
        <input class="btn btn-primary mb-2" type="submit" value="変更" name="change" >
        <input type="hidden" name="id" value="<?=$row['target_id'] ?>">
        <input class="btn btn-primary mb-2" type="reset" value="リセット">        
        </form>
            <?php  }?>


</body>
</html>