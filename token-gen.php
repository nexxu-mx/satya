<?php
    session_start();
    $user_id = $_SESSION['idUser'];
    $timestamp = floor(time() / 3600);
    $token = hash_hmac('sha256', $user_id . $timestamp, '887319b0c6904b38b20d3b1dd2f147f44b4bec85119e1ab6e6db226eac56e8a1');
?>
