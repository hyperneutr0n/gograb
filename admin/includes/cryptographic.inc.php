<?php
function GenerateKey() {
    return random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
}

function DataEncrypt($message, $key)
{
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    $encrypted = sodium_crypto_secretbox($message, $nonce, $key);
    $enconded = base64_encode($nonce . $encrypted);
    return $enconded;
}

function DataDecrypt($message, $key)
{
    $decoded = base64_decode($message);
    $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
    $ciphertxt = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
    return sodium_crypto_secretbox_open($ciphertxt, $nonce, $key);
}

function PasswordHash($password)
{
    $hashed = sodium_crypto_pwhash_str(
        $password,
        SODIUM_CRYPTO_PWHASH_OPSLIMIT_SENSITIVE,
        SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
    );
    return $hashed;
}

function PasswordVerify($password, $hashed)
{
    $result = sodium_crypto_pwhash_str_verify($hashed, $password);
    return $result;
}
