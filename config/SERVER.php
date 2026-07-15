<?php
	
	/*----------  Datos del servidor  ----------*/
	const SERVER="localhost";
	const DB="crud_app"; // nombre de base datos
	const USER="root"; // nombre del usuario mysql
	const PASS=""; //contrase#a del usuario mysql


	const SGBD="mysql:host=".SERVER.";dbname=".DB;


	/*----------  Datos de la encriptacion (No modificar) ----------*/
	const METHOD="AES-256-CBC"; //Cifrado de 256 bits con CBC// no modificar//
	const SECRET_KEY='APP2026'; // solo modificar // 
	const SECRET_IV='102791'; // 16 caracteres para AES-256-CBC// no modificar//