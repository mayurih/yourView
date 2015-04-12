<?php
echo "My first PHP script!";
session_start();

class myViews {

//echo "session var is " . $_SESSION["myViewNo"] . "."; 
    //protected   $table = 'challenge';

    public function __construct() {
        parent::__construct();
    }

    function myViews() {
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
        
        $variable = <<<XYZ

               <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../dist/css/timeline.css" rel="stylesheet">
        <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="../bower_components/morrisjs/morris.css" rel="stylesheet">
        <link href="../bower_components/fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        
  <h1></h1>
  <h1></h1>
  <h1></h1>
  <h1></h1> <br><br><br><br><br><br><br><br><br><br><br>
    </head>
    <body  background="logo.png">

        <!-- /.row -->
        <div class="panel-body"  style="float:right;width:70%;">
      
        
        <a href="articles.html" class="btn btn-primary btn-lg" role="button" style="width:250px;height:50px">Hot Topics</a><br><br>
        
       
         <a href="myViews_1.html" class="btn btn-primary btn-lg" role="button" style="width:250px;height:50px">Settings</a><br><br>
         
         <a href="myViews_1.html" class="btn btn-primary btn-lg" role="button" style="width:250px;height:50px">About</a>
       
         


          
</div>

   
     
    </body>
</html>

               XYZ;
echo $variable;
           
        $conn->close();
    }

}

if ($_SESSION["myViewNo"] == "myViews") {
    if (isset($_GET['myViews'])) {
        myViews:: myViews();
    }
}
?>



