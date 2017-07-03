#!/usr/bin/env python
# -*- coding: utf8 -*-

import RPi.GPIO as GPIO
import MFRC522
import signal
import webbrowser
import time
import I2C_LCD_driver
from time import *
from readBd import insertBD
from datetime import datetime
GPIO.setwarnings(False)
GPIO.setup(7, GPIO.OUT)
GPIO.setup(37, GPIO.OUT)
GPIO.setup(33, GPIO.OUT)

continue_reading = True
mylcd = I2C_LCD_driver.lcd()

 
# Capture SIGINT for cleanup when the script is aborted
def end_read(signal,frame):
    global continue_reading
    print "Ctrl+C captured, ending read."
    continue_reading = False
    GPIO.cleanup()

# Hook the SIGINT
signal.signal(signal.SIGINT, end_read)

# Create an object of the class MFRC522
MIFAREReader = MFRC522.MFRC522()

# Welcome message
print "Welcome to the MFRC522 data read example"
print "Press Ctrl-C to stop."

# This loop keeps checking for chips. If one is near it will get the UID and authenticate
while continue_reading:

    #GPIO.setup(7, GPIO.OUT)
    GPIO.output(7,True)
    GPIO.output(37,False)
    GPIO.output(33,False)
    cur_time=datetime.now().strftime('%H:%M:%S')
    mylcd.lcd_display_string("Insira cartao...", 1)
    mylcd.lcd_display_string("Hora: %s" %cur_time, 2)
    
    # Scan for cards    
    (status,TagType) = MIFAREReader.MFRC522_Request(MIFAREReader.PICC_REQIDL)

    # If a card is found
    if status == MIFAREReader.MI_OK:
        print "Card detected"
    
    # Get the UID of the card
    (status,uid) = MIFAREReader.MFRC522_Anticoll()

    # If we have the UID, continue
    if status == MIFAREReader.MI_OK:

        # Print UID
        print "Card read UID: "+str(uid[0])+","+str(uid[1])+","+str(uid[2])+","+str(uid[3])
        varvar = str(uid[0])+str(uid[1])+str(uid[2])+str(uid[3])
        GPIO.output(7,False)
        GPIO.output(33,True)
        mylcd.lcd_clear()
        insertBD(varvar)
        sleep(3)
        GPIO.output(37,False)
        mylcd.lcd_clear()
        #new=2;
        #url="http://localhost/teste.php?var=%s" % varvar
        #webbrowser.open(url,new=new);
        
        
        # This is the default key for authentication
        #key = [0xFF,0xFF,0xFF,0xFF,0xFF,0xFF]
        
        # Select the scanned tag
        #MIFAREReader.MFRC522_SelectTag(uid)

        # Authenticate
        #status = MIFAREReader.MFRC522_Auth(MIFAREReader.PICC_AUTHENT1A, 8, key, uid)

        # Check if authenticated
        #if status == MIFAREReader.MI_OK:
         #   MIFAREReader.MFRC522_Read(8)
          #  MIFAREReader.MFRC522_StopCrypto1()
        #else:
            #print "Authentication error"

