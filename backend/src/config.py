import os
from dotenv import load_dotenv

# Load environment variables from .env
load_dotenv()

class Config:
    APP_PORT = int(os.getenv("APP_PORT", 5000))
    ENCRYPT_SECRET_KEY = os.getenv("ENCRYPT_SECRET_KEY", "default_secret_key")
    DATABASE_URL = os.getenv("DATABASE_URL")
