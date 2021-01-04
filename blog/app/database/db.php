<?php
session_start(); //starting the session to check user login.Now in all the pages using this files containig database file the session will automatically started
//cause i want the function in that file
require('connect.php');

//var_dump($users); //here display the database with bad shape
// this function only for development not in my source 
function dd($value)
{
	echo "<pre>", print_r($value, true), "</pre>";                 // print_r create 1 that mean true so i will fix it by adding true
	die(); 														// stop its job after execution
}
// The above fucntion is just to work and observe the variables and methods during the development


/*this function is for brief purpose 
  data here refers to $conditions*/
//   This is for executing query safely using bind params and preventing the sql injection.
function executeQuery($sql, $data)
{
	global $conn;
	$stmt = $conn->prepare($sql); 		  						//ready to connection 
	$values = array_values($data);						// record values of cond into values variables ||get values
	$types = str_repeat('s', count($values));					// s here mean the string values of cond || get types 
	$stmt->bind_param($types, ...$values);					   //...this mean $dmin, $values, but its in high php version 
	$stmt->execute();
	return $stmt;
}


// This is select all query to query recods from the table
/*in $condition if empty=> mean no condtions that in line no 43 => nothing to show just ready connection
  in $condition if not empty=> there is a loop to change the database by the admin and $key=$value mean that admin=1
*/
function selectAll($table, $conditions = []) //Condition is oprtional parameter
{
	global $conn; 												//cause every function could use it 
	$sql = "SELECT * FROM $table"; 		  					 	// here we select all from users table

	if (empty($conditions)) {									//without filters and conditions
		$stmt = $conn->prepare($sql); 		  						//ready to connection 
		$stmt->execute();
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
		return $records;
	} else {
		//return recorda that match the conditions
		// $sql = " SELECT * FROM $table WHERE username='Awa' AND admin='1';
		//forming a query
		$i = 0;
		foreach ($conditions as $key => $value) {
			if ($i === 0) {
				$sql = $sql . " WHERE $key=?"; // ? to prevent sql injqtion #1 up we use bind parameter here
			} else {
				$sql = $sql . " AND $key=?";   // #1

			}
			$i++;
		}



		$stmt = executeQuery($sql, $conditions); 					 //executes the data inserted
		$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
		return $records;
	}
}



// selectOne is function to display one row
function selectOne($table, $conditions)
{
	global $conn; 												//cause every function could use it 
	$sql = "SELECT * FROM $table"; 		  					 	// here we select all from users table
	//return recorda that match the conditions
	// $sql = " SELECT * FROM $table WHERE username='Awa' AND admin='1';
	$i = 0;
	foreach ($conditions as $key => $value) {
		if ($i === 0) {
			$sql = $sql . " WHERE $key=?";
		} else {
			$sql = $sql . " AND $key=?";
		}
		$i++;
	}


	$sql = $sql . " LIMIT 1";
	$stmt = executeQuery($sql, $conditions); 		 //executes the data inserted
	$records = $stmt->get_result()->fetch_assoc(); 	//fetch only one row to dispaly it and save it 
	return $records;
}



function create($table, $data)
{
	global $conn;
	// $sql = "INSERT INTO users SET username=?, admin=?, email=?, password=?"
	$sql = "INSERT INTO $table SET ";

	$i = 0;
	foreach ($data as $key => $value) {
		if ($i === 0) {
			$sql = $sql . " $key=?";
		} else {
			$sql = $sql . ", $key=?";
		}
		$i++;
	}
	$stmt = executeQuery($sql, $data);
	$id = $stmt->insert_id;
	return $id;
}



function update($table, $id, $data)
{
	global $conn;
	// $sql = "UPDATE users SET username=?, admin=?, email=?, password=? WHERE id=?"
	$sql = "UPDATE $table SET ";

	$i = 0;
	foreach ($data as $key => $value) {
		if ($i === 0) {
			$sql = $sql . " $key=?";
		} else {
			$sql = $sql . ", $key=?";
		}
		$i++;
	}

	$sql = $sql . " WHERE id=?";
	$data['id'] = $id;
	$stmt = executeQuery($sql, $data);
	return $stmt->affected_rows;
}



