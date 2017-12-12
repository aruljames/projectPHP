<?php
/** Environment Setup **/

define ('ENV','local');
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
define ('HTTP_PROTOCOL',$protocol);