## Before getting started
First, start by cloning the repository using the following command:
`git clone https://github.com/lapiceroazul4/App_Airbnb.git`

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
   - `User: admin`
   - `Pass: admin`

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
   - `User: admin`
   - `Pass: admin`

## Data Processing Cluster

### Prerequisites

Ensure that the latest version of Spark is installed on your VM. The current version is 3.5.1, which can be downloaded from [this link](https://dlcdn.apache.org/spark/spark-3.5.1/spark-3.5.1-bin-hadoop3.tgz).

### Setup Instructions

1. **Log into your Ubuntu server.**
2. **Install required Python libraries using pip** `pip install -r requirements.txt` 
3. **Navigate to the directory of the cloned repository:**
   ```bash
   cd App_Airbnb/
4. **Move the clusterAirbnbsApache/ directory to your desired execution path (note: you must update the file path in the application where the CSV is read):
   ```bash
   sudo mv clusterAirbnbsApache/ /home/vagrant/
5. **Create a directory in /home/vagrant to store the results:**
   ```bash
   sudo mkdir clusterAirbnb
6. **Start the master node by navigating to the Spark sbin directory:**
    ```bash
    cd /home/vagrant/labSpark/spark-3.5.1-bin-hadoop3/sbin./start-master.sh
7. **Start a worker node in the same directory**
   ```bash
   ./start-worker.sh spark://192.168.100.3:7077
8. **Launch the application:**
   ```bash
   cd /home/vagrant/labSpark/spark-3.5.1-bin-hadoop3/bin./spark-submit --master spark://192.168.100.3:7077 --conf        ./spark.executor.memory=1g /home/vagrant/clusterAirbnbsApache/appReservas.py
9. **Move the clusterAirbnb/ directory to a shared folder:**
   ```bash
   mv clusterAirbnb/ /vagrant/ 
> NOTE: You can now perform various operations with the CSV files. In our case, we upload these CSVs to the cloud using the script.py located in the Power BI folder. We recommend starting the page as admin and exploring the dashboards created.

