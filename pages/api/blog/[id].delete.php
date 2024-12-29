<?php
  header("Content-Type: application/json");

  echo json_encode([
    'action' => 'Deleting Blog',
    'id' => $_GET['id']
  ]);