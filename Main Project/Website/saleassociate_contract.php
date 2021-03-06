<?php
  include("includes.php");

  $user = $db->getSalesAssociateEmployeeById($_SESSION["user"]["employeeId"]);
  if (isset($_GET["contract_ID"]))
  {
    $user_contract_id = $_GET["contract_ID"];
    $user_contract = $db->getContractByContractId($user_contract_id);
    $supervirsor = $db->getSalesAssociateEmployeeById($user_contract["superviseBy"]);
    $managers_on = $db->getManagersByContractId($user_contract_id);
    $contract_client = $db->getClientByContractId($user_contract_id);
  } else {
    pushError("Trying to view contract without giving contract id");
    header("location: index.php");
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="style.css"/>
    <!-- Custom Script -->
    <script type="text/javascript" src="script.js"></script>

    <title>SaleAssociate</title>
  </head>
  <body>
    <!-- container -->
    <div class="container pb-5">

      <!-- nav -->
      <?php
        include("nav_bar.php");
      ?>
      <!-- ./nav -->

      <!-- row -->
      <div class="row text-center">
      	<div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
      	    <h1>Contract <?= $user_contract_id?></h1>
      	    <br/>
      	</div>
      </div>
      <!-- ./ row -->


      <!-- row -->
      <div class="row py-3">

        <!-- col -->
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
          <h3 class="py-3">Contract Details</h3>
          <ul class="list-group pb-3">
            <li class="list-group-item">Contact Number: <?=$user_contract["contactNumber"]?></li>
            <li class="list-group-item">Initial Amount: <?=$user_contract["initalAmount"]?></li>
            <li class="list-group-item">ACV: <?=$user_contract["annualContractValue"]?></li>
            <li class="list-group-item">Contract Type: <?=$user_contract["contractType"]?></li>
            <li class="list-group-item">Service Type: <?=$user_contract["serviceType"]?></li>
            <li class="list-group-item">Line of Business: <?=$user_contract["lineOfBusiness"]?></li>
            <li class="list-group-item">Service Start Date: <?=$user_contract["serviceStartDate"]?></li>
            <li class="list-group-item">Satisfaction Score: <?=$user_contract["satisfactionLevel"]?></li>
          </ul>


          <h3 class="py-3">Clients On</h3>
          <ul class="list-group pb-3">
            <?php
              if (!empty($contract_client["clientName"]))
              {
                echo "<li class=\"list-group-item\">".$contract_client["clientName"]."</li>";
              }
              if (!empty($contract_client["city"]))
              {
                echo "<li class=\"list-group-item\">".$contract_client["city"]."</li>";
              }
              if (!empty($contract_client["province"]))
              {
                echo "<li class=\"list-group-item\">".$contract_client["province"]."</li>";
              }
            ?>
          </ul>

          <h3 class="py-3">Supervisor On</h3>
          <ul class="list-group pb-3">
            <li class="list-group-item"><?= $supervirsor["firstName"] ?> <?= $supervirsor["lastName"] ?></li>
          </ul>

          <h3 class="py-3">Managers On</h3>
          <ul class="list-group pb-3">
            <?php
              foreach($managers_on as $manager_row)
              {
                echo "<li class=\"list-group-item\">";
                echo $manager_row["firstName"]." ".$manager_row["lastName"];
                echo "</li>";
              }
            ?>
          </ul>

            <a href="./" class="btn btn-outline-primary">Back</a>
        </div>
      </div>
        <!-- col -->
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 py-3">
          <h4 class="py-2">Deliverables:</h4>
          <ul class="list-group">
          <?php
            $deliverables = $db->getDeliverablesByContractId($user_contract["contractId"]);
            
            while($deliverable = $deliverables->fetch_assoc()) {
              ?>
            <a class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1"><?=$deliverable["deliverableIndex"] ?></h5>
              </div>
              <p class="mb-1">Scheduled For: <?=$deliverable["scheduledDate"]?></p>
              <p class="mb-1">Delivered On: <?=$deliverable["deliveredDate"]?></p>
              <p>
              <?php 
                if(!empty($deliverable["scheduledDate"] && !empty($deliverable["deliveredDate"]))) {
                    echo "<b>".(strtotime($deliverable["deliveredDate"]) - strtotime($deliverable["scheduledDate"]))."</b>";
                    echo " days to complete"; 
                }
              ?>
               </p>
			
            </a>
			<br />
              <?php
            }
          ?>
          </ul>          
        </div>
    </div>
    <!-- ./ container -->

    <!-- jQuery-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
