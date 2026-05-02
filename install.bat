@echo off
REM Script d'installation de la base de données MySQL pour l'hôpital
REM Assurez-vous que XAMPP est lancé avec MySQL

echo.
echo ====================================
echo Installation Base de Donnees Hopital
echo ====================================
echo.

REM Définir les paramètres MySQL
set MYSQL_USER=root
set MYSQL_PASSWORD=
set MYSQL_HOST=localhost

REM Chemin vers mysql.exe (à adapter selon votre installation XAMPP)
set MYSQL_PATH="C:\xampp1\mysql\bin\mysql.exe"

REM Vérifier que mysql.exe existe
if not exist %MYSQL_PATH% (
    echo ERREUR: mysql.exe non trouvé à %MYSQL_PATH%
    echo Vérifiez votre installation XAMPP
    pause
    exit /b 1
)

echo Execution du script SQL...
echo.

%MYSQL_PATH% -u %MYSQL_USER% -h %MYSQL_HOST% < hospital.sql

if errorlevel 1 (
    echo.
    echo ERREUR lors de l'execution du script SQL
    echo Vérifications:
    echo - MySQL est-il lancé dans XAMPP?
    echo - Le port MySQL est-il le 3306?
    echo - L'utilisateur root a-t-il un mot de passe vide?
    pause
    exit /b 1
)

echo.
echo ====================================
echo OK - Installation reussie!
echo ====================================
echo.
echo Identifiants de test:
echo - patient@test.com / 123456 (Patient)
echo - medecin@test.com / 123456 (Medecin)
echo - secretaire@test.com / 123456 (Secretaire)
echo.
echo Accedez a: http://localhost/web-hopital/public/index.php/login
echo.
pause
