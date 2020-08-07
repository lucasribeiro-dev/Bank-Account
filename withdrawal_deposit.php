<?php
session_start();
require 'config.php';

// Verifying if there is a session logged
if(isset($_SESSION['bank']) && empty($_SESSION['bank']) == false ){
    $id = $_SESSION['bank'];


    //Verify if all field was filled and inserto in database
    if(isset($_POST['type']) && !empty($_POST['name']) && !empty($_POST['account'])&& !empty($_POST['agency'])){
        $type = $_POST['type'];
        $value = str_replace(",", ".", $_POST['value']);
        $value = floatval($value);
        
        $sql = $pdo->prepare("INSERT INTO historico (conta_que_enviou, id_conta, tipo, valor,data_operacao) VALUES (:conta_que_enviou, :id_conta, :tipo, :valor, NOW())");
        $sql->bindValue(":conta_que_enviou", $_POST['account']);
        $sql->bindValue(":tipo", $type);
        $sql->bindValue(":valor", $value);
        $sql->bindValue(":id_conta", $id);
        $sql->execute();

        // Identify whether the amount placed is for deposit or withdrawal
        if($type == 0){
            //Deposit
            $sql = $pdo->prepare("UPDATE contas SET saldo = saldo +:valor WHERE conta = :conta");
            $sql->bindValue(":valor", $value);
            $sql->bindValue(":conta", $_POST['account']);
            $sql->execute();
        }else{
            // Withdrawal
            $sql = $pdo->prepare("UPDATE contas SET saldo = saldo -:valor WHERE conta = :conta ");
            $sql->bindValue(":valor", $value);
            $sql->bindValue(":conta", $_POST['account']);
            $sql->execute();
        }
    }

} else{
    header("Location: login.php");
    exit;
}
?>


<html>
    <head>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>

    <script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div class="container">
        <div class="row " style="display: flex; padding-top: 15%;">
        <div class="col-lg-10 col-xl-9 mx-auto ">
            <div class="">
                    <!-- Creating the listing  -->
                    <ul class="abas ">
                    <!-- Here, creation of the first tab -->
                    <li class="aba" >
                    <a class="btn btn-light" href="index.php">Account</a>
                    <!-- Here, creation of the second tab -->
                    <li class="aba" >
                    <a class = "btn btn-light"href="extract.php">Extract</a> 
                    <!-- Here, creation of the third tab-->
                    <li class="aba" >
                    <a class="btn btn-light active" href="withdrawal_deposit.php">Withdrawal/Deposit</a> 
                    </ul>
            </div>
            <div class="card card-signin flex-row my-5">
            
            <div class="card-body" style="background-color:#d3d3d3;">
                <h5 class="card-title text-center ">Withdrawal and Deposit</h5>

                 <form class="form-signin" method="POST">

                <div class="form-group">
                    <a><strong>Name</strong></a>
                    <input type="text" class="form-control"  name="name">
                    <br/>
                </div>
                
                <div class="form-group">
                <a><strong>Agency</strong></a>
                    <input type="text"  class="form-control"  name ="agency">
                    <br/>
                </div>

                <div class="form-group">
                <a><strong>Account</strong></a>
                    <input type="text"  class="form-control"  name ="account">
                    <br/>
                </div>

                <div class="form-group">
                <a><strong>Value</strong></a>
                    <input type="text"  class="form-control"  name ="value">
                    <br/>
                </div>

                <div class="form-group">
                    <select class="form-control" name="type">
                         <option value="0">Deposit</option>
                         <option value="1">Withdrawal</option>
                    </select>
                    <br/>
                </div>
                <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Submit</button>
                </form>
            
            </div>
            </div>
        </div>
        </div>
    </div>
    </body>

</html>