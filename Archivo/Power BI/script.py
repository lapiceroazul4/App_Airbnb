from google.cloud import bigquery
from google.oauth2 import service_account
import pandas as pd
import pandas_gbq
import logging
import os

#config python's logging module
logging.basicConfig(level=logging.INFO)

def create_bigquery_client(json_path):
    credentials = service_account.Credentials.from_service_account_file(json_path)
    client = bigquery.Client(credentials=credentials)
    return client

client = create_bigquery_client('airbnbs-423902-a634622ba128.json')


def merge_data(directory):
    """
    Merges the data from the csv files in a given directory.

    Args:
        directory (str): The directory where the csv files are located.

    Returns:
        pandas.DataFrame or None: A pandas DataFrame containing the merged data from the csv files,
        or None if an error occurs.
    """
    try:
        # Get a list of all csv files in the directory
        csv_files = [f for f in os.listdir(directory) if f.endswith('.csv')]

        # If there is only one csv file, read and return it
        if len(csv_files) == 1:
            return pd.read_csv(os.path.join(directory, csv_files[0]))

        # Load the data from the first csv file
        df = pd.read_csv(os.path.join(directory, csv_files[0]))

        # Load the data from the rest of the csv files
        for csv in csv_files[1:]:
            df2 = pd.read_csv(os.path.join(directory, csv))
            df = pd.concat([df, df2])

        return df
    except (FileNotFoundError, IndexError) as e:
        logging.error(f"Error: {e}")
        return None
    

def send_data_gcp(df, table_name):
    """
    Send dadta from DataFrame to BigQuery 

    Args:
        df (pandas.DataFrame): The DataFrame to be sent.
        table_name (str): The name of the BigQuery table.

    Returns:
        str: A success message if the data is uploaded successfully, None otherwise.
    """
    
    project_id = 'airbnbs-423902'
    dataset_id = 'airbnb_viz'
    
    full_table_id = f"{project_id}.{dataset_id}.{table_name}"
    
    try:
        # Write the DataFrame to a BigQuery table
        df.to_gbq(full_table_id, project_id=project_id, if_exists='replace')
        msj = "data uploaded successfully"
        return msj
    except Exception as e:
        logging.error(f"Error: {e}")
        return None


# Example usage
if __name__ == '__main__':
    list_directories = [
        'clientesDestacados', 'hostsDestacados',
        'reservasDistritoAirbnb', 'reservasPorMes',
        'reservasTipoHabitacion', 'totalDinero',
        'totalReservasGeneradas'
        ]
    for directory in list_directories:
        df = merge_data(directory)
        if df is not None:
            table_name = directory
            msj = send_data_gcp(df, table_name)
            if msj is not None:
                logging.info(msj)
            else:
                logging.error(f"Error sending data to BigQuery for {table_name}")
        else:
            logging.error(f"Error merging data for {directory}")