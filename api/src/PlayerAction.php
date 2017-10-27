<?php

/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 10/26/17
 * Time: 6:46 PM
 */
class PlayerAction
{

    public static function upsert($barID, $playerID, $actionID){
        $mysqli = DB::connect();
        $sql = "INSERT INTO Player_Action (
                      bar_id
                    , player_id
                    , action_id) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    action_id = ?;";
        $stmt = null;
        try{
            if(!$stmt = $mysqli->prepare($sql)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_param("iiii", $barID, $playerID, $actionID, $actionID)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->execute()){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }

        return CannedResponse::success('Success');
    }

    public static function get($playerID){
        $bars = array();
        $mysqli = DB::connect();
        $sql = "SELECT
                      B.id
                    , B.name
                    , A.id
                    , A.description
                    , S.numerical_score
                    , S.score
                FROM Player_Action AS PA
                RIGHT JOIN Bar AS B ON PA.bar_id = B.id
                INNER JOIN `Action` AS A ON PA.action_id = A.id
                INNER JOIN Score AS S On A.score = S.numerical_score
                WHERE PA.player_id = ?;";
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
            if(!$stmt->bind_result($id, $name, $actionID, $actionDescription, $numericalScore, $score)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $bar['id'] = $id;
                $bar['name'] = $name;
                $bar['action_id'] = $actionID;
                $bar['action_description'] = $actionDescription;
                $bar['numerical_score'] = $numericalScore;
                $bar['score'] = $score;
                $bars[] = $bar;
            }
        }

        return $bars;

    }


}