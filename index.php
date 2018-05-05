<?php

$action = $_POST["action"];
if($action != null)
{
	//Fill this with your own path.
	//It is recommended that the games are not stored on a place that is visible on the internet.
	//If so players could cheat by seeing each other's playerIDs and make a bad turn for them.
	$pathToGames = "";
	
	//Start game
	if($action == "start")
	{
		//Join to existing game
		if(file_exists($pathToGames . "not-started.txt"))
		{
			$notStartedGame = file_get_contents($pathToGames . "not-started.txt");
			$game = file_get_contents($pathToGames . $notStartedGame . ".json");
			$json = json_decode($game, true);
			$playerID = randomString();
			$side = "";
			if($json["playerO"] == "")
			{
				$json["playerO"] = $playerID;
				$side = "O";
			}
			else
			{
				$json["playerX"] = $playerID;
				$side = "X";
			}
			$json["status"] = "started";
			
			$path = $pathToGames . $json["gameID"] . ".json";
			file_put_contents($path, json_encode($json));
			unlink($pathToGames . "not-started.txt");
			
			header('Content-Type: application/json');
			$response = array
			(
				"playerID" => $playerID,
				"gameID" => $json["gameID"],
				"side" => $side
				
			);
			echo json_encode($response);
			die;
		}
		//Create new game
		else
		{
			$gameID = randomString();
			while(file_exists($pathToGames . $gameID . ".json"))
			{
				$gameID = randomString();
			}
			
			$playerID = randomString();
			$side = "";
			$playerO = "";
			$playerX = "";
			if(rand(0,1) == 0)
			{
				$playerO = $playerID;
				$side = "O";
			}
			else
			{
				$playerX = $playerID;
				$side = "X";
			}
			
			$json = array
			(
				"gameID" => $gameID,
				"playerO" => $playerO,
				"playerX" => $playerX,
				"status" => "notStarted",
				"turn" => "O",
				"state" => [["","",""],["","",""],["","",""]]
			);
			file_put_contents($pathToGames . $gameID . ".json", json_encode($json));
			file_put_contents($pathToGames . "not-started.txt", $gameID);
			
			header('Content-Type: application/json');
			$response = array
			(
				"playerID" => $playerID,
				"gameID" => $gameID,
				"side" => $side
				
			);
			echo json_encode($response);
			die;
		}
	}
	
	//Get the game status
	if($action == "status")
	{
		$gameID = $_POST["gameID"];
		if($gameID == "")
		{
			returnError("gameID is required.");
		}
		else
		{
			if(!file_exists($pathToGames . $gameID . ".json"))
			{
				returnError("No game with ID " . $gameID . " found.");
			}
			else
			{
				$game = file_get_contents($pathToGames . $gameID . ".json");
				$json = json_decode($game, true);
				
				header('Content-Type: application/json');
				$response = array
				(
					"status" => $json["status"],
					"turn" => $json["turn"],
					"state" => $json["state"]
				);
				$winner = $json["winner"];
				if($winner != "")
				{
					$response["winner"] = $winner;
				}
				echo json_encode($response);
				die;
			}
		}
	}
	
	//Take a turn by placing O or X
	if($action == "place")
	{
		$gameID = $_POST["gameID"];
		if($gameID == "")
		{
			returnError("gameID is required.");
		}
		else
		{
			$playerID = $_POST["playerID"];
			if($playerID == "")
			{
				returnError("playerID is required.");
			}
			else
			{
				if(!file_exists($pathToGames . $gameID . ".json"))
				{
					returnError("No game with ID " . $gameID . " found.");
				}
				else
				{
					$game = file_get_contents($pathToGames . $gameID . ".json");
					$json = json_decode($game, true);
					
					if($json["status"] == "notStarted")
					{
						returnError("This game is not yet started.");
					}
					else if($json["status"] == "ended")
					{
						returnError("This game is already ended.");
					}
					else
					{
						if(($json["turn"] == "O" && $playerID == $json["playerO"]) ||
						   ($json["turn"] == "X" && $playerID == $json["playerX"]))
						{
							$position = $_POST["position"];
							if($position == "")
							{
								returnError("position is required.");
							}
							else if(!is_numeric($position))
							{
								returnError("position must be a number.");
							}
							else
							{
								$position = (int)$position;
								if($position < 1 || $position > 9)
								{
									returnError("position must be from between 1 and 9.");
								}
								else
								{
									$row = floor(($position - 1) / 3);
									$column = ($position - 1) % 3;
									
									if($json["state"][$row][$column] != "")
									{
										returnError("This position already has '" . $json["state"][$row][$column] . "'");
									}
									else
									{
										$json["state"][$row][$column] = $json["turn"];
										if($json["turn"] == "O")
										{
											$json["turn"] = "X";
										}
										else
										{
											$json["turn"] = "O";
										}
										$winner = getWinner($json["state"]);
										if($winner != "")
										{
											$json["status"] = "ended";
											$json["winner"] = $winner;
										}
										
										file_put_contents($pathToGames . $gameID . ".json", json_encode($json));
				
										header('Content-Type: application/json');
										$response = array
										(
											"status" => $json["status"],
											"turn" => $json["turn"],
											"state" => $json["state"]
										);
										if($winner != "")
										{
											$response["winner"] = $winner;
										}
										echo json_encode($response);
										die;
									}
								}
							}
						}
						else
						{
							returnError("It is not your turn.");
						}
					}
				}
			}
		}
	}
}


//Generate a random 10 characters long string
function randomString()
{
	$string = "abcdefghijklmnopqrstuvwxyz0123456789";
	$rand = "";
	for($i = 0; $i < 10; $i++)
	{
		$rand .= $string[rand(0, 35)];
	}
	return $rand;
}

//Get the winner of the game
function getWinner($state)
{
	//Check for rows
	for($i = 0; $i < 3; $i++)
	{
		if($state[$i][0] != "" && $state[$i][0] == $state[$i][1] && $state[$i][1] == $state[$i][2])
		{
			return $state[$i][0];
		}
	}
	//Check for columns
	for($i = 0; $i < 3; $i++)
	{
		if($state[0][$i] != "" && $state[0][$i] == $state[1][$i] && $state[1][$i] == $state[2][$i])
		{
			return $state[0][$i];
		}
	}
	//Check for diagonals
	if($state[0][0] != "" && $state[0][0] == $state[1][1] && $state[1][1] == $state[2][2])
	{
		return $state[0][0];
	}
	if($state[0][2] != "" && $state[0][2] == $state[1][1] && $state[1][1] == $state[2][0])
	{
		return $state[0][2];
	}
	
	//Check for tie
	for($r = 0; $r < 3; $r++)
	{
		for($c = 0; $c < 3; $c++)
		{
			if($state[$r][$c] == "")
			{
				return "";
			}
		}
	}
	return "tied";
}

//Return JSON with given error message
function returnError($msg)
{
	header('Content-Type: application/json');
	$response = array
	(
		"error" => $msg
	);
	echo json_encode($response);
	die;
}

?>