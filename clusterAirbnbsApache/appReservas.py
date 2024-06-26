#C:/Users/TU_USER/AppData/Local/Programs/Python/Python311/python.exe -m pip instaLL pyspark
#from pyspark.ml.feature import VectorAssembler
#from pyspark.ml.regression import LinearRegression
from pyspark.sql import SparkSession
spark=SparkSession.builder.getOrCreate()
from pyspark.sql.functions import month, year, to_date
#from pyspark.ml.evaluation import RegressionEvaluator

#Creación del RDD
df = spark.read.options(header='True', inferSchema='True').csv('/home/vagrant/clusterAirbnbsApache/reservations.csv')
rdd=df.rdd

#Para calcular el total de dinero que se generan por las reservas
reservas=rdd.map(lambda x: x[-1])
totalDinero=reservas.reduce(lambda a,b:a+b)

#Para calcular el total de reservas que se generan
total_reservas_generadas = rdd.count()

#Para calcular las reservas por tipo de habitación
tipoHabitacion=rdd.map(lambda x: (x[3], 1))
totalTipoHabitacion=tipoHabitacion.reduceByKey(lambda a,b:a+b)

#Para calcular el total de reservas por cada distrito
distritoAirbnb=rdd.map(lambda x: (x[2], 1))
totalDistritoAirbnb=distritoAirbnb.reduceByKey(lambda a,b:a+b)

#Para calcular los clientes con más reservas
clienteID=rdd.map(lambda x: (x[5], 1))
cantidadClientes=clienteID.reduceByKey(lambda a,b: a+b)
clientesOrganizados=cantidadClientes.sortBy(lambda x:x[1], ascending=False)
clientesDestacados=clientesOrganizados.take(3)
rdd_clientesDestacados = spark.sparkContext.parallelize(clientesDestacados)

#Para calcular los host con más airbnbs
hostID=rdd.map(lambda x: (x[4], 1))
cantidadHosts=hostID.reduceByKey(lambda a,b: a+b)
hostOrganizados=cantidadHosts.sortBy(lambda x:x[1], ascending=False)
hostsDestacados=hostOrganizados.take(3)
rdd_hostsDestacados = spark.sparkContext.parallelize(hostsDestacados)

#Para calcular que mes es el más demandado

df_fechas = df.withColumn("reservation_date", to_date(df.reservation_date, 'dd/MM/yyyy'))
df_fechas = df_fechas.withColumn("Mes", month(df_fechas.reservation_date))
reservas_por_mes = df_fechas.groupBy("Mes").count()
reservas_por_mes = reservas_por_mes.orderBy("Mes")

#---------------------------------------------------------

#Sección de resultados:

# Convertir RDDs a DataFrames
df_totalDinero = spark.createDataFrame([(totalDinero,)], ["Total de dinero generado"])
df_total_reservas_generadas = spark.createDataFrame([(total_reservas_generadas,)], ["Total Reservas Generadas"])
df_totalTipoHabitacion = totalTipoHabitacion.toDF(["Tipo Habitacion", "Total"])
df_totalDistritoAirbnb = totalDistritoAirbnb.toDF(["Distrito", "Total"])
df_clientesDestacados = rdd_clientesDestacados.toDF(["Cliente ID", "Cantidad de reservas generadas"])
df_hostsDestacados = rdd_hostsDestacados.toDF(["Host ID", "Cantidad de Airbnbs"])

# Imprimir DataFrames
print("Total Dinero:")
df_totalDinero.show()
print("Total Reservas Generadas:")
df_total_reservas_generadas.show()
print("Total por Tipo de Habitacion:")
df_totalTipoHabitacion.show()
print("Total por Distrito:")
df_totalDistritoAirbnb.show()
print("Clientes Destacados:")
df_clientesDestacados.show()
print("Hosts Destacados:")
df_hostsDestacados.show()
print("Reservas por Mes:")
reservas_por_mes.show()

#---------------------------------------------------------

#Para guardar los csv con los resultados (ASEGURARSE DE QUE CUMPLE CON LA RUTA DESEADA):
df_totalDinero.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/totalDinero')
df_total_reservas_generadas.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/totalReservasGeneradas')
df_totalTipoHabitacion.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/reservasTipoHabitacion')
df_totalDistritoAirbnb.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/reservasDistritoAirbnb')
df_clientesDestacados.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/clientesDestacados')
df_hostsDestacados.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/hostsDestacados')
reservas_por_mes.write.mode("overwrite").csv('/home/vagrant/clusterAirbnb/reservasPorMes')
#Cuando ya estén escritos los csv entonces moverlos a la carpeta compartida para el dashboard