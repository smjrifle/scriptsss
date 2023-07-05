#include <RTClib.h>


#include <Wire.h>

/*
An open-source binary clock for Arduino. 
Based on the code from by Rob Faludi (http://www.faludi.com)
Code under (cc) by Daniel Spillere Andrade, www.danielandrade.net
http://creativecommons.org/license/cc-gpl
*/

RTC_DS1307 rtc;
int second, minute, hour;
int munit,hunit;

void setup() {
  
  for (int i=1; i <= 13; i++) {
    pinMode(i, OUTPUT);
  }

  Wire.begin();
  rtc.begin();
  
  DateTime now = rtc.now();
  second = now.second();
  minute = now.minute();
  hour = now.hour();
}

void loop() {

static unsigned long lastTick = 0; // set up a local variable to hold the last time we moved forward one second
// (static variables are initialized once and keep their values between function calls)
// move forward one second every 1000 milliseconds

if (millis() - lastTick >= 1000) {
lastTick = millis();
second++;
}

// move forward one minute every 60 seconds
if (second >= 60) {
minute++;
second = 0; // reset seconds to zero
}

// move forward one hour every 60 minutes
if (minute >=60) {
hour++;
minute = 0; // reset minutes to zero
}

if (hour >=24) {
hour=0;
minute = 0; // reset minutes to zero
}

munit = minute%10; //sets the variable munit and hunit for the unit digits
hunit = hour%10;

// minute units
// LED 1 binary 1
if(munit == 1 || munit == 3 || munit == 5 || munit == 7 || munit == 9) {
   digitalWrite(1, HIGH);
} else {
   digitalWrite(1,LOW);
}

// LED 2 binary 2
if(munit == 2 || munit == 3 || munit == 6 || munit == 7) {
   digitalWrite(2, HIGH);
} else {
   digitalWrite(2,LOW);
}

//LED 3 binary 4
if(munit == 4 || munit == 5 || munit == 6 || munit == 7) {
   digitalWrite(3, HIGH);
} else {
   digitalWrite(3,LOW);
}

//LED 4 binary 8
if(munit == 8 || munit == 9) {
   digitalWrite(4, HIGH);
} else {
   digitalWrite(4,LOW);
}

//minutes tens
if((minute >= 10 && minute < 20) || (minute >= 30 && minute < 40) || (minute >= 50 && minute < 60)) {
   digitalWrite(5, HIGH);
} else {
   digitalWrite(5,LOW);
}

if(minute >= 20 && minute < 40) {
   digitalWrite(6, HIGH);
} else {
   digitalWrite(6,LOW);
}

if(minute >= 40 && minute < 60) {
   digitalWrite(7, HIGH);
} else {
   digitalWrite(7,LOW);
}

//hour units
if(hunit == 1 || hunit == 3 || hunit == 5 || hunit == 7 || hunit == 9) {
   digitalWrite(8, HIGH);
} else {
   digitalWrite(8,LOW);
}

if(hunit == 2 || hunit == 3 || hunit == 6 || hunit == 7) {
   digitalWrite(9, HIGH);
} else {
   digitalWrite(9,LOW);
}

if(hunit == 4 || hunit == 5 || hunit == 6 || hunit == 7) {
   digitalWrite(10, HIGH);
} else {
   digitalWrite(10,LOW);
}

if(hunit == 8 || hunit == 9) {
   digitalWrite(11, HIGH);
} else {
   digitalWrite(11,LOW);
}

//hour
if(hour >= 10 && hour < 20) {
   digitalWrite(12, HIGH);
} else {
   digitalWrite(12,LOW);
}

if(hour >= 20 && hour < 24) {
   digitalWrite(13, HIGH);
} else {
   digitalWrite(13,LOW);
}
}
