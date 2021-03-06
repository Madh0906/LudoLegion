<?php include('includes/server.php');?>
<?php include('includes/login_validation.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=320, initial-scale=1">

    <title>Ludo Society</title>
    <!--BootStrap assets hosted from CDN(Content Delivery Network for faster loading of pages) -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="resources/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="resources/jquery-3.5.1.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="resources/bootstrap.min.js"></script>

    <!--    Custom StyleSheet-->
    <link rel="stylesheet" type="text/css" href="resources/styles.css">
</head>

<body>

<?php include('includes/nav.php');?>

<script type="text/javascript">
        window.history.forward();

</script>

//If game is running
<?php
include ('includes/server.php');
$user=$_SESSION['user_name'];
$running="SELECT * from running WHERE player1='$user' or player2='$user'";
$res=mysqli_query($db,$running);
if(mysqli_num_rows($res)==1){
  header('location:room.php');
}
?>


<!--for auto refresh tables without reload page-->


<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#open_tab_auto").load("open_table.php");
            refresh();
        }, 1000);
    });
</script>


<script>
    $(document).ready(function() {
        setInterval(function() {
            $("#run_tab_auto").load("running_table.php");
            refresh();
        }, 1000);
    });
</script>


<script type="text/javascript">
        function post(phone) {
            var Row = document.getElementById(phone);
            var Cells = Row.getElementsByTagName("td");
            var player2 = (Cells[0].innerText);
            var betAmount = (Cells[1].innerText);
            var phone_no = (Cells[3].innerText);
            var room_id = (Cells[4].innerText);
            var ludo_id = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            var charactersLength = characters.length;
            for ( var i = 0; i < 6; i++ ) {
                  ludo_id += characters.charAt(Math.floor(Math.random() * charactersLength));
                  }
            $.post('home_ajax.php',{postplayer: player2, postphone: phone_no, postid:ludo_id, postamount:betAmount, postroomid:room_id},
                function(data)
                   {
                    
                        alert("Go play ludo and come back with this id="+ludo_id)
                        location.replace('room.php')
                    
                   });
        }
    </script>
    

<!--Script to avoid form resubmission-->
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


<br>
<br>
<br>
<div class="container">
    <h6><img style="width:10px;height:10px;" src="https://img.icons8.com/emoji/48/000000/green-circle-emoji.png" /> <?php echo $_SESSION['user_name'];?></h6>
</div>

<div class="container" style="padding-bottom: 75px; background: none;" class="ng-scope">

    <div class="row">
        <div class="col-6">
            <h2>Play Ludo</h2>
        </div>
        <div class="col-6 text-right">
            <a href="https://youtu.be/hoNb6HuNmU0" target="_blank" class="btn btn-sm btn-danger">How to play</a>
        </div>
    </div>

    <br>
    
     <?php  if (count($errors) > 0){ ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?php include ('includes/errors.php');?></strong>
        </div>
    <?php } ?>
    
 

    <div>
        <form method="post" action="home.php">
            <div >
                <input type="text" placeholder="Enter Ludoking room id" name="room_code" class="form-control"><br>
                <input type="number" placeholder="Enter Match Amount Here" name="amount" class="form-control">
                <span class="input-group-btn">
                    <button name="set" type="submit" class="btn btn-success btn-sm">Set
                        Game</button>
                </span>
            </div>
        </form>
    </div>



    <hr>

    <div class="row" style="background: #f5f5f5">
        <div class="col-6">
            <h5>Open Matches</h5>
        </div>
        <div class="col-6 text-right"><a href="https://m.me/veerapalli.naveenkumar" target="_blank" class="btn btn-sm btn-primary">Chat us</a></div>

    </div>
    <br>



      


    <!--    JQERY CDN-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>




    <div id="open_tab_auto">
<!--            OPEN MATCHES TABLE HERE-->
    </div>
    <br>

<?php
    
$count="SELECT COUNT(*) FROM running";
$r=mysqli_query($db,$count);
    
?>



    <div class="row" style="background: #f5f5f5">
        <div class="col-8 text-justify">
            <h5>Running Matches <span class="badge badge-success ng-binding"><?php while ($c=mysqli_fetch_assoc($r)) {
    echo $c['COUNT(*)'];
}?></span></h5>
        </div>
        
    </div>
    <hr>

    <div id="run_tab_auto">
<!--       RUNNING MATCHES TABLE HERE-->
        
    </div>
    <br>


    <?php include('includes/bottom_nav.php');?>