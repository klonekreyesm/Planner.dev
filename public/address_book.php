<?php

	define('FILENAME', 'data/addressbook.csv');
 	// $filename = 'data/addressbook.csv';

	function readCSV($filename = FILENAME) {
	 
	    $handle = fopen($filename, "r");
	    while(!feof($handle)){
	    	$row = fgetcsv($handle);

	    	if(!empty($row)){
	    		$address_book[] = $row;
	    	}
	    }
	    fclose($handle);

	    return $address_book;
	}


	function save_to_CSV($arrays, $filename = FILENAME){
		$handle = fopen($filename, 'w');
		foreach ($arrays as $array) {
			fputcsv($handle, $array);
		}
		fclose($handle);
	}

	// Define Array of Addresses
	$addressbook = readCSV();

	// Perform Logic on POST
	if (!empty($_POST)) {

		//variables to hold post entries
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$city =$_POST['city'];
		$state=$_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];

		$entry = [$name, $email, $address, $city, $state, $zip, $phone];

		if (empty($name) || empty($email)|| empty($address) || empty($city) || empty($state) || empty($zip) || empty($phone)){
			echo "<script> alert('Please fill out ALL fields')</script>";
		}

		else {
				array_push($addressbook, $entry);
				save_to_CSV($addressbook);

		}	
	}	


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Address Book</title>
	
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>


 <body style="padding-top: 70px;";>
    <div id="container" style ="margin: 20px;">
      <div class="navbar navbar-invers navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">

            </a>
            <!-- Be sure to leave the brand out there if you want it shown -->
            <a class="brand" href="planner.dev/address_book.php">
             <i class="icon-book icon-1x"></i> Address Book</a>
            
          </div>
        </div>
      </div>
  
	  
    	<table class="table table-striped table-bordered table-condensed">
		<tr>
			<th>NAME</th>
			<th>EMAIL</th>
			<th>ADDRESS</th>
			<th>CITY</th>
			<th>STATE</th>
			<th>ZIP CODE</th>
			<th>PHONE</th>
		</tr>
		
		<?php foreach ($addressbook as $key => $entry) { ?> 
			<tr>
				<?php foreach ($entry as $item) { ?>
					<td>
					<?php echo $item;}}?> 
					</td>	
			</tr> 			 
	</table>

	
	
    <div id="container" style ="margin: 50px;">
    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="address_book.php" >
           <h4>add new contact</h4>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="full name">
              
                    <label>Email </label>
                    <input type="email" name="email" placeholder="email@email.com">
                
                    <label>Address</label>
                    <input type="text" name="address" placeholder="street address">

                    <label>City</label>
                    <input type="text" name="city" placeholder="city">

                    <label>State</label>
                    <div><input type="text" name="state" placeholder="state"></div>
               
                    <label>Zipcode</label>
                    <input type="text" name="zip" placeholder="zip code">
                  
                
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="000-000-0000">
                 
         <button type="submit" class="btn btn-primary">submit-eth</button>
    			</div>
	</form>
	</div>

		


</body>
</html>



