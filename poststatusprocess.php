<!DOCTYPE html>
<html>
    <head>
        <title>Post Status Process</title>
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>

    <body>
        <div class="container">

            <div class="topnav">
                <a href="index.html">Home</a>
                <a class="active" href="poststatusform.php">Post Status</a>
                <a href="searchstatusform.html">Search Status</a>
                <a id="about" href="about.html">About</a>
            </div>

            <h1>Post Status Process</h1>

            <?php
                //Getting connection settings and credentials to connect to database
                //LOGIN CREDENTIALS ARE ENTERED IN settings.php file
                require_once("settings.php"); 

                //Connect to database and display error message if connetion fails
                $conn = new mysqli($host, $user, $pswd, $dbnm);
                if($conn->connect_error){
                    die("Connection Failed" . $conn->connect_error);
                }

                //Upon Sucessfull Connection
                else{
                    //Create SQL Table
                    $maketable = "CREATE TABLE IF NOT EXISTS posts (
                        post_id VARCHAR(5) PRIMARY KEY NOT NULL,
                        post_text VARCHAR(100) NOT NULL,
                        share_type VARCHAR(40),
                        post_date DATE NOT NULL,
                        perm_like BOOLEAN DEFAULT 0,
                        perm_comment BOOLEAN DEFAULT 0,
                        perm_share BOOLEAN DEFAULT 0)";

                    //Creating table if it doesn't already exist (Will return true if table is already created)
                    if($conn->query($maketable) === TRUE) {
                        //Upon creating table successfully

                        //Assigning posted values to respective variables
                        $statusCode = $_POST["statusCode"];
                        $status = $_POST["status"];
                        $shareType = $_POST["shareType"];
                        $date = $_POST["date"];
                        $permLike = $_POST["permLike"];
                        $permComment = $_POST["permComment"];
                        $permShare = $_POST["permShare"];

                        //Setting permissions to 0 if they were unchecked and left as null
                        if($permLike != 1){
                            $permLike = 0;
                        }
                        if($permComment != 1){
                            $permComment = 0;
                        }
                        if($permShare != 1){
                            $permShare = 0;
                        }

                        //Checks if statusCode, status and date are set and not null
                        if((isset($statusCode)) && (isset($status)) && (isset($date))){

                            //Checks if first char is 'S', last 4 characters are numbers and the length is exactly 5
                            if(($statusCode[0] == 'S') && (preg_match("/[0-9]/", substr($statusCode, -4))) && (strlen($statusCode) == 5)){

                                //Writing query to insert row with all inputted data to table
                                $insertRow = "INSERT INTO posts (post_id, post_text, share_type, post_date, perm_like, perm_comment, perm_share)
                                VALUES('"
                                . $statusCode . "', '"
                                . $status . "', '"
                                . $shareType . "', '"
                                . $date . "', "
                                . $permLike . ", "
                                . $permComment . ", "
                                . $permShare .
                                ")";

                                if($conn->query($insertRow) === TRUE){
                                    echo "<p>New Record Created Successfully!</p>";
                                }
                                //Only reason the query to be rejected would be duplicated primary key
                                else{
                                    echo "<p class='error'>Status Code: " . $statusCode . " is already in use.<br>
                                        Status Codes must be unique. Please try again.</p>";
                                }
                                
                            }
                            //If the status code did not fit the format
                            else {
                                echo "<p class='error'>Problem Verifying the format of Status Code.
                                    Please make sure status code follows the format of S0000 and try again.</p>";
                            }
                        }
                        else{
                            echo "<p class='error'>One or more of the required fields were not entered.<br>
                                Please try again. </p>";
                        }
                    }
                    //If there was an error creating table
                    else{
                        echo "<p class='error'>Error creating table. Please try again</p>";
                    }
                }

                //Closing connection to database
                mysqli_close($conn);
            ?>

            <p>
                <button type="button" onclick="window.location.href='index.html'">Return to Home</button>
            </p>

        </div>
    </body>
</html>