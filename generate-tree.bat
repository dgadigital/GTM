@echo off
echo ============================================
echo  Generating project file tree...
echo  (excluding ignored folders and cache dirs)
echo ============================================

tree /F /A | findstr /V /I ^
/C:"wp\wp-content\themes\storefront-child\node_modules" ^
/C:"wp\wp-content\uploads" ^
/C:"wp\wp-content\plugins" ^
/C:"wp\wp-content\themes\storefront" ^
/C:"\dist" ^
/C:"\build" ^
/C:"\.cache" ^
/C:"\.sass-cache" ^
/C:"db_data" ^
/C:"wp_data" ^
/C:".vscode" ^
/C:".idea" ^
/C:".DS_Store" ^
/C:"Thumbs.db" ^
/C:"desktop.ini" > files.txt

echo.
echo ✅ Done! File list generated: files.txt
pause
