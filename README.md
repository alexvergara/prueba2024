# prueba2024

Technical challenge - Backend Dev
This project is a simple system for managing user registrations and money transfers. It allows for two types of users: regular users and merchants. Both types of users need to provide their full name, identification document, email, and password. The identification document and email must be unique in the system, ensuring only one registration per document or email address.

## Requirements

- Docker
- Docker Compose

## Getting Started

1. Clone the repository:

    ```bash
    git clone https://github.com/alexvergara/prueba2024.git
    ```

2. Navigate to the project directory:

    ```bash
    cd prueba2024
    ```

3. Start the Docker containers:

    ```bash
    docker-compose up -d
    ```

This command will build and start the necessary Docker containers defined in the `docker-compose.yml` file. The `-d` flag runs the containers in detached mode.

## Accessing the Application

Once the containers are up and running, you can access the application in your web browser at: [](https://localhost:8080)

