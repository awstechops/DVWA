<!DOCTYPE html>
<html>
  <head>

 
<style>

.login_form {
  background-color:#ccccff;
  padding: 8%;
  width:16%;
  margin: auto;
  border-radius: 10px;
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
 
.text_sect{
  text-align: center;
  margin-bottom: 10%;

}


input[type=text] {
  position: relative;
  width: 100%;
  padding: 12px 20px;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
}

#btn1 {
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




  <div class = "login_form"> 
    
  
 
    <form name= "email_form" action="mfa_2.php" method="post">
  <b> <p>Please enter your email for a verification code!</p></b>

    <div class = "text_sect">
</div>
      <label class = 'email' for="email"><b>Email address:</b></label><br><br>
      <input type="text" id="email" name="email" required><br><br>
  
     

      <button id = "btn1" name="send">Send code</button>
      <button id = "btn1" name="back" onclick="window.location='login_1.php';return false;">Cancel</button>


    
    </form>

  
  </div>
  <script>
console.log(location.href);
</script>
</body>



</html>



