<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Web Push PHP Configuration
| -------------------------------------------------------------------
| 
|  publickey         string   Your server public key generate from VAPID::createVapidKeys().
|  privatekey        string   Your server private key generate from VAPID::createVapidKeys().
|  contact           string   Admin mail address.
|
| -------------------------------------------------------------------
*/

$config['webpush']['publickey'] = 'BCNDqS4xwBk7Cu0WjfLuhHg2PvZw71KtLjRgKxJ_z_lu9ABijprRZVc-PoVJa75h3QLs-aTAVBfRbSRS9ckuUp0';
$config['webpush']['privatekey'] = 'ev7ID1sy1ZjnrjFbn-9pPjhPQkIqYAJY1bRT9m24pWc';
$config['webpush']['contact'] = 'admin@webpush.com';

?>