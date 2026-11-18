<?php

$localConfig = [];
$localConfigPath = __DIR__ . "/MAIL.local.php";
if(is_file($localConfigPath)){
    $configuredValues = require $localConfigPath;
    if(!is_array($configuredValues)){
        throw new RuntimeException("The local SMTP configuration must return an array.");
    }
    $localConfig = $configuredValues;
}

$getConfigValue = function($environmentName, $configKey, $default = "") use ($localConfig){
    $environmentValue = getenv($environmentName);
    if($environmentValue !== false && $environmentValue !== ""){
        return $environmentValue;
    }
    $localValue = $localConfig[$configKey] ?? "";
    return $localValue !== "" ? $localValue : $default;
};

$username = $getConfigValue("APP_SMTP_USERNAME", "username");

return [
    "host" => $getConfigValue("APP_SMTP_HOST", "host"),
    "port" => (int)$getConfigValue("APP_SMTP_PORT", "port", 587),
    "username" => $username,
    "password" => $getConfigValue("APP_SMTP_PASSWORD", "password"),
    "encryption" => strtolower($getConfigValue("APP_SMTP_ENCRYPTION", "encryption", "tls")),
    "from_email" => $getConfigValue("APP_SMTP_FROM_EMAIL", "from_email", $username),
    "from_name" => $getConfigValue("APP_SMTP_FROM_NAME", "from_name", APP_NAME)
];
