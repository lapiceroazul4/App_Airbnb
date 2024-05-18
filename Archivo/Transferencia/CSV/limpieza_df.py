import pandas as pd

# Leer el archivo CSV y convertirlo en un DataFrame
df = pd.read_csv("CSV\\old_new_york_listings_2024.csv")

df = df.drop(
    ["last_review", "reviews_per_month", "calculated_host_listings_count", "availability_365", "number_of_reviews_ltm", "license"],
    axis=1)

df['name'] = df['name'].str.split(' · ').str[0]

# Convertir el DataFrame a un archivo CSV
df.to_csv('CSV\\new_york_listings_2024.csv', index=False)