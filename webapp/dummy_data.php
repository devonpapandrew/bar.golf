<?php



$arr = 
array(
	players => 
	array(
		array(
			id => 1,
			name => 'Devon',
			bars => 
			array(
				array(
				  id => "100",
				  name => "James Joyce",
				  action => "44",
				  score => "Bogey",
				  numerical_score => "1"
				),
				array(
				  "id" => "200",
				  "name" => "First Chance Last Chance",
				  "action" => "511",
				  "score" => "Par",
				  "numerical_score" => "0"
				),
				array(
				  "id" => "300",
				  "name" => "Gaspar's Grotto",
				  "action" => null,
				  "score" => null,
				  "numerical_score" => null
				)
			),
			bars_completed => 2, 
			total_score => 1
		),
		array(
			id => 2,
			name => 'Steve',
			bars => 
			array(
				array(
				  id => "100",
				  name => "James Joyce",
				  action => "43",
				  score => "Par",
				  numerical_score => "0"
				),
				array(
				  "id" => "200",
				  "name" => "First Chance Last Chance",
				  "action" => "555",
				  "score" => "Eagle",
				  "numerical_score" => "-2"
				),
				array(
				  "id" => "300",
				  "name" => "Gaspar's Grotto",
				  "action" => null,
				  "score" => null,
				  "numerical_score" => null
				)
			),
			bars_completed => 2, 
			total_score => -2
		)
	)
);

echo json_encode($arr);