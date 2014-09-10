
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
        };

        //save to file
        function save_to_file($list, $filepath = FILENAME){
            $handle = fopen($filepath, 'w');
            foreach($list as $item){
                fwrite($handle, strip_tags($item) . PHP_EOL);
            }
            fclose($handle);
        };

        //open file
        $items = openfile();

            //check for key 'additem' in POST request
            if(isset($_POST['additem'])){
                //add item from POST to array $items
                $items[]= $_POST['additem'];
                //save array of items to file
                save_to_file($items);
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
            }

            //file upload 
            // Verify there were uploaded files and no errors
            if (count($_FILES) > 0 && $_FILES['newlist']['error'] === UPLOAD_ERR_OK) {       
                if(isset($_FILES['newlist'])){
                     // Set the destination directory for uploads
                    $upload_dir = 'vagrant/sites/planner.dev/public/uploads/';
                    // Grab the filename from the uploaded file by using basename
                    $uploadBasename = basename($_FILES['newlist']['name']);
                    //concatenate uploaded dir name with basename as new variable
                    $newFilename = $upload_dir.$uploadBasename;
                    // Move the file from the temp location to our uploads directory
                    move_uploaded_file($_FILES['newlist']['name'], $newFilename);
                    //open the file to read the new file
                    $loadeditems = openfile('data/' . $uploadBasename);
                    $items = array_merge($items, $loadeditems);
                    //save to new file
                    save_to_file($items); 
                }
            }
?>

    <html>
    <head>
            <title>TODO List App</title>
            <link rel="stylesheet" href="/css/site.css">

    </head>
    <body>
        <h1>Things to Do</h1>
        <div class="lines" id ='list'></div>
            <ul>
                <!--loop through array $items and output key => value pairs-, refactor to alternate syntax-->
                <?php foreach($items as $key =>$item): ?>
                 <!--//include anchor tag and link to perform GET request according to $key-->
                <li><?="<a href=". "?remove=$key" ."> remove </a>".strip_tags("$key - $item");?></li>
                <?php endforeach ?>     
            </ul>
            
        <!--Form to allow items to be added --> 
        <h4>Add Item to the List</h4>
        <form name ="add item" method="POST" action="todolist2.php" >
            <p>
            <input type="text" id="newitem" name="additem" placeholder="item here">
            <button value="submit">+</button>
            </form>
            </p>

            <!---Form to upload file-->
        <h4>Upload Saved List</h4>
        <form method="POST" enctype="multipart/form-data">
            <p>
            <label for="newlist">File to upload: </label>
            <input type="file" id="newlist" name="newlist"> 
            <input type="submit" value="Upload">
            </form>
            </p>
           



</body>
</html>