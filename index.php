<?php 
    include('config.php');
    include('connection.php');
    
    $sql = file_get_contents('query.sql');
    
    foreach ($databases as $database) {
        try {
            $connection->exec("USE {$database};");
            
            // execute query
            if (!$connection->exec($sql)) {
                throw new \Exception("Error");   
            }
        } catch (\Exception $e) {
            // save error
            $connection->exec("USE {$database_log};");
            $message = utf8_encode(str_replace("'", "\'", $e->getMessage()));
            $sql = utf8_encode(str_replace("'", "\'", $sql));
            $connection->exec("INSERT INTO {$table_log} VALUES(NULL, '{$database}', '{$message}', 'teste', '{$sql}');"); 
        } catch (PDOException$e) {
            // save error
            $connection->exec("USE {$database_log};");
            $message = utf8_encode(str_replace("'", "\'", $e->getMessage()));
            $sql = utf8_encode(str_replace("'", "\'", $sql));
            $connection->exec("INSERT INTO {$table_log} VALUES(NULL, '{$database}', '{$message}', 'teste', '{$sql}');");
        }
    }
    
    $connection = null;    
?>