# Execute the SQL migrations to create the database schema.
for file in /var/www/html/database/migrations/*.sql; do
    mysql -h db -u user -ppassword prueba2024 < $file
done
