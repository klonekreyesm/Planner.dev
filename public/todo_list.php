<?php 

	var_dump($_POST);
	var_dump($_GET);

	?>

	<html>
	<head>
			<title>TODO List</title>
	</head>
	<body>

		
		<h1><u>Todo List</u></h1>
			<ul>
				<li>sample to do items</li>
				<li>wash the car</li>
				<li>walk the dog</li>
				<li>do homework</li>
				<li>sleep</li>
			</ul>
			


		<h2>Add Item to the List</h2>
		<form method="POST">
			<input type="text" id="newitem" name="list[]" placeholder="item here">
			<input type ="submit" value="+"/>
		</form>
	


	</body>
	</html>