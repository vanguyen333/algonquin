<?php
// Include entityDAO file
require_once('./dao/entityDAO.php');

 
// Define variables and initialize with empty values
$name = $birthdate = $image = "";
$name_err = $birthdate_err = $image_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
     // Validate birthdate
    $input_birthdate = trim($_POST["birthdate"]);
    if(empty($input_birthdate)){
        $birthdate_err = "Please enter a birthdate.";     
    } else{
        $birthdate = $input_birthdate;
    }
    
    //Upload image
    $target_dir = "images/";
    $target_file = $target_dir.basename($_FILES["image"]["name"]); //path of the file to be uploaded
    $uploadOk = 1; 
    $image = ($_FILES["image"]["name"]);

    if(isset($_POST["submit"])) { 
    // Check for the image size to verify a file was uploaded
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - ".$check['mime'] . ".";
            $uploadOk = 1;
        }else{
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    if($uploadOk == 0){
        echo "Sorry, your file was not uploaded";
    }else{
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            echo "The file has been uploaded.";
        } else {
            // if no image was uploaded, echo 0. Will return an error message (JS)
            echo "Sorry, there was an error uoloading your file.";
        }
    }
    

    // Check input errors before inserting in database
    if(empty($name_err) && empty($birthdate_err) && empty($image_err)){
        $entityDAO = new entityDAO();    
        $entity = new Entity(0, $name, $birthdate, $image);
        $addResult = $entityDAO->addEntity($entity);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $entityDAO->getMysqli()->close();
    }
} 
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add pet record to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Birthdate</label>
                            <textarea name="birthdate" class="form-control <?php echo (!empty($birthdate_err)) ? 'is-invalid' : ''; ?>"><?php echo $birthdate; ?></textarea>
                            <span class="invalid-feedback"><?php echo $birthdate_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <!-- <input type="text" name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $image; ?>"> -->
                            <span class="invalid-feedback"><?php echo $image_err;?></span>
                            <input type="file" name="image" class="form-control" accept="image/*" id="imageFile">
                            <p id="uploadError"></p>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <!-- <button type="button" class="btn btn-primary" onclick="uploadFile()">Upload</button> -->
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
        <?include 'footer.php';?>
    </div>
</body>
</html>