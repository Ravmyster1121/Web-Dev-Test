<!DOCTYPE html>

<html>
    <head>
        <title>Status Search Results</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>

    <body>
        <div class="container">

            <div class="topnav">
                <a href="index.html">Home</a>
                <a href="poststatusform.php">Post Status</a>
                <a class="active" href="searchstatusform.html">Search Status</a>
                <a id="about" href="about.html">About</a>
            </div>

            <h1>Status Search Results</h1>

            <?php
                //Getting connection settings and credentials to connect to database
                //LOGIN CREDENTIALS ARE ENTERED IN settings.php file
                require_once("settings.php");

                //Opens new connection to database
                $conn = new mysqli($host, $user, $pswd, $dbnm);

                //Check if able to connect to database
                if($conn->connect_error){
                    die("<p class='error'>Connection to database failed. <br>
                        Check login credentials in settings.php file.<br>
                        Error Code" . $conn->connect_error . "</p>");
                }
                
                else{
                    //Upon successfull connection

                    //storing entered search term via get method
                    $search = $_GET["search"];

                    //Checking if the table exists already
                    if(mysqli_query($conn, "SELECT 1 FROM posts LIMIT 1") == true){
                        //If the table DOES exist

                        //Creating query to select row that matches search query
                        $query = "SELECT * FROM posts WHERE post_text LIKE '%" . $search . "%'";

                        //Execute query and storing returned result
                        $result = mysqli_query($conn, $query);
                        $tempResult = mysqli_query($conn, $query);
                        
                        //Check query was not successfull
                        if((!$result))
                        {
                            echo "<p class='error'>There was a problem with the search term: " . $search . "</p>";
                        }
                        //If query was successfull
                        else
                        {
                            //Checks if no rows were returned
                            if(is_null(mysqli_fetch_assoc($tempResult)))
                            {
                                echo "<p class='error'>There were no results returned from search term: " . $search . "</p>";
                            }
                            //If a row from the table was returned
                            else
                            {
                                //Iterate through and display all returned rows
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    //Translating the like,comment and share booleans to "Yes" or "No" strings
                                    if($row["perm_like"] = 1){
                                        $perm_like = "Yes";
                                    }
                                    else{
                                        $perm_like = "No";
                                    }
            
                                    if($row["perm_comment"] = 1){
                                        $perm_comment = "Yes";
                                    }
                                    else{
                                        $perm_comment = "No";
                                    }
            
                                    if($row["perm_share"] = 1){
                                        $perm_share = "Yes";
                                    }
                                    else{
                                        $perm_share = "No";
                                    }
                                    
                                    echo "<h3>Status Information</h3><p>";
                                    echo "<b>Status Code: </b>" . $row["post_id"] . "<br>";
                                    echo "<b>Status: </b>" . $row["post_text"] . "<br>";
                                    echo "<b>Shared With: </b>" . $row["share_type"] . "<br>";
                                    echo "<b>Date posted: </b>" . $row["date"] . "<br>";
                                    echo "<b>Allow Likes: </b>" . $perm_like . "<br>";
                                    echo "<b>Allow Comments: </b>" . $perm_comment . "<br>";
                                    echo "<b>Allow Sharing: </b>" . $perm_share . "<br></p>";
                                }
                            }
                        }
                    
                        //Close databse connection and release result sets
                        mysqli_free_result($result);
                        mysqli_free_result($tempResult);

                    }
                    else
                    {
                        //If the table does not exist
                        echo "<p class='error'>
                            The table does not exist.<br>
                            Please post a status and try again.
                        </p>";
                    }
                }
                
                //Closing connection to database
                mysqli_close($conn);
            ?>

            <p>
                <button type="button" onclick="window.location.href='index.html'">Return to Home</button>
                <button type="button" onclick="window.location.href='searchstatusform.html'">Search Again</button><br>
            </p>
        </div>
    </body>
</html>