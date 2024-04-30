FROM python:3.9

WORKDIR /transferencia_df

COPY requirements.txt .
RUN pip install -r requirements.txt

COPY new_york_listings_2024.csv .
COPY transferencia_df.py .
CMD python transferencia_df.py