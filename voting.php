<?php
session_start();
include('db.php');

$form_data = json_decode(file_get_contents("php://input"));
$message = '';
$validation_error = '';
$data[':candidate_id'] = $form_data->id;
$data[':voter_id'] = $_SESSION["user_id"];
$data[':created_at'] = date('Y-m-d H:i:s');


    $query = "INSERT INTO votes (voter_id, candidate_id, created_at) VALUES (:voter_id, :candidate_id, :created_at)";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
    $message = 'Thanks for voting!!';
    }
    else{
    $validation_error = "Something went wrong";

    }
$output = array(
 'error'  => $validation_error,
 'message' => $message
);

echo json_encode($output);


?>