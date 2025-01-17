<?php

  require_once('db_credentials.php');

  function db_connect() {
    mysqli_report(MYSQLI_REPORT_OFF);
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    confirm_db_connection();
    return $connection;

  }

  function db_disconnect($connection) {
    if(isset($connection)) {
      mysqli_close($connection);
    }
  }

  function db_escape($connection, $string) {
    return mysqli_real_escape_string($connection, $string);
  }

  function confirm_db_connection() {
    if(mysqli_connect_errno()) {
      $msg = "Database connection failed: ";
      $msg .= mysqli_connect_error();
      $msg .= " (" . mysqli_connect_errno() . ")";
      exit($msg);
    }
  }

  function confirm_result_set($result_set) {
    if(!$result_set) {
      exit("Database query failed.");
    }
  }

?>