<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show My Home</title>
    <link rel="stylesheet" href="../css/styles.css" media="screen">
    <!-- <link rel="stylesheet" href="../css/account.css" media="screen"> -->

</head>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/web/snippets/header.php'; ?> 

<main>
    <div class="center">
    <h2>Register</h2>
    
    

    <?php
if (isset($message)) {
 echo $message;
}
?>

        <form method="post" action="/web/accounts/index.php">
       <p>All fields are required</p>     
        <label>First Name:</label><br>
            <input required type="text" placeholder="First Name" name="first_name" id="fname" <?php if(isset($first_name)){echo "value='$first_name'";}  ?>><br>
            <label>Last Name:</label><br>
            <input required type="text" placeholder="Last Name" name="last_name" id="lname" <?php if(isset($last_name)){echo "value='$last_name'";} ?> ><br>
            <label>Phone Number:</label><br>
            <input required type="tel" name="phone" id="phone" placeholder="Phone Number"  <?php if(isset($phone)){echo "value='$phone'";} ?> > <br>
            <label>Are you a realtor?:</label><br>
            <select required name='type'>
                <option selected disabled value="">Select option:</option>
                <option <?php if(isset($isRealtor) && $isRealtor == true){echo "selected";}  elseif(isset($productInfo['type']) && $productInfo['type'] == "top") {echo "selected";} ?> value="true">Yes</option>
                <option <?php if(isset($isRealtor) && $isRealtor == false){echo "selected";}  elseif(isset($productInfo['type']) && $productInfo['type'] == "bottom") {echo "selected";} ?> value="false">No</option>
</select><br>
            <label>Email Address:</label><br>
            <input required type="email" name="email" id="email" placeholder="Email Address"  <?php if(isset($email)){echo "value='$email'";} ?> > <br>
            <label>Password:</label><br>
            <span class="fine-text">must be at least 8 characters and contain at least 1 uppercase character, 1 number and 1 special character </span>
            <input required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" type="password" name="user_password" id="password" placeholder=Password>
          
    <button>Create Account</button>
    <input type="hidden" name="action" value="createAccount">
</form>
 </div>        
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . '/web/snippets/footer.php'; ?> 
</body>

</html>