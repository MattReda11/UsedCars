<!-- Header -->
<?php
include('templates/header-logged-out.php');
?>

<?php
session_start();

$error = "";
$username = $password = "";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    $query = "SELECT * FROM `users` WHERE username='" . $username . "' and password='" . md5($password) . "';";

    $result = mysqli_query($con, $query);

    $count = mysqli_num_rows($result);

    if ((isset($_POST['submit'])) && $count == 0) {
        $error = "Username/Password invalid.";
    }
    if ((isset($_POST['submit'])) && $count > 0) {
        $row = mysqli_fetch_assoc($result);

        //! broken for now: if you replace this header location with a working page, it works, for either usertype (tested with both kinds of users) Problem may be with session or the admin page itself, unsure
        if ($row['usertype'] == "admin") {
            header("Location: admin.php");
        } else if ($row['usertype'] == "user") {
            header('Location: registration.php');
        }
    }
    // ----------- STORE INFORMATION IN AN ARRAY -----------

    /*
    if ($num_row == 1){

        if ($row['usertype'] == 'admin') {
            
            $_SESSION['user_id'] = $user_id;
            header("Location: admin.php");
        } else if ($row['usertype'] == 'user') {
    
            
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
        }
    } else {

        $error = "Username/Password invalid.";
    }
    */
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UsedCars | Log In</title>
</head>

<div class="form container text-center">
    <h1>Used Cars Portal</h1>
    <h2>Log In</h2>
    <br>
    <!-- FORM -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="login">
        <!-- User Inputs -->
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <span class="error"><?php echo $error ?></span>
        <input name="submit" type="submit" value="Login" />
    </form>
    <br>
    <p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>

<!-- Footer -->
<?php include "templates/footer.php" ?>