function delete($table, $id)
{
	global $conn;
	$sql = "DELETE FROM $table WHERE id=?";

	$stmt = executeQuery($sql, ['id' => $id]);
	return $stmt->affected_rows;
}
// Fetching username of the published projects from the database along with all tha data of projects into array
function getPublishedPosts()
{
	global $conn;
	// SELECT FROM POSTS WHERE PUBLISHED = 1;
	// $sql = "SELECT p.*, u.username FROM projects AS p JOIN users AS u ON p.user_id = u.id WHERE p.published= ?";
	// $sql = "SELECT p.*, u.username,i.name FROM projects AS p JOIN users AS u JOIN institutes AS i ON p.user_id = u.id WHERE p.published= ?";
	// $sql = "SELECT p.*, u.username,i.name FROM projects p,users u, institutes i WHERE p.published= ?";
	$sql = "SELECT projects.*, users.username, institutes.name
	FROM ((projects
	INNER JOIN users ON projects.user_id = users.id)
	INNER JOIN institutes ON projects.institute_id = institutes.id)
	WHERE projects.published= ?";
	$stmt = executeQuery($sql, ['published' => 1]); 					 //executes the data inserted
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
// researches
function getPublishedResearches()
{
	global $conn;
	// SELECT FROM POSTS WHERE PUBLISHED = 1;
	// $sql = "SELECT p.*, u.username FROM projects AS p JOIN users AS u ON p.user_id = u.id WHERE p.published= ?";
	// $sql = "SELECT p.*, u.username,i.name FROM projects AS p JOIN users AS u JOIN institutes AS i ON p.user_id = u.id WHERE p.published= ?";
	// $sql = "SELECT p.*, u.username,i.name FROM projects p,users u, institutes i WHERE p.published= ?";
	$sql = "SELECT researches.*, users.username, institutes.name
	FROM ((researches
	INNER JOIN users ON researches.user_id = users.id)
	INNER JOIN institutes ON researches.institute_id = institutes.id)
	WHERE researches.published= ?";
	$stmt = executeQuery($sql, ['published' => 1]); 					 //executes the data inserted
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
// Implementing search on home page
function searchPosts($term)
{
	$match = '%' . $term . '%'; //due to sql injection security issue in query string
	global $conn;
	// SELECT user search results
	// Search Query
	$sql = "SELECT
	p.*, u.username
	FROM projects AS p
	JOIN users AS u
	ON p.user_id = u.id 
	WHERE p.published= ?
	AND p.title LIKE ? OR p.body LIKE ?";
	//only published posts using query which matched the title and body of the project
	$stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]); //This will be insreted  in the above query ? where placeholders
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
// Implementing search on researches page
function searchResearches($term)
{
	$match = '%' . $term . '%'; //due to sql injection security issue in query string
	global $conn;
	// SELECT user search results
	// Search Query
	$sql = "SELECT
	p.*, u.username
	FROM researches AS p
	JOIN users AS u
	ON p.user_id = u.id 
	WHERE p.published= ?
	AND p.title LIKE ? OR p.body LIKE ?";
	//only published posts using query which matched the title and body of the project
	$stmt = executeQuery($sql, ['published' => 1, 'title' => $match, 'body' => $match]); //This will be insreted  in the above query ? where placeholders
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
// Fetching researches related to specific topic when we click on any one of the topic
function getResearchesByTopicID($topic_id)
{
	global $conn;
	// SELECT FROM POSTS WHERE PUBLISHED = 1;
	$sql = "SELECT p.*, u.username 
	FROM researches AS p 
	JOIN users AS u ON p.user_id = u.id 
	WHERE p.published= ? 
	AND p.topic_id = ?";
	$stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]); 					 //executes the data inserted
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
// Fetching posts related to specific topic when we click on any one of the topic
function getProjectsByTopicID($topic_id)
{
	global $conn;
	// SELECT FROM POSTS WHERE PUBLISHED = 1;
	$sql = "SELECT p.*, u.username 
	FROM projects AS p 
	JOIN users AS u ON p.user_id = u.id 
	WHERE p.published= ? 
	AND p.topic_id = ?";
	$stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $topic_id]); 					 //executes the data inserted
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
// Fetching researches related to specific institute when we click on any one of the topic
function getResearchesByInstituteID($institute_id)
{
	global $conn;
	// SELECT FROM researches WHERE PUBLISHED = 1;
	$sql = "SELECT p.*, u.username FROM researches AS p JOIN users AS u ON p.user_id = u.id WHERE p.published= ? AND p.institute_id = ?";
	$stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $institute_id]); 					 //executes the data inserted
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}

// Fetching posts related to specific institute when we click on any one of the topic
function getProjectsByInstituteID($institute_id)
{
	global $conn;
	// SELECT FROM POSTS WHERE PUBLISHED = 1;
	$sql = "SELECT p.*, u.username FROM projects AS p JOIN users AS u ON p.user_id = u.id WHERE p.published= ? AND p.institute_id = ?";
	$stmt = executeQuery($sql, ['published' => 1, 'topic_id' => $institute_id]); 					 //executes the data inserted
	$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); 	//fetch it and save it 
	return $records;
}
/*this code is pathed for create function that take second parameter $data so the error was i don`t specify the the data*/
/*
$data = [
	 'username'=>'Melvinee',
	 'admin'=>1,
	 'email'=>'melvine@melvine.com',
	 'password'=>'melvine'
];
// just for testing
	$id = create('users', $data);
	dd($id);	
*/