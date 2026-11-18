<?php


// Configura APP_SMTP_HOST, APP_SMTP_PORT, APP_SMTP_USERNAME, APP_SMTP_PASSWORD,
// APP_SMTP_ENCRYPTION (tls o ssl), APP_SMTP_FROM_EMAIL y APP_SMTP_FROM_NAME
// en el entorno de ejecución de PHP, no en el control de versiones.

// Configuración de correo electrónico para la aplicación.
// se recomienda utilizar un correo electrónico de la empresa o compañía para enviar correos electrónicos desde la aplicación.
  
return [
    "host" => getenv("APP_SMTP_HOST") ?: "",
    "port" => (int)(getenv("APP_SMTP_PORT") ?: "587"),
    "username" => getenv("APP_SMTP_USERNAME") ?: "",
    "password" => getenv("APP_SMTP_PASSWORD") ?: "",
    "encryption" => strtolower(getenv("APP_SMTP_ENCRYPTION") ?: "tls"),
    "from_email" => getenv("APP_SMTP_FROM_EMAIL") ?: (getenv("APP_SMTP_USERNAME") ?: ""),
    "from_name" => getenv("APP_SMTP_FROM_NAME") ?: APP_NAME
];
