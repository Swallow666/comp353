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

    <title>New Contract</title>
  </head>
  <body>
    <!-- container -->
    <div class="container">

      <!-- nav -->
      <?php
        include("/views/nav_bar.php");
      ?>
      <!-- ./nav -->

      <!-- row -->
      <div class="row py-3">
        <div class="col-12">
          <h1>New Contract</h1>
        </div>
      </div>
      <!-- ./ row -->

      <!-- row -->
      <div class="row">
        <form class="col-12">

          <!-- form row -->
          <div class="form-group row">
            <label for="staticEmail" class="col-sm-4 col-form-label">ContractID</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" id="staticEmail" placeholder="12345678">
            </div>
          </div>
          <!-- ./ form row -->

          <!-- form row -->
          <div class="form-group row">
            <label for="fname" class="col-sm-4 col-form-label">Company Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="fname" placeholder="Department">
            </div>
          </div>
          <!-- ./ form row -->          

          <!-- form row -->
          <div class="form-group row">
            <label for="lname" class="col-sm-4 col-form-label">Date</label>
            <div class="col-sm-8">
              <input class="form-control" id="fname" placeholder="lname">
            </div>
          </div>
          <!-- ./ form row -->               
          
          <!-- form row -->
          <div class="form-group row">
            <label for="dropdown" class="col-sm-4 col-form-label">Province</label>
            <div class="col-sm-8">
              <select class="form-control" id="dropdown">
                <option>British Columbia</option>
                <option>Alberta</option>
                <option>Saskatchewan</option>
                <option>Manitoba</option>
                <option>Ontario</option>
                <option>Quebec</option>
                <option>New Brunswick</option>
                <option>Newfoundland</option>
                <option>PEI</option>
              </select>
            </div>
          </div>
          <!-- ./ form row -->

          <!-- form row -->
          <div class="form-group row">
            <label for="dropdown" class="col-sm-4 col-form-label">Manager</label>
            <div class="col-sm-8">
              <select class="form-control" id="dropdown">
                <option>Michael</option>
                <option>David</option>
                <option>Ryan</option>
              </select>
            </div>
          </div>
          <!-- ./ form row -->

          <!-- form row -->
          <div class="form-group row">
            <label for="dropdown" class="col-sm-4 col-form-label">Priority</label>
            <div class="col-sm-8">
              <select class="form-control" id="dropdown">
                <option>Premium</option>
                <option>Diamond</option>
                <option>Gold</option>
                <option>Silver</option>
              </select>
            </div>
          </div>
          <!-- ./ form row -->   

          <!-- form row -->
          <div class="form-group row">
            <label for="dropdown" class="col-sm-4 col-form-label">Employee</label>
            <div class="col-sm-6">
              <select class="form-control" id="dropdown">
                <option>Oscar</option>
                <option>Dwight</option>
                <option>Big Tuna</option>
              </select>
            </div>
            <div class="col-2">
              <button class="btn btn-primary btn-md" style="width:100%;">Add</button>
            </div>
          </div>
          <!-- ./ form row -->

          <!-- ./ row -->
          <div class="form-group row">
            <label for="inputPassword" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
          </div>
          <!-- ./ form row -->          

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Contract</button>
            <button class="btn btn-danger">Cancel</button>
          </div>
        </form>
      </div>
      <!-- ./row -->

      </div>
      <!-- ./ row -->
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