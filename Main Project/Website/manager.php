<?php
  include("includes.php");
  if(!isLoggedIn() || !getUserType() == "Manager") {
    header("location: index.php");
  }
  displayErrors();

  $user = $db->getManagerEmployeeById($_SESSION["user"]["employeeId"]);

  if($user["contractId"]) {

  $user_contract = $db->getContractByContractId($user["contractId"]);
  $user_client = $db->getClientByContractId($user["contractId"]);
  $user_supervisor = $db->getEmployeeById($user["superviseBy"]);
  $user_regularUnder = $db->getRegularOnSameContract($user["contractId"]);
  $user_tasks = $db->getTaskTypeByContractId($user["contractId"]);
  $empl_and_tasktype_on_contract = $db->getTaskTypeAndEmployeeNameByContractId($user["contractId"]);
  $desired_contract_type = $db->getDesiredContractTypeFromRegular();
  $desired_contract_type_id = $db->getDesiredContractTypeAndIdFromRegular();
  $reg_employees_not_on_contract = $db->getEmployeesNotOnContractByContractId($user['contractId']);
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

    <title>Manager</title>
  </head>
  <body>
    <!-- container -->
    <div class="container pb-5">

      <!-- nav -->
      <?php
        include("nav_bar.php");
      ?>
      <!-- ./nav -->

   <?php
        include("employee_general_info.php");
      ?>
      <!-- row -->
      <div class="row py-3">

        <!-- col -->
		  <?php 
		  	if(isset($user_contract)) {
		  ?>

        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
		  <a class="btn btn-main" href="manager_chronological_contracts.php">View All Contracts Chronologically</a>
		  <a class="btn btn-main" href="manager_contracts_type.php">View All Contracts By Type</a>
          <h3 class="py-3">My Contract</h3>
          <ul class="list-group pb-3">
            <li class="list-group-item active">Client Name: <?=$user_client["clientName"]?></li>
            <li class="list-group-item">Contract ID: <?=$user_contract["contractId"]?></li>
            <li class="list-group-item">Contract Start Date: <?=$user_contract["serviceStartDate"]?></li>
            <li class="list-group-item">Contact number: <?=$user_contract["contactNumber"]?></li>
            <li class="list-group-item">Supervised By: <?=$user_supervisor["firstName"].' '.$user_supervisor["lastName"]?></li>
            <li class="list-group-item">Initial Amount: <?=$user_contract["initalAmount"]?></li>
            <li class="list-group-item">ACV: <?=$user_contract["annualContractValue"]?></li>
            <li class="list-group-item">Type: <?=$user_contract["contractType"]?></li>
            <li class="list-group-item">Service Type: <?=$user_contract["serviceType"]?></li>
            <li class="list-group-item">Line of Bisiness: <?=$user_contract["lineOfBusiness"]?></li>
            <li class="list-group-item">Satisfaction Score: <?=$user_contract["satisfactionLevel"]?></li>
          </ul>

          <h3 class="py-3">Employees on Contract</h3>
          <ul class="list-group pb-3">
          <?php
		  if(!empty($user_regularUnder)) {
            foreach ($user_regularUnder as $val) {
				 $task =$db->getTaskByRegularId($val["employeeId"]);
              echo "<li class=\"list-group-item\"><b>".$val["firstName"]." ".$val["lastName"]."</b>: ".$task["hours"]." hours logged</li>";
			}
		}
          ?>
          </ul>

          <h3 class="py-3">Tasks on Contract</h3>
          <?php
		  if(!empty($user_tasks)) {
            foreach ($user_tasks as $key => $task) {
              echo "<ul class=\"list-group pb-3\">";
                echo "<li class=\"list-group-item active\">$task[0]</li>";
                foreach ($empl_and_tasktype_on_contract as $key => $val) {
                  if($val[0] == $task[0]){
                    echo "<li class=\"list-group-item\">$val[1] $val[2]</li>";
                  }
                }
              echo "</ul>";
			}
		}
          ?>
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


        <h3 class="py-3">Candidates List</h3>
        <?php
          foreach ($desired_contract_type as $key=> $desiredType)
          {
            echo "<ul class=\"list-group pb-3\">";
            echo "<li class=\"list-group-item active\">$desiredType[0]</li>";
            // desired_contract_type_id is the list of all the ids on the contract
            foreach ($desired_contract_type_id as $key=> $premium)
            {
              if($premium[0]==$desiredType[0])
              {
                $temp = $db->getEmployeeById($premium[1]);
                echo "<li class=\"list-group-item\">".$temp["firstName"]." ".$temp["lastName"]."</li>";
              }
            }
            echo "</ul>";
          }
        ?> 

        <!-- form to remove employee -->
        <form action="manager_remove.php" method="POST">
          <div class="form-group">
            <label for="dropdown" class="col-form-label"><strong>Remove Employees:</strong></label>
            <select class="form-control" id="dropdown" name="remove_regular">
            <?php
              foreach ($user_regularUnder as $val) {

     	           echo "<option value=\"".$val["employeeId"]."\" >".$val["firstName"]." ".$val["lastName"]."</option>";
			}
            ?>
            </select>
            <input value="Remove" type="submit" class="my-2 btn btn-outline-danger">
          </div>
        </form>
        <!-- ./ form to remove employee -->

        <!-- form to add employee -->
        <form action="manager_add.php" method="POST">
          <div class="form-group">
          <label for="dropdown" class="col-form-label"><strong>Assign Suitable Employees:</strong></label>
          <select class="form-control" id="dropdown" name="assign_regular">
          <?php
            foreach ($reg_employees_not_on_contract as $key=> $val)
            {
              if($val[0]==$user_contract["contractType"])
              {
                $temp = $db->getEmployeeById($val[1]);
                echo "<option value=\"".$val[1]."\">".$temp["firstName"]." ".$temp["lastName"]."</option>";
              }
            }
          ?>
          </select>

          <label for="dropdown" class="col-form-label"><strong>To Task:</strong></label>
          <select class="form-control" id="dropdown" name="to_task">
              <?php
                foreach(['Set up infrastructure for client','Provisioning of resources','Assigning tasks to resources','Allocating a dedicated point of contact'] as $key=> $val)
                {
                  echo "<option value=\"".$val."\">".$val."</option>";
                }
              ?>
          </select>

            <input value="Add" type="submit" class="my-2 btn btn-outline-success">

            </div>
          </form>
          <!-- ./ form to add employee -->
        <!-- ./ form row -->
		<?php 
			  }
		?>
      </div>
      <!-- ./row -->

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
