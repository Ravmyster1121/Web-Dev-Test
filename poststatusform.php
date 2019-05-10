<!DOCTYPE html>

<html>
    <head>
        <title>Post Status Form</title>
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
            
            <h1>Status Posting System</h1>

            <form action="poststatusprocess.php" method="post">
                    <p>
                        <b>Status Code (required):</b><br>
                        <input type="text" name="statusCode" placeholder="S0000" required pattern="[S0-9]+" maxlength="5">
                    </p>

                    <p>
                        <b>Status  (required):</b><br>
                        <input type="text" name="status" placeholder="Enter Status" required pattern="[a-Z0-9,.!? ]+" maxlength="100"><br>
                    </p>

                    <p>
                        <b>Share:</b><br>
                        <input type="radio" name="shareType" value="Public" checked>Public<br>
                        <input type="radio" name="shareType" value="Friends Only" checked>Friends<br>
                        <input type="radio" name="shareType" value="Private" checked>Only Me<br>
                    </p>

                    <p>
                        <b>Date: </b><br>
                        <input type="date" value = "<?php echo date("Y-m-d"); ?>" name="date" required><br>
                    </p>

                    <p>
                        <b>Permission Type:</b><br> 
                        <input type="checkbox" name="permLike" value=1> Allow Like <br>
                        <input type="checkbox" name="permComment" value=1> Allow Comment <br>
                        <input type="checkbox" name="permShare" value=1> Allow Share <br>
                    </p>

                    <p>
                        <input type="submit" value="Submit">
                    </p>

                    <p>
                        <button type="button" onclick="window.location.href='index.html'">Return to Home</button>
                    </p>
            </form>
        </div>
    </body>
</html>