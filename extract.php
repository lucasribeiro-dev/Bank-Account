<?php
session_start();
require 'config.php';
// Verifying if there is a session logged

if(isset($_SESSION['bank']) && empty($_SESSION['bank']) == false ){
    $id = $_SESSION['bank'];

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
                    <a class = "btn btn-light active"href="extract.php">Extract</a> 
                    <!-- Here, creation of the third tab-->
                    <li class="aba" >
                    <a class="btn btn-light" href="withdrawal_deposit.php">Withdrawal/Deposit</a> 
                    </ul>
            </div>
            <div class="card card-signin flex-row my-5">
            
            <div class="card-body" style="background-color:#d3d3d3;">
                <h5 class="card-title text-center ">Extract</h5>
                <table class="table table-striped table-light">
                <thead>
                    <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Value</th>
                    </tr>
                </thead>

                <?php

                //Creating html extract and getting the datas in db
                $sql = $pdo->prepare("SELECT * FROM historico WHERE id_conta = :id_conta");
                $sql->bindValue(":id_conta", $id);
                $sql->execute();

                if($sql->rowCount() > 0) {
                    foreach($sql->fetchAll() as $item) {
                        $date = date('d/m/Y H:i', strtotime($item['data_operacao']));
                        $value = $item['valor'];
                        $value_table = ($item['tipo'] == 0) ? "<font color='green'> $ $value</font>" : "<font color='red'> $ $value</font>";;

                        echo '<tbody>';
                        echo '<tr>';
                        echo"<td>$date</td>";
                        echo "<td>$value_table</td>";
                        echo'</tr>';
                        echo'</tbody>';

                    }
                }
                ?>

            </table>
                
            
            </div>
            </div>
        </div>
        </div>
    </div>
    
    </body>

</html>