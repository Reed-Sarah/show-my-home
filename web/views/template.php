<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show My Home</title>
    <link rel="stylesheet" href="css/styles.css" media="screen">
</head>
<body>
    
<?php require $_SERVER['DOCUMENT_ROOT'] . '/web/snippets/header.php'; ?> 
<main>
  
   
      </main>
   <?php require $_SERVER['DOCUMENT_ROOT'] . '/web/snippets/footer.php'; ?> 

</body>
</html><?php if (isset($_SESSION['message'])) {
        unset($_SESSION['message']);
       } ?>