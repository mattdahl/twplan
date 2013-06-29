<?php
/*
	The Lions Roar API

	Copyright (c) 2013 Matt Dahl
	contact: matt.dahl.2013@gmail.com
	
	getArticleWithID.php
	description: used to retrieve a single article from a single lookup ID
	parameters: ID (POST)
	returns: object representing an article wrapped in JSON
*/

	// opens database connection
	require("database-info.php"); 
	mysql_select_db("thelions_cfs", $connect);

	session_start();
	
	// functions that build objects
	include("error_object.php");
	include("article_object.php");

	if (isset($_POST["ID"]))
		$id = $_POST["ID"];
	else {
		echo makeErrorObject("getArticleWithID.php", "no ID passed via POST"); // returns an error object
		return;
	}
	
	// lookup article
	$articles_query = mysql_query("SELECT * FROM articles WHERE id = '$id'") or die(mysql_error());
	$row = mysql_fetch_array($articles_query);
	
	if ($row) {
		$title = $row["Title"];
		$author = $row["Authors"];
		// $date = $row["Date"]; // this should be added to the database...
		$body = $row["Article"];
		// $image = $row["Image"]; // if pictures become available
		$section = $row["Section"];
		
		/* $volume = $row["Volume"];
		$issue = $row["Issue"]; // these may be required by the app later, won't return them for now */
		
		echo makeArticleObject($title, $author, NULL, $body, NULL, $section, $id);
		return;
	}
	else {
		echo makeErrorObject("getArticleWithID.php", "no article found with given ID"); // returns an error object
		return;
	}

?>