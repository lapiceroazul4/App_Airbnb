import pandas as pd
import mysql.connector

ruta_archivo = 'new_york_listings_2024.csv'

# Leer el archivo CSV
df = pd.read_csv(ruta_archivo, index_col=False)

# Delimitar a 50 filas
df = df[0:50]

print(df)

# Credenciales de la base de datos
host = "localhost"
database = "airbnb_app"
user = "root"
password = ""

# Establecer la conexión
conexion = mysql.connector.connect(
    host=host,
    database=database,
    user=user,
    password=password
)

cursor = conexion.cursor()

# Consulta SQL
consulta = """INSERT INTO micro_airbnbs (id, name, host_id, host_name, neighbourhood_group, neighbourhood, latitude, longitude, room_type, price, minimum_nights, number_of_reviews, rating, rooms, beds, bathrooms)
              VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""

# Insertar los datos en la tabla
for fila in df.values:
    valores = (fila[0], fila[1], fila[2], fila[3], fila[4], fila[5], fila[6], fila[7], fila[8], fila[9], fila[10], fila[11], fila[12], fila[13], fila[14], fila[15])
    cursor.execute(consulta, valores)
    
# Confirmar los cambios
conexion.commit()

cursor.close()
conexion.close()