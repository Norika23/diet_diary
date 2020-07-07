<!-- <div class="popupTweet"></div> -->

<?php
include("includes/header.php");
include("includes/navbar.php");

?>


<style>

header{
  margin-top: 30px;
  color: #43A047;
}
hr{
  border-width: 3px;
  border-color: #43A047;
}
h1{
  font-size: 25px;
    font-weight: bold;
    margin: 0;
  text-align: center;
}
.align-light{
    text-align: right;
}
.form-group{
  margin-bottom: 35px;
}
footer p{
  text-align: center;
}
input:required{
  background: #ffcdd2;
}
input[type="email"]:invalid{
  background: #ffcdd2;
}
input:valid{
  background: transparent;
}
input:focus{
  background: #DCEDC8;
}

</style>


<!-- <!DOCTYPE html>
<html lang="jp">
<head>
    <title>ユーザー登録</title>
  <meta charset="UTF-8"> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="css/style.css">
</head>
<body> -->
    <!-- <div class="container">
        <header>
           <div class="row">
                    <h1>ユーザー登録</h1>
            </div>
        </header>
    </div>

    <hr> -->
    
    <div class="container">
        <form action="＃" method="get" class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div class="form-group">
                    <label for="name"><span class="label label-danger">必須</span> お名前</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="例：ジャングル オーシャン" autofocus required>
                </div>
                <div class="form-group">
                    <label for="email"><span class="label label-danger">必須</span> メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="例：raffaello@jungleocean.com" required>
                </div>
                <div class="form-group">
                    <label for="tel"><span class="label label-danger">必須</span> 電話番号</label>
                    <input type="tel" id="tel" name="tel" class="form-control" placeholder="例：080-1234-5678" required>
                </div>

    
                <button type="submit" class="btn btn-primary">送信する</button>
            </div>
        </form>
    </div>


    <?php

include("includes/footer.php");

?>
