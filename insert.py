#!/usr/bin/python
import time
import serial
import json
import MySQLdb
puerto_serie=serial.Serial("/dev/ttyACM0",9600)

while 1:
  character=puerto_serie.readline().strip()
  MyJson= character
  db = MySQLdb.connect("localhost","usuario","clave","arduino")
  print(character)
  if character != '\n':
      try:
       data=json.loads(character)
       print (data)
       curs = db.cursor()
       curs.execute("INSERT INTO mq135(valor)values("+str(data['co2'])+")")
       db.commit()
      except ValueError:
        print (" error")
 
 

puerto_serie.close() # Nunca llega a ejecutarse al estar fuera del bucle while pero se incluye para ilustrar la secuencia correcta de manejo de un puerto serie en Python con PySerial
