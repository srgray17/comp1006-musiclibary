<?php
//auth check

session_start();
if (empty($_SESSION['userId'])){
    header("location:login.php");
        exit();
}

//are we adding or editing? if editing, get the selected artist to populate the form
//initialize variables for each field
$artistId = null;
$name= null;
$yearFounded =null;
$website = null;

//if an id parameter is passed in the url we are editing
if (!empty($_GET['artistId'])) {
    $artistId = $_GET['artistId'];


//connect
    $db = new PDO('mysql:host=172.31.22.43;dbname=Stella_R1121192', 'Stella_R1121192', '7s_DY1Cl8t');

//fetch the selected artist
    $sql = "SELECT * FROM artists WHERE artistId = :artistId";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':artistId', $artistId, PDO::PARAM_INT);
    $cmd->execute();

//use fetch without loop instead of fetchALL with a loop
    $artist = $cmd->fetch();
    $name = $artist['name'];
    $yearFounded = $artist['yearFounded'];
    $website = $artist['website'];

//disconnect
    $db = null;
}

?>

<?php
require_once('header.php');
?>
<h1>Artist Details</h1>
<form action="save-artist.php" method="post">
    <fieldset>
        <label for="name" class="col-sm-2">Name: *</label>
        <input name="name" id="name" required value="<?php echo $name; ?>"/>
    </fieldset>
    <fieldset>
        <label for="yearFounded" class="col-sm-2">Year Founded: </label>
        <input name="yearFounded" id="yearFounded" type="number" min="1000" max="<?php echo date("Y")?>" value="<?php echo $yearFounded; ?>">
    </fieldset>
    <fieldset>
        <label for="website" class="col-sm-2">Web Site: </label>
        <input name="website" id="website" type="url" value="<?php echo $website; ?>">
    </fieldset>
    <input name="artistId" id="artistId" value="<?php echo $artistId; ?>" type="hidden">
    <button class="btn btn-primary offset-sm-2">Save</button>
</form>
</body>
</html>

