<?php

/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 10/26/17
 * Time: 7:59 PM
 */
class Bar
{

    public static function get(){
        $bars = array();
        $mysqli = DB::connect();
        $sql = "SELECT
                      id
                    , `name`
                    , url
                    , iframe
                FROM Bar;";
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
            if(!$stmt->bind_result($id, $name, $url, $iframe)){
                throw new Exception($mysqli->error);
            }
        } catch(Exception $e){
            return CannedResponse::unknownError($e->getMessage());
        }
        if($stmt->num_rows > 0){
            while($stmt->fetch()){
                $bar['id'] = $id;
                $bar['name'] = $name;
                $bar['url'] = $url;
                $bar['iframe'] = $iframe;
                $bar['actions'] = Action::get($id);
                $bars[] = $bar;
            }
        }
        return $bars;
    }

}