<?php
  session_start();

$_SESSION['id'] = 1;

  $conn = mysql_connect('localhost', 'root', '');
  if (!$conn) {
    die("Connection failed: " . mysql_error());
  }
  mysql_select_db('zcu_demo');

  $current_user = '[not logged in]';
  if (array_key_exists('id', $_SESSION)) {
    $result = mysql_query('SELECT username FROM user WHERE id=' . $_SESSION['id']);
    $row = mysql_fetch_array($result);
    $current_user = $row['username'];
  }
?>

<html>
  <body>
    <h3>ZCU WebApp Security Demo</h3>

<?php
echo '<h5>Logged as: ' . $current_user . '</h5><hr>';

if (!array_key_exists('action', $_REQUEST)) {
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
} elseif ('login' == $_REQUEST['action']) {
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
  mysql_close($conn);
?>


<?php
} elseif ('create' == $_REQUEST['action']) {
  echo 'yyyyyyyyyyyyy ' . $_REQUEST['notice'];
  mysql_query("INSERT INTO notice_board(author_id,notice) VALUES(1,'" . $_REQUEST['notice'] . "')");

  echo '<br> xxxxxxxxxxxxxxxxxxxxxxxxx';
?>
<?php
}
?>

  </body>
</html>

<?php
  mysql_close($conn);
?>