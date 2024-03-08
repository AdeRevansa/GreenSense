import serial
import mysql.connector
import os
# Konfigurasi database

db_config = {
    "user": os.environ.get("root"),
    "password": os.environ.get(""),
    "host": os.environ.get("localhost"),
    "database": os.environ.get("greeniq"),
}

# Membuka koneksi serial dengan Arduino
ser = serial.Serial('COM3', 9600)  # Ganti 'COM3' dengan port serial Arduino Anda

# Membaca data dari Arduino dan menyimpannya ke database
try:
    conn = mysql.connector.connect(**db_config)
    cursor = conn.cursor()

    while True:
        data = ser.readline().decode().strip()
        cursor.execute(data)
        conn.commit()

except Exception as e:
    print("Error:", e)
finally:
    ser.close()
    cursor.close()
    conn.close()
