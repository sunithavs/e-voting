<?php
include('../db.php');
$query = "SELECT register.name,register.email,votes.candidate_id,candidates.candidate_name,candidates.candidate_code FROM register  
          left join votes on register.id=votes.voter_id
          left join candidates on votes.candidate_id=candidates.id";
$data = array();
$statement = $connect->prepare($query);
if($statement->execute())
{
    $result = $statement->fetchAll();
    if($statement->rowCount() > 0)
    {
        foreach($result as $row)
        {
            if($row['candidate_id']) $status = "Voted to ". $row['candidate_name'];
            else $status = "Not yet voted";
            $data[] = array("name"=>$row['name'],"email"=>$row['email'],"status"=>$status);
        
        }
        echo json_encode($data);
    }
}
?>