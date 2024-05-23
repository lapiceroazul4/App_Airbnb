import pandas as pd
import numpy as np
import mysql.connector
import random
import string
import time

# Leer el archivo CSV
df = pd.read_csv('new_york_listings_2024.csv')

# Eliminar columnas
df = df.drop(
    ["last_review", "reviews_per_month", "calculated_host_listings_count", "availability_365", "number_of_reviews_ltm", "license"],
    axis=1)

# Limpieza en columna "name"
df['name'] = df['name'].str.split(' · ').str[0]

# Delimitar a 50 filas
df = df[0:50]

print(df.head(10))

microusuarios = df[['host_id', 'host_name']]

microusuarios['role'] = 'Host'

# Función para generar contraseñas aleatorias
def generate_password():
    password_length = 8  # Longitud de la contraseña
    password_characters = string.ascii_letters + string.digits  # Caracteres permitidos en la contraseña
    return ''.join(random.choice(password_characters) for i in range(password_length))

# Generar la columna de contraseñas
microusuarios['password'] = [generate_password() for _ in range(len(df))]

microusuarios = microusuarios.rename(columns={'host_id': 'user_id', 'host_name': 'name'})

# Define la función para generar correos electrónicos aleatorios
def generate_random_email(num_emails):
    # Lista de nombres y dominios ficticios
    names = [
        "john", "emma", "alice", "peter", "sophia", "michael", "olivia", "daniel", "emily", "jack",
        "william", "ava", "james", "isabella", "benjamin", "mia", "alexander", "charlotte", "ethan", "amelia",
        "jacob", "harper", "matthew", "evelyn", "david", "abigail", "logan", "elizabeth", "joseph", "ella",
        "samuel", "sophie", "henry", "grace", "noah", "chloe", "owen", "lucy", "dylan", "victoria",
        "luke", "zoe", "andrew", "madison", "levi", "audrey", "nathan", "layla", "jack", "scarlett",
        "caleb", "riley", "mason", "claire", "ryan", "paisley", "jackson", "hannah", "gabriel", "eva",
        "isaac", "aria", "brayden", "julia", "anthony", "penelope", "julian", "madelyn", "wyatt", "aria",
        "christopher", "addison", "christian", "aubrey", "liam", "bella", "owen", "nora", "jonathan", "emilia",
        "sebastian", "mila", "aiden", "natalie", "jeremiah", "leah", "robert", "sarah", "carter", "samantha",
        "ezra", "lydia", "charles", "alexandra", "thomas", "aubree", "hunter", "avery", "henry", "ella",
        "colton", "grace", "elijah", "brooklyn", "landon", "lillian", "brandon", "anna", "adam", "savannah"
    ]
    domains = ["gmail.com", "hotmail.com", "outlook.com", "yahoo.com", "uao.com", "airbnb.com"]

    # Generar correos electrónicos aleatorios
    emails = []
    for _ in range(num_emails):
        # Generar nombre aleatorio
        name = random.choice(names)

        # Generar dominio aleatorio
        domain = random.choice(domains)

        # Generar una cadena aleatoria para el identificador del correo
        identifier = ''.join(random.choices(string.ascii_lowercase + string.digits, k=2))

        # Concatenar nombre, identificador y dominio para crear la dirección de correo electrónico
        email = f"{name}_{identifier}@{domain}"
        emails.append(email)

    return email


# Número de correos electrónicos que deseas generar por fila
num_emails_por_fila = 1

# Agregar una nueva columna llamada "email" con correos electrónicos aleatorios
microusuarios["email"] = microusuarios.apply(lambda x: generate_random_email(num_emails_por_fila), axis=1)

microusuarios = microusuarios.drop_duplicates(subset=['user_id'])

print(microusuarios.head(5))

# Credenciales de la base de datos
database = 'airbnb_app'
user = 'root'
password = 'password'
host = 'db'

# Establecer la conexión
for _ in range(5):
    try:
        conexion = mysql.connector.connect(
            host=host,
            database=database,
            user=user,
            password=password
        )
        print("La conexión con la DB ha sido exitosa:\n", conexion)
        break
    except mysql.connector.Error as err:
        print(f"Error al conectar a MySQL: {err}")
        time.sleep(4)  # Espera 5 segundos antes de intentar de nuevo
else:
    print("No se pudo establecer la conexión después de 5 intentos.")
    sys.exit(1)

print("La conexión con la DB ha sido exitosa:\n", conexion)

cursor = conexion.cursor()

# Consultas SQL
consulta_airbnbs = """INSERT INTO micro_airbnbs (id, name, host_id, host_name, neighbourhood_group, neighbourhood, latitude, longitude, room_type, price, minimum_nights, number_of_reviews, rating, rooms, beds, bathrooms)
              VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
              
consulta_usuarios = """INSERT INTO micro_users (user_id, name, role, password, email)
              VALUES (%s, %s, %s, %s, %s)"""

# Insertar los datos en la tabla
for fila in df.values:
    valores = (fila[0], fila[1], fila[2], fila[3], fila[4], fila[5], fila[6], fila[7], fila[8], fila[9], fila[10], fila[11], fila[12], fila[13], fila[14], fila[15])
    cursor.execute(consulta_airbnbs, valores)
    
# Insertar los datos en la tabla
for fila in microusuarios.values:
    valores = (fila[0], fila[1], fila[2], fila[3], fila[4])
    cursor.execute(consulta_usuarios, valores)
    
# Confirmar los cambios
conexion.commit()

cursor.close()
conexion.close()
