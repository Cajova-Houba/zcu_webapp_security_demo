<?php

$filePath = './' . $_GET['file'];

if (file_exists($filePath)) {
  echo 'Content of file ' . $filePath . ':<br/>';
  echo file_get_contents($filePath);
} else {
  echo 'file "' . $filePath . '" not found';
}
