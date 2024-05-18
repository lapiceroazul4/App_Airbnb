# Usa una imagen base de Python
FROM python:3.8

RUN apt-get update
RUN apt-get install -y openjdk-17-jdk-headless

ENV JAVA_HOME=/usr/lib/jvm/java-17-openjdk-amd64

#RUN apt update
#RUN apt install -y default-jre
#RUN apt install -y default-jdk

#ENV JAVA_HOME=/usr/lib/jvm/java-11-openjdk-amd64

#ENV PATH=$JAVA_HOME/bin:$PATH

#RUN mkdir labSpark
#RUN wget https://downloads.apache.org/spark/spark-3.5.1/spark-3.5.1-bin-hadoop3.tgz
#RUN tar -xvzf spark-3.5.1-bin-hadoop3.tgz
#RUN mv spark-3.5.1-bin-hadoop3 labSpark/

# Navega al directorio de configuración de Spark
#WORKDIR /labSpark/spark-3.5.1-bin-hadoop3/conf

# Haz una copia del archivo de configuración de variables de entorno de Spark
#RUN cp spark-env.sh.template spark-env.sh

# Edita y agrega al final las configuraciones de SPARK_LOCAL_IP y SPARK_MASTER_HOST
#RUN echo 'SPARK_LOCAL_IP=192.168.100.3' >> spark-env.sh
#RUN echo 'SPARK_MASTER_HOST=192.168.100.3' >> spark-env.sh

# Navega a sbin
#WORKDIR /labSpark/spark-3.5.1-bin-hadoop3/sbin

# Inicia el master
# Nota: Esto no funcionará en un Dockerfile porque los contenedores Docker no deben contener procesos en segundo plano
#RUN ./start-master.sh
#RUN ./start-worker.sh spark://192.168.100.3:7077
#RUN cat labSpark/spark-3.5.1-bin-hadoop3/logs/spark-vagrant-org.apache.spark.deploy.worker.Worker-1-servidorUbuntu.out
# Establece un directorio de trabajo
WORKDIR /app

# Copia los archivos necesarios al contenedor
COPY . .

# Instala las dependencias
RUN pip install --no-cache-dir pyspark

# Ejecuta el script de Python
CMD ["python", "./app.py"]
