import pandas as pd
import random
from datetime import datetime, timedelta

# Load the CSV file to inspect its contents
file_path = 'Archivo/Transferencia/new_york_listings_2024.csv'
listings_df = pd.read_csv(file_path)

# Display the first few rows of the dataframe to understand its structure
#print(listings_df.head())


def generate_random_date():
    start_date = datetime(2000, 1, 1)
    end_date = datetime.now()

    time_between_dates = end_date - start_date
    days_between_dates = time_between_dates.days
    random_number_of_days = random.randrange(days_between_dates)

    random_date = start_date + timedelta(days=random_number_of_days)
    return random_date.strftime('%d/%m/%Y')

# Function to generate unique client data
def generate_unique_clients(num_clients):
    clients = []
    for i in range(num_clients):
        client_id = 100000 + i + 1
        client_name = f'Client_{i + 1}'
        clients.append((client_id, client_name))
    return clients

# Generate unique clients
unique_clients = generate_unique_clients(5000)  # Generate 5000 unique clients

# Function to generate multiple reservations per Airbnb with repeated clients
def generate_reservations_with_repeated_clients(listings, clients, num_reservations_per_listing):
    reservations = []
    num_listings = len(listings)
    
    for i in range(num_listings * num_reservations_per_listing):
        listing = listings.iloc[random.randint(0, num_listings - 1)]
        client = random.choice(clients)
        reservation = {
            'airbnb_id': listing['id'],
            'airbnb_name': listing['name'],
            'host_id': listing['host_id'],
            'client_id': client[0],
            'client_name': client[1],
            'reservation_date': generate_random_date()
        }
        reservations.append(reservation)
    
    return pd.DataFrame(reservations)

# Generate 5 reservations per listing for the new simulation with repeated clients
reservations_df_repeated_clients = generate_reservations_with_repeated_clients(listings_df, unique_clients, 5)

#reservations_df_multiple = generate_multiple_reservations(listings_df, 5)
#reservations_df = pd.DataFrame(reservations)

# Save reservations to a CSV file
output_file_path = 'Archivo/Transferencia/reservations.csv'
reservations_df_repeated_clients.to_csv(output_file_path, index=False)

# Display the first few rows of the reservations DataFrame
print(reservations_df_repeated_clients.head())
print(len(reservations_df_repeated_clients))