<?php

/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 10/26/17
 * Time: 6:51 PM
 */
class Player
{

    public static function getAll($playerID){
        $players = array();
        $mysqli = DB::connect();
        $sql = "SELECT id, name FROM Player;";
        $stmt = null;
        try{
            if(!$stmt = $mysqli->prepare($sql)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->execute()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->store_result()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_result($id, $name)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }

        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $player['id'] = $id;
                $player['name'] = $name;
                if($playerID == $id){
                    $player['bars'] = PlayerAction::get($id);
                }
                $player['bars_completed'] = null;
                $player['total_score'] = self::getTotalScore($id);
                $players[] = $player;
            }
        }
        else {
            return CannedResponse::unknownError();
        }


        usort($players, function ($a, $b)
        {
            return min($a['total_score'], $b['total_score']);
        });

        return $players;
    }

    public static function add($name){
        $mysqli = DB::connect();
        $sql = "SELECT * FROM Player WHERE name = ?;";
        $stmt = null;
        try{
            if(!$stmt = $mysqli->prepare($sql)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_param("s", $name)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->execute()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->store_result()){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }

        if($stmt->num_rows > 0){
            return CannedResponse::unknownError("A player named $name already exists.");
        }
        else {
            $int = rand(100,999);
            $password = $name.$int;
            $mysqli = DB::connect();
            $sql = "INSERT INTO Player (`name`, password) VALUES (?,?);";
            $stmt = null;
            try{
                if(!$stmt = $mysqli->prepare($sql)){
                    throw new Exception($mysqli->error);
                }
                if(!$stmt->bind_param("ss", $name, $password)){
                    throw new Exception($mysqli->error);
                }
                if(!$stmt->execute()){
                    throw new Exception($mysqli->error);
                }
                if(!$stmt->store_result()){
                    throw new Exception($mysqli->error);
                }
            } catch(Exception $e){
                return CannedResponse::unknownError($e->getMessage());
            }

            if($mysqli->insert_id){
                return CannedResponse::success("$name has been added. Their password is $password");
            }
            else{
                return CannedResponse::unknownError();
            }
        }

    }

    public static function login($password){
        $mysqli = DB::connect();
        $sql = "SELECT id, `name` FROM Player WHERE password = ?;";
        $stmt = null;
        try{
            if(!$stmt = $mysqli->prepare($sql)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_param("s", $password)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->execute()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->store_result()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_result($id, $name)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }

        if($stmt->num_rows == 1){
            while($stmt->fetch()){
                $player['id'] = $id;
                $player['name'] = $name;
            }
        }
        else {
            return CannedResponse::unknownError();
        }
        return $player;
    }

    public static function getTotalScore($playerID){
        $totalScore = null;
        $mysqli = DB::connect();
        $sql = "SELECT SUM(A.score)
                FROM `Player_Action` PA 
                INNER JOIN Action A ON PA.action_id = A.id
                WHERE PA.player_id = ?";
        $stmt = null;
        try{
            if(!$stmt = $mysqli->prepare($sql)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_param("i", $playerID)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->execute()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->store_result()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_result($score)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }
        if($stmt->num_rows == 1){
            while($stmt->fetch()){
                $totalScore = $score;
            }
        }
        return $totalScore;
    }


}