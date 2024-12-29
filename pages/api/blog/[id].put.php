<?php
  header("Content-Type: application/json");

  echo json_encode([
    'action' => 'Updating Blog',
    'id' => $_GET['id']
  ]);