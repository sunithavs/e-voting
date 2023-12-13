<?php
include('db.php');
$query = "SELECT * FROM candidates WHERE active = 1";
$data = array();
$statement = $connect->prepare($query);
if($statement->execute())
{
    $result = $statement->fetchAll();
    if($statement->rowCount() > 0)
    {
        foreach($result as $row)
        {
            $data[] = array("id"=>$row['id'],"name"=>$row['candidate_name'],"code"=>$row['candidate_code']);
        }
        echo json_encode($data);
    }
}
?>