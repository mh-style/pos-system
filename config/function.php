<?php
session_start();

require 'dbcon.php';

// Set Default Time
date_default_timezone_set('Asia/Dhaka');


// Input field Validation
if (!function_exists('validate')) {
    function validate($inputData){

        global $conn;
        $validateData = mysqli_real_escape_string($conn, $inputData);
        return trim($validateData);
    }
}
// Redirect from 1 page to another page with the message (status)

if (!function_exists('redirect')) {
    function redirect($url, $status){
        $_SESSION['status'] = $status;
        header('Location: '.$url);
        exit(0);
    }
}
if (!function_exists('alertMessage')) {

// Display messages or status after any process.
    function alertMessage(){
        if (isset($_SESSION['status'])) {
            
            echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
            <h6>'.$_SESSION['status'].'</h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            unset($_SESSION['status']);

        }
    }
}
if (!function_exists('insert')) {

//Insert record using this function
    function insert($tableName, $data){
        global $conn;
        $table = validate($tableName);

        $columns = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));

        $finalColumns = implode(',',$columns);

        $query = "INSERT INTO $table ($finalColumns) VALUES ($placeholders)";

        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            return false; // If preparation fails, return false
        }
        $types = '';
        $values = array_values($data);

        foreach ($values as $value) {
            // Determine the type of the value (s = string, i = integer, d = double, b = blob)
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_double($value)) {
                $types .= 'd';
            } else {
                $types .= 's'; // Default to string for all other data types
            }
        }
        $stmt->bind_param($types, ...$values);
        $result = $stmt->execute();

        // Close the statement
        $stmt->close();

        return $result;
    }
}

if (!function_exists('update')) {

    // Update data using this function (SQL Injection-proof)
    function update($tableName, $id, $data) {
        global $conn;

        // Validate and sanitize table name and ID
        $table = validate($tableName);
        $id = validate($id);
        if (empty($data)) {
            return false;
        }
        // Prepare column names and placeholders for update
        $columns = array_keys($data); // Get column names
        $values = array_values($data); // Get values

        // Create the set part of the query with placeholders (e.g., "column1 = ?, column2 = ?")
        $updateColumns = implode(' = ?, ', $columns) . ' = ?';

        // Prepare the SQL query
        $query = "UPDATE $table SET $updateColumns WHERE id = ?";

        // Prepare the statement
        

        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {
        // Create a dynamic array of types based on the $data values
        $types = '';
        foreach ($values as $value) {
            // Determine the type of the value (s = string, i = integer, d = double, b = blob)
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_double($value)) {
                $types .= 'd';
            } else {
                $types .= 's'; // Default to string for all other data types
            }
        }
        $types .= 'i'; // Add the type for the ID, which is an integer

        // Bind the parameters including the values and the ID
        $values[] = $id;

        // Bind the parameters including the ID
        $stmt->bind_param($types, ...$values);

        // Execute the update statement
        $result = $stmt->execute();

        // Close the statement
        $stmt->close();

        return $result;
    } else {
            // If query preparation fails, return false
            return false;
        }
    }
}

if (!function_exists('getAll')) {

    function getAll($tableName, $status = NULL){
        global $conn;
        $table = validate($tableName);
        $status = validate($status);

        if ($status == 'status') {
            $query = "SELECT * FROM $table WHERE status ='0' ";
        }else{
            $query = "SELECT * FROM $table";
        }
        return mysqli_query($conn, $query);
    }
}
if (!function_exists('getById')) {

    function getById($tableName, $id){
        global $conn;
        $table = validate($tableName);
        $id = validate($id);
        $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if($result){
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $response = [
                    'status' => 200,
                    'data'  => $row,
                    'message' => 'Record Found'
                ];
                return $response;
            }else{
                $response = [
                    'status' => 404,
                    'message' => 'No Data Found'
                ];
                return $response;
            }
        }else{
            $response = [
                'status' => 500,
                'message' => 'Something Went Wrong'
            ];
            return $response;
        }

    }
}
if (!function_exists('Delete')) {

// Delete data from database using id
    function Delete($tableName, $id){
        global $conn;
        $table = validate($tableName);
        $id = validate($id);
        $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        return $result;
    }
}
if (!function_exists('checkParamId')) {

    function checkParamId($type){
        if(isset($_GET[$type])){
            if($_GET[$type] != ''){
                return $_GET[$type];
            }else{
                return '<h5>No Id Found</h5>';
            }
        
        }else{
            return '<h5>No Id Given</h5>';
        }
    }
}
if (!function_exists('logoutSession')) {
    function logoutSession(){
        unset($_SESSION['loggedIn']);
        unset($_SESSION['loggedInUser']);
    }
}
if (!function_exists('jsonResponse')) {
    function jsonResponse($status, $status_type, $message){
        $response = [
            'status' => $status,
            'status_type' => $status_type,
            'message' => $message
        ];
        echo json_encode($response);
        return;
    }
}
if (!function_exists('getCount')) {
    function getCount($tableName){
        global $conn;
        $table = validate($tableName);
        $query = "SELECT * FROM $table";
        $query_run = mysqli_query($conn, $query);
        if($query_run){
            $totalCount = mysqli_num_rows($query_run);
            return $totalCount;
        }else{

            return 'Something Went Wrong!';
        }
    }
}
?>