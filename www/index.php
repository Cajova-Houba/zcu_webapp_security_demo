<?php
  session_start();

  $conn = mysql_connect('localhost', 'root', '');
  if (!$conn) {
    die("Connection failed: " . mysql_error());
  }
  mysql_select_db('zcu_demo');

  $current_user_id = -1;
  $current_user = '[not logged in]';
  if (array_key_exists('id', $_SESSION)) {
    $current_user_id = $_SESSION['id'];
    $result = mysql_query('SELECT username FROM user WHERE id=' . $current_user_id);
    $row = mysql_fetch_array($result);
    $current_user = $row['username'];
  } else {
    unset($_REQUEST['action']); // no action means: go to login
  }
?>

<html>
  <body>
    <h3>ZCU WebApp Security Demo</h3>

<?php
echo '<h5>Logged as: ' . $current_user . '</h5><hr>';

// $_REQUEST['username'] = "'; DELETE FROM notice_board; --";
// $result = mysql_query("SELECT id,password FROM user WHERE username='" . $_REQUEST['username'] . "'");
// echo "SELECT id,password FROM user WHERE username='" . $_REQUEST['username'] . "'" . "<br>";
// $row = mysql_fetch_row($result);
// print_r($row);

// -------------------------- DISPLAY LOGIN FORM
if (!array_key_exists('action', $_GET) && !array_key_exists('action', $_POST)) {
?>
  <form method='post'>
    Username:<br>
    <input name='username' type='text'>
    <br>
    Password:<br>
    <input name='password' type='password'>
    <br>
    <input type='submit' value='Login'>
    <input type='hidden' name='action' value='login'>
  </form>


<?php
// -------------------------- PROCESS LOGIN
} elseif ('login' == $_POST['action']) {
  $result = mysql_query("SELECT id,password FROM user WHERE username='" . $_POST['username'] . "'" . " AND password='" . $_POST['password'] . "'");
  $row = mysql_fetch_row($result);
  if ($row) {
    $_SESSION['id'] = $row['id'];
    header("Location: index.php?action=list"); // redirect to list of notices
    exit;
  }
?>


<?php
// -------------------------- DISPLAY LIST OF NOTICES
} elseif ('create' == $_POST['action'] || 'list' == $_GET['action']) {
  if ('create' == $_POST['action']) {
    // ---------------------- CREATE NEW NOTICE
    mysql_query("INSERT INTO notice_board(author_id,notice) VALUES(" . $current_user_id . ",'" . $_POST['notice'] . "')");
  }
?>
  <form method='post'>
    Notice:<br>
    <input name='notice' type='text'>
    <input type='submit' value='Put'>
    <input type='hidden' name='action' value='create'>
  </form>
  <hr>
  <table border='1' width='70%' align='center'>
<?php
  $result = mysql_query('SELECT u.id,u.username,n.notice FROM notice_board AS n JOIN user AS u ON n.author_id=u.id');
  while($entry = mysql_fetch_row($result)) {
    echo '<tr><td>' . $entry[1] . ' [id=' . $entry[0] . ']</td><td>' . $entry[2] . '</td></tr>';
  }
?>
  </table>

<?php
}
?>

  </body>
</html>

<?php
  mysql_close($conn);
?>
