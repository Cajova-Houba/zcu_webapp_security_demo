<?php

$filePath = './' . $_GET['file'];

if (file_exists($filePath)) {
  echo 'Content of file ' . $filePath . ':<br/>';
  echo '<pre>';
  echo file_get_contents($filePath);
  echo '</pre>';
} else {
  echo 'file "' . $filePath . '" not found';
}
