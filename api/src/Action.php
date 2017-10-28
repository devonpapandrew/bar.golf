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
                    id, description, S.numerical_score, S.score
                FROM Score AS S
               	LEFT JOIN (
                    SELECT A.id, A.description, A.score FROM Action AS A WHERE A.bar_id = ?) AS tbl
                    ON tbl.score = S.numerical_score
                ORDER BY S.numerical_score DESC;";
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
                $action['selected'] = false;
                $actions[] = $action;
            }
        }
        return $actions;
    }
}