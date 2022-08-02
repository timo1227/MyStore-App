<?php

// load GCS library
if (file_exists('/app/vendor/autoload.php')) {
    require_once('/app/vendor/autoload.php');
} else {
    require_once(__DIR__ . '/../../../vendor/autoload.php');
}

use Google\Cloud\Storage\StorageClient;

// Please use your own private key (JSON file content) which was downloaded in step 3 and copy it here
// your private key JSON structure should be similar like dummy value below.
// WARNING: this is only for QUICK TESTING to verify whether private key is valid (working) or not.  
// NOTE: to create private key JSON file: https://console.cloud.google.com/apis/credentials  
$privateKeyFileContent = '{
  "type": "service_account",
  "project_id": "astral-host-357215",
  "private_key_id": "28e571ea49363b58524a367fc6f247a3055a3369",
  "private_key": "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDVeoQ1x6XD5/lB\nitqnO7s11jZrZrqwPmfUia1eDbPBlTn67atZU52dUWWNdTKsTW8SmYYEFOS6mfKu\neREGSGpQvdqJ4q9fQB88n6d95OhUuaS4IcmGAH5B8yIxNzZrN6y1HRWzpwyvgOLx\npd9mUbXmgOur56VRsaMy1a0ezFFHr8y5fngYhsyUgQYxZueCsCuVK5EdRGr/0rgb\n9VjaAZj+OzQyvnURIu/6vHEugqKrz1P/5bgXnVv/gD+nOROfiNMhgrS4P82ZdMuA\ncjAg5P0vRAOxUVuLAJnuxUtP3Hup2vEMjuKHWKb/gRNAbrNChzodmVy1MfcvISDV\nktEB4WgNAgMBAAECggEAK4X+hX5uR+o4EcpO+PB/IyNI1g3MOxmGDrmBHJ9bijiz\n6PpiyGP5SvUo6LW/voxM/HRLc/KUjYzMgxDQzUCfWFXUw+7xBVDr7W65dbvhOEDf\nGeFdllHsa+K3kmQo1qQztHs5DPceaXu0CUNhsBkxpkybf+FK/cRjOv6AfLp4Sc5o\n5Hu3BHFkb1ijdF33BlGLkL6HI4OzUV2CpcZl0P7+5k9GBzsEpeXwv6mIhrrJn3sZ\niPXARRQNjgHKbf/ldvlYnVgnQeLMnXY13E2i77GfafsAd0mSt/8jpRgAtBCN/t2B\n90STK31u13E211G2slU6ZI8Gn+mafU7ZkZ9qychWiwKBgQDxzfCDMKL9Nk10jztv\nhzCXxYUEeJyZmQIGamt8Tuo9noAWyIEDaIUU4NPqMjImqoLFXb5gdqqrBWHmuRsg\ni4NoE2SE/YTfBU9a6x7j2tgPs4GGkdUAluPTHvL46aQMtwNq2TRhjTM2r1cURyZX\n45SPum183gvppPbNPNaKPZwgTwKBgQDiAt6eReNkD3ut+GYW3e8RosIOHOTrwRki\n0zXko+gLYvwWhHpki6o2AGlBq8V0xGfjTstwcYz9cQj8WINfBBCdf5+Wgos3EsZf\npWGRNAoXCdkvKrtNxT3JJ4V+/ebGOzn8/nQLbqTODbLWZKu1VWOFO0hmPuSicwEq\nJ7RAE4Ce4wKBgH0jxG5QtHlxKgLBwdPFVkulqGKY/Qqs2hRx7PCncqizJ70ixUn7\nRKx6cpHIqpXCNu1nx4fqwgbCQVmDwNtF+JrbNnFxNtuoxtnZxuHLN3hgwQ7g2Ch2\n7q8rXDmfyQvfh0A76tT1m2SYt+tBq0FfAVqk89bkn6uqeSPccXeXzP4XAoGBALOg\nojxawXJKV/sZ3FG6TALRP7glwM+a5hZmlYPFvWwnXMGswvXchwhqZT2bftDiNMtV\nWZ1hsjPQPdsJokfHHEmBIF5oHKtF0cI82AGmwYoz+phhNwKFjCiur4wR0fOlKN5p\ngeOAKZ3XB1ccJdh2KCXAyzbwL5jpHHjbm4f9uBEPAoGAVMZvyzwQEAFjHugJmZBe\ntG1RinliBLjqKwTIAo4VPOHg05xWNEHhOTzPOtEpJIwVmYFLZ82owRkTCwO+0iHM\nZwINPT38tmxOAc17HFXztlZoU/buZY6dpqjYAOdHW1nP/DMAKOg1cJ2EakdM0ZZP\ndSh4KdMT/NyX2S7N+1oOTzw=\n-----END PRIVATE KEY-----\n",
  "client_email": "myshopservice@astral-host-357215.iam.gserviceaccount.com",
  "client_id": "112582401806172412042",
  "auth_uri": "https://accounts.google.com/o/oauth2/auth",
  "token_uri": "https://oauth2.googleapis.com/token",
  "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
  "client_x509_cert_url": "https://www.googleapis.com/robot/v1/metadata/x509/myshopservice%40astral-host-357215.iam.gserviceaccount.com"
    }';

/*
 * NOTE: if the server is a shared hosting by third party company then private key should not be stored as a file,
 * may be better to encrypt the private key value then store the 'encrypted private key' value as string in database,
 * so every time before use the private key we can get a user-input (from UI) to get password to decrypt it.
 */

function uploadFile($bucketName, $fileContent, $cloudPath)
{
    $privateKeyFileContent = $GLOBALS['privateKeyFileContent'];
    // connect to Google Cloud Storage using private key as authentication
    try {
        $storage = new StorageClient([
            'keyFile' => json_decode($privateKeyFileContent, true)
        ]);
    } catch (Exception $e) {
        // maybe invalid private key ?
        print $e;
        return false;
    }
    // set which bucket to work in
    $bucket = $storage->bucket($bucketName);

    // upload/replace file 
    $storageObject = $bucket->upload(
        $fileContent,
        ['name' => $cloudPath]
        // if $cloudPath is existed then will be overwrite without confirmation
        // NOTE: 
        // a. do not put prefix '/', '/' is a separate folder name  !!
        // b. private key MUST have 'storage.objects.delete' permission if want to replace file !
    );

    // is it succeed ?
    return $storageObject != null;
}

function getFileInfo($bucketName, $cloudPath)
{
    $privateKeyFileContent = $GLOBALS['privateKeyFileContent'];
    // connect to Google Cloud Storage using private key as authentication
    try {
        $storage = new StorageClient([
            'keyFile' => json_decode($privateKeyFileContent, true)
        ]);
    } catch (Exception $e) {
        // maybe invalid private key ?
        print $e;
        return false;
    }

    // set which bucket to work in
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object($cloudPath);
    return $object->info();
}
//this (listFiles) method not used in this example but you may use according to your need 
function listFiles($bucket, $directory = null)
{

    if ($directory == null) {
        // list all files
        $objects = $bucket->objects();
    } else {
        // list all files within a directory (sub-directory)
        $options = array('prefix' => $directory);
        $objects = $bucket->objects($options);
    }

    foreach ($objects as $object) {
        print $object->name() . PHP_EOL;
        // NOTE: if $object->name() ends with '/' then it is a 'folder'
    }
}
