<?php
// Class to manage database connection
class DatabaseConn {
    function __construct() {
        $this->config = parse_ini_file("config.ini", true);
        $this->connect();
    }

    // Connect to the database using config
    private function connect() {
        $databaseConfig = $this->config["database"];
        $username = $databaseConfig["username"];
        $password = $databaseConfig["password"];
        $server = $databaseConfig["server"];
        $db = $databaseConfig["db"];

        $connection = new mysqli($server, $username, $password, $db);
    
        if($connection->connect_error) {
            die("Connection failed: ". $connection->connect_error);
        }
    
        $this->conn = $connection;
    }

    // Returns array containing all contracts
    function getAllContracts() {
        $result = $this->conn->query("SELECT * FROM Contracts;");
        return $result;
    }

    function getContractsByClientId(int $id) {
        $results = $this->conn->query("SELECT * FROM Contracts WHERE clientId=$id");
        return $results;
    }

    // Returns a user by his id
    function getUserById(int $id) {
        $result = $this->conn->query("SELECT * FROM Users WHERE id=$id");
        
        if($result.num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    function getRegularEmployeeById(int $id) {
        $result = $this->conn->query("SELECT * FROM Regular INNER JOIN Employees ON Employees.employeeId = Regular.employeeId WHERE Regular.employeeId=$id");
        
        print($this->conn->error);

        if($result->num_rows > 0){
            return $result->fetch_assoc();
        } else {
            return 0;
        }
    }

    // Attempt to login as a client
    function loginClient(string $username, string $password) {
        $query = "SELECT * FROM clients WHERE emailId ='$username' AND password='$password' LIMIT 1";
        $clients = $this->conn->query($query);

        if($clients->num_rows >= 1) {
            $client = $clients->fetch_assoc();

            $_SESSION["user"] = $client;
            $_SESSION["user_type"] = "Client";
        } else {
            pushError("Wrong emailId / password for client login");
        }

        header("location: /");
    }

    // Attempt to login as an employee
    function loginEmployee(string $username,string $password) {
        $query = "SELECT * FROM employees WHERE CONCAT(firstname,lastname) ='$username' AND password='$password' LIMIT 1";
        $employees = $this->conn->query($query);

        if($employees->num_rows >= 1) {
            $employee = $employees->fetch_assoc();
            $employee_type = $this->getEmployeeTypeById($employee["employeeId"]);

            $_SESSION["user"] = $employee;
            $_SESSION["user_type"] = $employee_type;
        } else {
            pushError("Wrong firstname.lastname / password for employee login");
        }

        header("location: /index.php");
    }

    // Returns an employee type by his id
    function getEmployeeTypeById(int $id) {
        if($this->checkTableForEmployeeId("Admins", $id)) {
            return "Admin";
        }

        if($this->checkTableForEmployeeId("SalesAssociate", $id)) {
            return "Sales Associate";
        }

        if($this->checkTableForEmployeeId("Manager", $id)) {
            return "Manager";
        }

        if($this->checkTableForEmployeeId("Regular", $id)) {
            return "Regular";
        }

        return null;
    }

    // Checks a table to see if it contains a user id
    private function checkTableForEmployeeId(string $table,int $id) {
        $sql = "SELECT * FROM $table WHERE employeeId=$id";
        $admins = $this->conn->query($sql);
        return $admins->num_rows >= 1;
    }

    // Escape string to be safe
    function escape(string $str) {
        return $this->conn->real_escape_string(trim($str));
    }
}

$db = new DatabaseConn();
?>

