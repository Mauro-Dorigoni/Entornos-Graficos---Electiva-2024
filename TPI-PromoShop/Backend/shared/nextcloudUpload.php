<?php
require_once __DIR__ . '/nextcloud.config.php';

function uploadToNextcloud(string $localPath, string $remoteName): string
{
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => NEXTCLOUD_WEBDAV_URL . rawurlencode($remoteName),
        CURLOPT_USERPWD => NEXTCLOUD_USER . ':' . NEXTCLOUD_PASS,
        CURLOPT_PUT => true,
        CURLOPT_INFILE => fopen($localPath, 'r'),
        CURLOPT_INFILESIZE => filesize($localPath),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_CUSTOMREQUEST => 'PUT'
    ]);

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($status !== 201 && $status !== 204) {
        throw new Exception("Error subiendo a Nextcloud. HTTP $status: $response");
    }

    return $remoteName;
}
?>