<?php

// Set APP_SMTP_HOST, APP_SMTP_PORT, APP_SMTP_USERNAME, APP_SMTP_PASSWORD,
// APP_SMTP_ENCRYPTION (tls or ssl), APP_SMTP_FROM_EMAIL, and APP_SMTP_FROM_NAME
// in the PHP runtime environment, not in source control.
return [
    "host" => getenv("APP_SMTP_HOST") ?: "",
    "port" => (int)(getenv("APP_SMTP_PORT") ?: "587"),
    "username" => getenv("APP_SMTP_USERNAME") ?: "",
    "password" => getenv("APP_SMTP_PASSWORD") ?: "",
    "encryption" => strtolower(getenv("APP_SMTP_ENCRYPTION") ?: "tls"),
    "from_email" => getenv("APP_SMTP_FROM_EMAIL") ?: (getenv("APP_SMTP_USERNAME") ?: ""),
    "from_name" => getenv("APP_SMTP_FROM_NAME") ?: APP_NAME
];
