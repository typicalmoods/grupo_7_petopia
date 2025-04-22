# Python base image
FROM python:3.12

# Set the working directory
WORKDIR /app

# Copy the application files
COPY src/. /app/

# Install dependencies
RUN pip install --no-cache-dir -r requirements.txt

# Command to run the application
CMD ["python", "app.py"]
