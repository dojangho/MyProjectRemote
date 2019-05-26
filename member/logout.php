<?php

session_start();

if($_SESSION['username']){
    
    session_destroy();
    header("location: ../index.php");
    
} else {
?>

<script>alert('The unauthorized access'); history.back(); </script>

<?php    
}


