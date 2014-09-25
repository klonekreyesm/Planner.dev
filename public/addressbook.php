
<?php

require_once("address_data_store.php");


//$states_arr = array('AL'=>"Alabama",'AK'=>"Alaska",'AZ'=>"Arizona",'AR'=>"Arkansas",'CA'=>"California",'CO'=>"Colorado",'CT'=>"Connecticut",'DE'=>"Delaware",'DC'=>"District Of Columbia",'FL'=>"Florida",'GA'=>"Georgia",'HI'=>"Hawaii",'ID'=>"Idaho",'IL'=>"Illinois", 'IN'=>"Indiana", 'IA'=>"Iowa",  'KS'=>"Kansas",'KY'=>"Kentucky",'LA'=>"Louisiana",'ME'=>"Maine",'MD'=>"Maryland", 'MA'=>"Massachusetts",'MI'=>"Michigan",'MN'=>"Minnesota",'MS'=>"Mississippi",'MO'=>"Missouri",'MT'=>"Montana",'NE'=>"Nebraska",'NV'=>"Nevada",'NH'=>"New Hampshire",'NJ'=>"New Jersey",'NM'=>"New Mexico",'NY'=>"New York",'NC'=>"North Carolina",'ND'=>"North Dakota",'OH'=>"Ohio",'OK'=>"Oklahoma", 'OR'=>"Oregon",'PA'=>"Pennsylvania",'RI'=>"Rhode Island",'SC'=>"South Carolina",'SD'=>"South Dakota",'TN'=>"Tennessee",'TX'=>"Texas",'UT'=>"Utah",'VT'=>"Vermont",'VA'=>"Virginia",'WA'=>"Washington",'WV'=>"West Virginia",'WI'=>"Wisconsin",'WY'=>"Wyoming");


function new_array($items) {
    $new_items = [];
    foreach ($items as $key => $data) {
        $new_items[] = $data;
    }
    return $new_items;
}

class InvalidInputException extends Exception {}

function checkLength($string) {
    $length = true;
    if (strlen($string) > 125) {
        throw new InvalidInputException ('ERROR: Must be shorter than 125 characters.');
        $length = false;
    }
    return $length;
}

$book = new AddressDataStore("data/addressbook.csv");
$book_array = $book->read();

if (!empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['state']) && !empty($_POST['zip'])) {
    // Define new entry to the array
    try {
        if (checkLength($_POST['name']) && checkLength($_POST['phone']) && checkLength($_POST['address']) && checkLength($_POST['city']) && checkLength($_POST['state']) && checkLength( $_POST['zip'])) {
            $newEntry = [$_POST['name'], $_POST['phone'], $_POST['address'], $_POST['city'], $_POST['state'], $_POST['zip']];
            array_push($book_array, $newEntry);
            // Write new array new file
            $book_array = new_array(array_values($book_array));
            $book->write($book_array);
        }
    } catch (Exception $e) {
       $error = $e->getMessage(); //echo "ERROR: Must be shorter than 125 characters.";
    }
} elseif (isset($_POST['submit'])) {
    $error = "ERROR: One or more fields were empty.";
} elseif (isset($_GET['key'])) {
    foreach ($book_array as $key => $data) {
        if ($_GET['key'] == $key) {
            unset($book_array[$key]);
            $book_array = new_array(array_values($book_array));
        }
        $book->write($book_array);
    }
}

if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads';
    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['file1']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);

    $newBook = new AddressDataStore($saved_filename);

    $new = $newBook->read();

    if(isset($_POST['overwrite'])) {
    $book_array = $new;
    } else {
        foreach ($new as $key => $data) {
            array_push($book_array, $new[$key]);
        }
        $book_array = new_array($book_array);
    }

    $book->write($book_array);
}

?>



<html>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <title>Address Book</title>
</head>


<body style = "padding: 75px">
  <h1><span class="glyphicon glyphicon-book"></span> Address Book</h1>
  <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading ">Contact Information</div>
    <table class ="table table-bordered table-condensed table-hover">
        <tr class ="info">
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Delete</th>
         </tr>
             <? foreach($book_array as $key => $address): ?>
                <tr>
                    <? foreach($address as $data): ?>
                    <td><?= htmlspecialchars(strip_tags("{$data}")) ?></td>
                    <? endforeach; ?>
                    <td><?="<a id='remove' name='remove' href='addressbook.php?key=$key'> <button type='button' class='btn btn-default btn-sm'>
                            <span class='glyphicon glyphicon-trash'></span></button></a>" ?></td>
                </tr>
                <? endforeach; ?>
    </table>        
    </div>

    <h4> Add a new contact:</h4>
            <form class = "form-horizontal" method="POST">
                <div class = "form-group">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" placeholder = "John Doe" value="<?if(isset($_POST['name']) && isset($error)){echo htmlspecialchars($_POST['name']);}?>">

                    <label for="phone">Phone Number</label>
                    <input id="name" name="phone" type="text" value="<?if(isset($_POST['name']) && isset($error)){echo htmlspecialchars($_POST['name']);}?>">

                    <label for="address">Address</label>
                    <input id="address" name="address" type="text" value="<?if(isset($_POST['address']) && isset($error)){echo htmlspecialchars($_POST['address']);}?>">

                    <label for="city">City</label>
                    <input id="city" name="city" type="text" value="<?if(isset($_POST['city']) && isset($error)){echo htmlspecialchars($_POST['city']);}?>">

                    <label for="state">State</label>
                    <input id="state" name="state" type="text" value="<?if(isset($_POST['state']) && isset($error)){echo htmlspecialchars($_POST['state']);}?>">

                    <label for="zip">Zip Code</label>
                    <input id="zip" name="zip" type="text" value="<?if(isset($_POST['zip']) && isset($error)){echo htmlspecialchars($_POST['zip']);}?>">
                </div>
                <p id="button">
                    <button class="btn btn-success btn-md" type="submit" id="submit" name="submit">Submit</button>
                </p> 
                <!--error message -->
                <? if(isset($error)): ?>
                    <p><div class="alert alert-danger" role="alert">
                        <?= "{$error}" ?>
                    </p></div>
                <? endif; ?>
                <!--end of error message -->
            </form>
        </div>
  
        <form method="POST" enctype="multipart/form-data" action="addressbook.php">
            <p>
                <label for="file1"><h3>Upload a Saved Address Book: </h3></label>
                <input type="file" id="file1" name="file1">
            </p>
            <p>
                <input class="btn btn-success btn-md" type="submit" value="Upload">
                <p class="help-block">Only .csv file with maximum size of 1 MB is allowed.</p> 
                <!--<form method="POST">
                <label><input type="checkbox" name="overwrite" id="overwrite" value="yes">Overwrite Current List</label> 
                </form>-->
            </p>
        </form>
   


</body>
</html>