import pandas as pd

df = pd.read_csv("CSV\\new_york_listings_2024.csv")

print(df.columns)

recuento_room_type = df['room_type'].value_counts()
print(recuento_room_type)