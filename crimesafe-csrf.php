<?php

function crimesafe_gen_csrf(string $scope): string
{
    if (!isset($_SESSION['csrf_key'])) {
        $_SESSION['csrf_key'] = random_bytes(32);
    }

    $prefix=random_bytes(32);
    $suffix=hash("sha384", $prefix . $_SESSION['csrf_key'], true);

    return base64_encode($prefix . $suffix);
}

function crimesafe_check_csrf(string $token, string $scope): bool
{
    $dec = base64_decode($token);
    $prefix = substr($dec, 0, 32);
    $suffix = substr($dec, 32);

    return (hash("sha384", $prefix . $_SESSION['csrf_key'], true) == $suffix);
}
