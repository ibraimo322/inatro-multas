@echo off
chcp 65001 >nul
echo ========================================================
echo       INATRO - Enviar alterações para o GitHub
echo ========================================================
echo.
cd /d "C:\Users\Zainabo Wague\Documents\Inatro"

git add -A
git status

set /p COMMIT_MSG="Mensagem do commit (Enter para usar padrão): "
if "%COMMIT_MSG%"=="" set COMMIT_MSG="deploy: configuracao do Railway (Dockerfile, entrypoint e ajustes)"

git commit -m "%COMMIT_MSG%"
echo.
echo A enviar para o GitHub...
git push origin main

echo.
echo ========================================================
echo   Concluído! O Railway iniciará o deploy automaticamente.
echo ========================================================
pause
