<?php
/*
    Purpose: Methods to connect to and execute queries on the RWStudios Database
    Author: LV
    Date: February 2013
*/

// function to connect to the database

function dbConnect()
{
    $serverName = 'bussql2012-cis';
    $uName = 'etadmin';
    $pWord = 'cis665';
    $db = 'EstimationToolDB';
    
    try
    {
        //instantiate a PDO object and set connection properties
        
        $conn = new PDO("sqlsrv:Server=$serverName; Database=$db", $uName, $pWord, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        //return connection object

        return $conn;
    }
    // if connection fails
    
    catch (PDOException $e)
    {
        die('Connection failed: ' . $e->getMessage());
    }
}

//method to execute a query - the SQL statement to be executed, is passed to it

function executeQuery($query)
{
    // call the dbConnect function

    $conn = dbConnect();

    try
    {
        // execute query and assign results to a PDOStatement object

        $stmt = $conn->query($query);

        do
        {
            if ($stmt->columnCount() > 0)  // if rows with columns are returned
            {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  //retreive the rows as an associative array
            }
        } while ($stmt->nextRowset());  // if multiple queries are executed, repeat the process for each set of results

//        echo '<pre style="font-size:large">';
//        print_r($results);
//        echo '</pre>';
//        die;

       //call dbDisconnect() method to close the connection

        dbDisconnect($conn);

        return $results;
    }
    catch (PDOException $e)
    {
        //if execution fails

        dbDisconnect($conn);
        die ('Query failed: ' . $e->getMessage());
    }
}
function dbDisconnect($conn)
{
    // closes the specfied connection and releases associated resources

    $conn = null;
}

?>
