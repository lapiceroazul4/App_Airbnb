from pyspark.sql import SparkSession

# Inicializar Spark
spark = SparkSession.builder.getOrCreate()

print("todo fue bien!")
