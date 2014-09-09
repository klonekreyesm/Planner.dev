
<?php
//array of items 
	$items= [];



define('FILENAME','data/mytodolist.txt');

	/* Function openlist() opens the filepath entered by the user. It assigns the trimmed
	opened file path as an array by exploding the strings and separating the list with spaces.
	If the file is not readable, pass a file error. 
	*/
	//open file to populate list
	function openfile($filepath = FILENAME){

	        $handle = fopen($filepath, 'r');
	        $listitems = trim(fread($handle, filesize($filepath)));
	        $list = explode("\n", $listitems);
	        fclose($handle);
	    	return $list;
	    
	}

	//save to file
	function save_to_file($list, $filepath = FILENAME){
		$handle = fopen($filepath, 'w');
			foreach($list as $item){
				fwrite($handle, $item . PHP_EOL);
			}
				fclose($handle);
		}


		$items = openfile();
	//remove file

		
?>

	<html>
	<head>
			<title>TODO List App</title>
			<link rel="stylesheet" href="/css/site.css">

	</head>
	<body>
		<form name ="remove item" method="POST" action="todo_list.php">
		<h1>Things to Do</h1>
			
			<ul style="list-style: none">
			
			<?php 
			if(isset($_POST['additem'])){
				$items[]= $_POST['additem'];
				save_to_file($items);
			}
				foreach($items as $item){
					echo"<label><li><input type = 'checkbox' name='removeitems'>$item".PHP_EOL."</input></li></label>"; 
				}


			?>
			</ul>

		<button type ="submit"> done, son. </button>
		</form>

		<?php 	if(isset($_GET['removeitem'])){
				$items[]=$_GET['removeitem'];
				
                //unset or "remove" item from the array                   
                unset($items[($key-1)]);    
                //reset count on array            
                $items=array_values($items);            
                $key++; 
				}
                 //check for key 'remove' in GET request
                if(isset($_GET['remove'])){
                    // Define variable $keyToRemove according to value
                    $keyToRemove = $_GET['remove'];
                    // Remove item from array according to key specified
                    unset($items[$keyToRemove]);
                    // Numerically reindex values in array after removing item
                    $items = array_values($items);
                    // Save to file
                    save_to_file($items);
                }?>
	</form>


		<form name ="add item" method="POST" action="todo_list.php" >
		<h2>Add Item to the List</h2>
			<input type="text" id="newitem" name="additem" placeholder="item here">
			<button type="submit">+</button>
			</form>
			



		
	


	</body>
	</html>