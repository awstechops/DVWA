<!DOCTYPE html>
<html>
  <head>

  
 
<style>

.otp_form {
  background-color: #ccccff;
  padding: 8%;
  width:16%;
  margin: auto;
  border-radius: 20px;
  border: 10px solid #009900;
    
}
  
#register_form {
  background-color: #ccccff;
  padding: 8%;
  width:16%;
  margin: auto;
  border-radius: 10px;
  border: 10px solid rgb(7, 7, 194) ;
    
}
 
input[type=text] {
  position: relative;
  width: 100%;
  padding: 12px 20px;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#submit {
  background-color: #009900;
  color: white;
  padding: 12px ;
  border-radius: 20px;
  margin: 15px;
  width: 100%;
  border: none;
}
.register {
    display: block;
}

label {
    font-size: large;
}
  
 
</style>


  </head>


 
<body>

<?php
$otp = rand(111111,999999);
//$str= rand();

?>
 <script>


function validation(){
  var otp = "<?php echo $otp; ?>";
  var x = document.forms["otp_forms"]["otp_enter"].value;
  
  if (x == otp) {
  alert("Your login was successful!");
  return true;
  }
  else if(x != otp)
  {
    alert("Your login failed, please try again!");
    return false;
    
  }
  else{
    alert("please enter your code!");
    return false;
  }

  }

  </script>


<div class = "otp_form"> 

<form name="otp_forms" action="index.php"  method = "post" onsubmit ="return validation()">

<label class = 'otp' for="otp"><b>Please enter the code sent to your email:</b></label><br><br>
      <input type="text" name="otp_enter"><br><br>
  
    
    
      <button id = "submit">Verify</button>
    
      <button id = "submit" onclick="window.location='mfa.php';return false;">cancel</button>

    
    </form>

</div>
    




 



</body>
</html>




<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST["send"]))
{ 
  

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'devalrajgor076@gmail.com';
    $mail->Password = 'opxkgicnkrwlnayn'; 
    $mail->SMTPSecure='ssl';
    $mail->Port = 465;
    
    $mail->setFrom('donotreply@TB.com');

    $mail->addAddress($_POST["email"]);
    $mail->isHTML(true);
    $mail->Subject= "TB bank authentication code";
    $mail->Body="Dear user, <br />your 6 digit token for verification is: ".$otp;

    $mail->send();
}
?>

