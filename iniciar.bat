@echo off
title INATRO -- Servidor de Desenvolvimento
color 0A
echo.
echo  ============================================
echo   INATRO -- Sistema de Multas de Transito
echo   CodeIgniter 4.7.4 + PHP 8.2.34 + SQLite3
echo  ============================================
echo.
echo  A iniciar servidor em http://localhost:8081/
echo  Prima Ctrl+C para parar.
echo.
"C:\php82\php.exe" spark serve --port 8081 --host localhost
