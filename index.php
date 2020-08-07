<?php
session_start();
require 'config.php';

// Confirmar se existe uma sessao logada para entrar na pagina
if(isset($_SESSION['bank']) && empty($_SESSION['bank']) == false ){
    $id = $_SESSION['bank'];

    $sql = $pdo->prepare("SELECT * FROM contas WHERE id= :id");
    $sql->bindValue(":id", $id);
    $sql->execute();

    if($sql->rowCount()>0){
        $info = $sql->fetch();
    } else{
        header("Location: login.php");
        exit;
    }

} else{
    header("Location: login.php");
    exit;
}



?>

<!-- Layout -->

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
                    <a class="btn btn-light active">Account</a>
                    <!-- Here, creation of the second tab -->
                    <li class="aba" >
                    <a class = "btn btn-light"href="extract.php">Extract</a> 
                    <!-- Here, creation of the third tab-->
                    <li class="aba" >
                    <a class="btn btn-light" href="withdrawal_deposit.php">Withdrawal/Deposit</a> 
                    </ul>
                </div>
            <div class="card card-signin flex-row my-5">
            <div class="card-img-left d-none d-md-flex">
                <!-- Background image for card set in CSS! -->
            </div>
            <div class="card-body">
                <h5 class="card-title text-center ">Account</h5>
                <form class="form-signin" method="POST">

                <div class="form-group">
                    <a><strong>Name</strong></a>
                    <input type="text" class="form-control"  name="name" value="<?php echo ucfirst($info['titular']); ?>"readonly>
                    <br/>
                </div>
                
                <div class="form-group">
                <a><strong>Agency</strong></a>
                    <input type="text"  class="form-control"  name ="agency" value ="<?php echo $info['agencia']; ?>"readonly>
                    <br/>
                </div>

                <div class="form-group">
                <a><strong>Account</strong></a>
                    <input type="text"  class="form-control"  name ="account" value ="<?php echo $info['conta']; ?>"readonly>
                    <br/>
                </div>

                <div class="form-group">
                <a><strong>Balance</strong></a>
                    <input type="text"  class="form-control"  name ="Balance" value ="<?php echo 'R$ '.$info['saldo']; ?>"readonly>
                    <br/>
                </div>

                
                <a class="btn btn-lg btn-primary btn-block text-uppercase" href="logout.php">Logout</a></p>            
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    
    </body>

</html>