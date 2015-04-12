<?php

session_start();

class myViews {

//echo "session var is " . $_SESSION["myViewNo"] . "."; 
    //protected   $table = 'challenge';

    public function __construct() {
        parent::__construct();
    }

    function myViews1() {
        $servername = "localhost";
        $username = "mayuri";
        $password = "t5ChyWNECcQSfnYt";
        $dbname = "mayuri";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM hotTopics";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                echo '<p id="' . htmlspecialchars($row["Topic_Desc"]) . '" onclick="myFunction()" > ' . htmlspecialchars($row["Topic_Desc"]) . ' </p>';

                echo "<html>";
                echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">';
                echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">';
                echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>';
                echo "<body>";
                echo "<script>";
                echo "function myFunction() ";
                echo '{ document.getElementById("' . htmlspecialchars($row["Topic_Desc"]) . '").innerHTML = "' . htmlspecialchars($row["Topic_Desc"]) . ' clicked";}';
                // echo "  <FORM>";
                //   echo ' <form action="writePage.php">';
                //   echo ' <input type="text" name="mytext" value="'.$row["Topic_Desc"].'" />';
                //    echo '<input type="submit" value="submit"/>';
                //echo "</form>}";
                //echo '<INPUT TYPE="text" id="myText">}';
                //echo "</FORM> ";
                echo "</script>";
                echo "</body>";
                echo "</html>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
    }

}

if ($_SESSION["myViewNo"] == "myViews1") {
    if (isset($_GET['myViews1'])) {
        myViews:: myViews1();
    }
}
?>



