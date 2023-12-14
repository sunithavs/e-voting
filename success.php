<?php
session_start();
include('header.php');
if(!isset($_SESSION['user_id'])){
    session_destroy();
    header("location:index.php");
}
include('menubar.php');
?>
<div class="panel panel-default">
    <div class="panel-heading">
     <!-- <h3 class="panel-title">Welcome to system</h3> -->
    </div>
    <div class="panel-body">
     <h1>Thanks for voting</h1>
    </div>
   </div>
<?php
   include('footer.php');
?>
