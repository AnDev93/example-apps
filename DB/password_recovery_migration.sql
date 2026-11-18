-- Run against an existing crud_apps database to enable password recovery.
ALTER TABLE `usuario`
  MODIFY `usuario_password` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `usuario_id` int NOT NULL,
  `token_hash` char(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `password_reset_token_hash` (`token_hash`),
  CONSTRAINT `password_reset_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
