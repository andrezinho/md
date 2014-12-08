<?php
      require_once '../lib/spdo.php'; 
      $db = Spdo::singleton();
     
      $email = $_POST['b']; //echo $email;
       
      if(!empty($email)) {
            comprobar($email,$db);
      }
       
      function comprobar($b,$db) {
            $stmt = $db->prepare("SELECT count(email) as n FROM usuario where email=:c ");
            $stmt->bindParam(':c',$b,PDO::PARAM_STR);
            $stmt->execute();
            $r = $stmt->fetchObject();
            if($r->n==0)
            { echo "1";}
            
            else{echo "2";}
      }     
?>
