<?php

/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 10/26/17
 * Time: 8:03 PM
 */
class Action
{
    public static function get($barID){
        $actions = array();
        $mysqli = DB::connect();
        $sql = "SELECT
                      A.id
                    , A.description
                    , S.numerical_score
                    , S.score
                FROM Action AS A
                INNER JOIN Score AS S ON A.score = S.numerical_score
                WHERE A.bar_id = ?;";
        $stmt = null;
        try{
            if(!$stmt = $mysqli->prepare($sql)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_param("i", $barID)){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->execute()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->store_result()){
                throw new Exception($mysqli->error);
            }
            if(!$stmt->bind_result($id, $description, $numericalScore, $score)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $action['id'] = $id;
                $action['description'] = $description;
                $action['numerical_score'] = $numericalScore;
                $action['score'] = $score;
                $actions[] = $action;
            }
        }
        return $actions;
    }
}