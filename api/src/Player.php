<?php

/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 10/26/17
 * Time: 6:51 PM
 */
class Player
{

    public static function getAll(){
        $players = array();
        $mysqli = DB::connect();
        $sql = "SELECT DISTINCT * FROM (
                    SELECT
                          P.id
                        , P.name
                        , SUM(SUBQUERY.numerical_score)
                        , COUNT(SUBQUERY.score)
                    FROM Player AS P
                    LEFT JOIN (
                        SELECT
                             *
                        FROM Player_Action AS PA
                        INNER JOIN (
                            SELECT
                                  A.id
                                , A.description
                                , S.numerical_score
                                , S.score
                            FROM Action AS A
                            INNER JOIN Score AS S ON A.score = S.numerical_score
                        ) AS SUBQUERY ON SUBQUERY.id = PA.action_id
                    ) AS SUBQUERY ON P.id = SUBQUERY.player_id

                    UNION
                    SELECT id, name, null, null FROM Player
                ) AS tbl
                GROUP BY id;";
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
            if(!$stmt->bind_result($id, $name, $totalScore, $barsCompleted)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }

        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $player['id'] = $id;
                $player['name'] = $name;
                $player['bars'] = PlayerAction::get($id);
                $player['bars_completed'] = $barsCompleted;
                $player['total_score'] = $totalScore;
                $players[] = $player;
            }
        }
        else {
            return CannedResponse::unknownError();
        }

        return $players;
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

}