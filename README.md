# README.md

## 1. Check Docker Installation

It's essential to have Docker installed beforehand. We recommend using version 26.0.0. You can find more information about the installation process at the following link: [Docker Installation](https://docs.docker.com/engine/install/).

## 2. Local Deployment

> **Recommendation:** Execute the following commands with superuser permissions. You can do this by running `sudo -i` on Unix systems or by running the command prompt as an administrator on Windows.

### Using Docker Compose:

1. Navigate to the `Docker/Compose/` directory.
2. Execute the following command: `docker compose up -d --build`.
3. Verify that the services have been successfully deployed by running `docker ps`.
4. At this point, the services should be deployed, and you can test the application at the following URL:
    - http://localhost:5080
5. To log in, use the following credentials:
   
   `User: admin@admin.com`
   
   `Pass: Admin`
   
6. To check the HAProxy statistics, you can visit the following URL: `http://localhost:5080/haproxy?stats` using these credentials:
   - `User: Admin`
   - `Pass: Admin`

### Using Docker Swarm:

1. Navigate to the `Docker/Swarm/` directory.
2. Execute the following command to initialize the Swarm: `docker swarm init --advertise-addr localhost`.
3. Deploy by executing: `docker stack deploy -c docker-compose.yml App_Airbnb`.
4. Scale the web service by running: `docker service scale App_Airbnb_web1=3`. At this point, the web1 service will have 3 replicas; if you wish to change the number of replicas, simply replace the 3 with the desired value.
5. If you want to scale another service, the process is similar and can be done as follows: `docker service scale App_Airbnb_'service_name'='number_of_replicas'`.
6. To verify that the process was successful, you can execute: `docker service ls`, where you will see the name of the services, the number of replicas, and other additional information.
7. Similar to the execution with Docker Compose, you can also verify the functionality from the URL, using the same route:
   - http://localhost:5080
   
   To log in, use the following credentials:
   
   - `User: admin@admin.com`
   - `Pass: Admin`
8. To check the HAProxy statistics, you can visit the following URL: `http://localhost:5080/haproxy?stats` using these credentials:
   - `User: Admin`
   - `Pass: Admin`
