<?php 
    include('config.php');
    include('connection.php');
    
    $sql = file_get_contents('query.sql');
    
    // remove exec time
    set_time_limit(0);
    
    foreach ($databases as $database) {
        try {
            $connection->exec("USE {$database};");
            
            // execute query
            if (!$connection->exec($sql)) {
                throw new \Exception("Error");   
            }
            
            echo "SQL Query on database <b>\"{$database}\"</b> successfully! <br>";
            
        } catch (\Exception $e) {
            // save error
            $connection->exec("USE {$database_log};");
            $message = utf8_encode(str_replace("'", "\'", $e->getMessage()));
            $sql = utf8_encode(str_replace("'", "\'", $sql));
            $connection->exec("INSERT INTO {$table_log} VALUES(NULL, '{$database}', '{$message}', 'teste', '{$sql}');");
            echo "SQL Query on database <b>\"{$database}\"</b> fail... <br>";
        } catch (PDOException$e) {
            // save error
            $connection->exec("USE {$database_log};");
            $message = utf8_encode(str_replace("'", "\'", $e->getMessage()));
            $sql = utf8_encode(str_replace("'", "\'", $sql));
            $connection->exec("INSERT INTO {$table_log} VALUES(NULL, '{$database}', '{$message}', 'teste', '{$sql}');");
            echo "SQL Query on database <b>\"{$database}\"</b> fail... <br>";
        }
    }
    
    $connection = null;    
?>
