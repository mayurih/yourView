<?php

session_start();

class writePage {

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

//                echo '<p id="' . htmlspecialchars($row["Topic_Desc"]) . '" onclick="myFunction()" > ' . htmlspecialchars($row["Topic_Desc"]) . ' </p>';
                echo '<a href="' . htmlspecialchars($row["Topic_Desc"]) . ' > ' . htmlspecialchars($row["Topic_Desc"]) . ' </a>';

//                echo "<html>";
//                echo "<body>";
                echo "<script>";
                echo "function myFunction() ";
                echo '{ document.getElementById("' . htmlspecialchars($row["Topic_Desc"]) . '").innerHTML = "YOU CLICKED ME!";';
                // echo "  <FORM>";
                echo ' <form action="writepage.php" method="post">';
                echo ' <input type="text" name="mytext" value="' . $row["Topic_Desc"] . '" />';
                echo '<input type="submit" value="submit"/>';
                echo "</form>}";
//echo '<INPUT TYPE="text" id="myText">}';
//echo "</FORM> ";
                echo "</script>";
//                echo "</body>";
//                echo "</html>";
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



