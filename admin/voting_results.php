<?php
include('../db.php');
$query = "SELECT candidates.candidate_name, candidates.candidate_code, SUM(votes.candidate_id) as votes  FROM candidates  
          left join votes on candidates.id=votes.candidate_id
          group by votes.candidate_id order by votes desc";
$data = array();
$statement = $connect->prepare($query);
if($statement->execute())
{
    $result = $statement->fetchAll();
    if($statement->rowCount() > 0)
    {
        foreach($result as $row)
        {
            
            $data[] = array("name"=>$row['candidate_name'],"code"=>$row['candidate_code'],"votes"=>$row['votes']);
        
        }
        echo json_encode($data);
    }
}
?>