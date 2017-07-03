      #!/usr/bin/python

import MySQLdb
import time
import I2C_LCD_driver
import RPi.GPIO as GPIO
from time import *
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BOARD)
GPIO.setup(7, GPIO.OUT)
GPIO.setup(37, GPIO.OUT)
GPIO.setup(33, GPIO.OUT)

def insertBD(tag):
     
      mylcd = I2C_LCD_driver.lcd()
      
      # Open database connection
      db = MySQLdb.connect("localhost","root","12345","teste")

      # prepare a cursor object using cursor() method
      cursor = db.cursor()

      # Prepare SQL query to INSERT a record into the database.
      sql = "SELECT * FROM Funcionario WHERE tag =%s" % (tag)
      # Execute the SQL command
      if cursor.execute(sql) == 0:
         GPIO.output(7,True)
         mylcd.lcd_display_string("Error!",1)
         mylcd.lcd_display_string("Cartao invalido", 2)
         return;
      else:
             sleep(.2)
             GPIO.output(33,False)
      
      # Fetch all the rows in a list of lists.
      results = cursor.fetchall()
      for row in results:
            f_id = row[0]
            f_nome = row[1]
      f_aNome=f_nome.split();
      #print "%d" %  (f_id)
      #dataHoje = time.strftime("%Y-%m-%d")
      #print dataHoje

      sql1 = "select * from registo where Funcionario_id=%d and data=CURDATE()" % (f_id)
      nr_rows=cursor.execute(sql1)
      if nr_rows == 0:
         #print "lala"
         sql2 = "insert into registo(Funcionario_id, data, entrada) values (%d, CURDATE(), CURTIME())" % (f_id)
         cursor.execute(sql2)
         db.commit()
         GPIO.output(7,False)
         GPIO.output(37,True)
         
         mylcd.lcd_display_string("Registo Entrada.",1)
         mylcd.lcd_display_string("%s %s" %(f_aNome[0],f_aNome[-1]), 2)
      else:
         #print "lalala2"
         results = cursor.fetchall()
         biggestId=0
         for row in results:
            if row[0] > biggestId:
               biggestId=row[0]
             
         sql3 = "select * from registo where id = %d" % (biggestId)
         cursor.execute(sql3)
         results = cursor.fetchall()
         for row in results:
            aux3 = str(row[3])
            aux2= str(row[2])
            #print "aux3->%s<-" % (aux3)
            #print " id =%d row2 =%s, row 3= %s" % (biggestId,row[2],row[3])
            if 'None' in aux3 and 'None' not in aux2:
               #print "dentro primeiro if"
               rid=row[0]
               sql4 = "update registo set saida = CURTIME() where id=%d" % (rid)
               cursor.execute(sql4)
               db.commit()
               GPIO.output(7,False)
               GPIO.output(37,True)
               mylcd.lcd_display_string("Registo Saida.",1)
               mylcd.lcd_display_string("%s %s" %(f_aNome[0],f_aNome[-1]), 2)
               break
            elif "None" not in aux3 and "None" not in aux2:
               #print "segundo if"
               sql5="insert into registo (Funcionario_id, data, entrada) values (%d,CURDATE(),CURTIME())" % (f_id)
               cursor.execute(sql5)
               db.commit()
               GPIO.output(7,False)
               GPIO.output(37,True)
               mylcd.lcd_display_string("Registo Entrada.",1)
               mylcd.lcd_display_string("%s %s" % (f_aNome[0],f_aNome[-1]), 2)
               break
            
      # disconnect from server
      db.close()
      return;
