###############
FROM mysql:latest

# Set the environment variables
ENV MYSQL_DATABASE prueba2024
ENV MYSQL_ALLOW_EMPTY_PASSWORD yes
ENV MYSQL_USER user
ENV MYSQL_PASSWORD password

# Initialize the database

# Copy the database migrations
COPY database/migrations/* /docker-entrypoint-initdb.d/

# Copy the database seeds
COPY database/seeds/* /docker-entrypoint-initdb.d/

# Run any additional commands
COPY database/sqls/* /docker-entrypoint-initdb.d/
