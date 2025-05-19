
until pg_isready -h db -p 5432 -U postgres; do
  echo "Esperando o banco..."
  sleep 2
done

php console.php orm:schema-tool:create

php -S 0.0.0.0:8080 -t public/
