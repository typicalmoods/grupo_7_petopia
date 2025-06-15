import os
import pandas as pd
import sqlalchemy as sql

if __name__ == "__main__":
    # Database connection details
    db_connection_string = os.getenv("DB_CONNECTION_STRING")

    # Create a SQLAlchemy engine
    engine = sql.create_engine(db_connection_string)

    # List of CSV files to import
    csv_files = [
        "products.csv"
    ]

    # Import each CSV file into the database
    for csv_file in csv_files:
        table_name = os.path.splitext(csv_file)[0]
        
        # Delete all rows from the table before inserting new data
        with engine.connect() as connection:
            connection.execute(sql.text(f"DELETE FROM {table_name}"))
            connection.commit()
            print(f"Deleted all rows from {table_name} table.")
        
        pd.read_csv(csv_file).to_sql(table_name, con=engine, if_exists='append', index=False)
        print(f"Imported {csv_file} into {table_name} table.")
