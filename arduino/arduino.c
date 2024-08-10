#include "USBSerial_main.h"

int incomingByte = 0; int pin = 13;

void setup() {
  Serial.begin(9600); //Starts the serial connection
  pinMode(pin, OUTPUT); //Sets pin 13 to be output
}

void loop() {
  if(Serial.available() > 0){
	Serial.read(); //Removes the message from the serial cache
	digitalWrite(pin, true); //Enables the led on pin #
	delay(100); //Waits 100 ms
	digitalWrite(pin, false); //Disables the led on pin #
  }
}