#include <avr/interrupt.h>
#include <avr/io.h>

#define NUMPOS 6
#define NUMNEG 3

int pos[NUMPOS] = {9,8,7,6,5,4};
int neg[NUMNEG] = {12,11,10};

int i = 0;
int j = 0;
int k = 0;
int lastpos = 0;
int lastneg = 0;

int isr_counter = 0;
int oldsecond = 0;
volatile int second = 0;
int seconds = 0;
int minutes = 31;
int hours = 13;

/*  
   Here's how I think this works.  The Atmega168 clock runs at 16MHz.  
   The "prescaler" divides that down.  In this case, it clicks at 2MHz.  
   Each time it clicks, it increments at 8 bit register by 1.  The register
   overflows after 256 clicks.  That overflow is the interrupt we receive.

   2000000 clicks/second divided by 256 clicks/overflow = 7812.5 overflows/second.
   So if I could count 7812.5 overflows, I know a second has elapsed.  I can't
   find .5 of an overflow, so I should really use the /4 prescaler.  But 
   a) that uses more power and b) I can't figure out what bits to set to do that.  
*/

ISR(TIMER2_OVF_vect) {
  isr_counter++;
  if (isr_counter > 7811) {
    second++;
    isr_counter = 0;
  }
};  

void SetupTimer2(){
  //Timer2 Settings: Timer Prescaler /8, mode 0
  //Timer clock = 16MHz/8 = 2Mhz or 0.5us
  //The /8 prescale gives us a good range to work with
  //so we just hard code this for now.
  TCCR2A = 0;
  TCCR2B = 0<<CS22 | 1<<CS21 | 0<<CS20;

  //Timer2 Overflow Interrupt Enable
  TIMSK2 = 1<<TOIE2;

  //load the timer
  TCNT2=0;
}

void setup() {
  for(i = 0; i<NUMPOS; i++) {
    pinMode(pos[i], OUTPUT);
  }
  for(i = 0; i<NUMNEG; i++) {
    pinMode(neg[i], OUTPUT);
  }

  for(i = 0; i<NUMPOS; i++) {
    digitalWrite(pos[i],LOW);
  }
  for(i = 0; i<NUMNEG; i++) {
    digitalWrite(neg[i],HIGH);
  }
  
  Serial.begin(9600);
  SetupTimer2();
}

void showXY(int col, int row) {
  digitalWrite(pos[lastpos],LOW);
  digitalWrite(neg[lastneg],HIGH);

  digitalWrite(pos[row],HIGH);
  digitalWrite(neg[col],LOW);
  
  lastpos = row;
  lastneg = col;
}

void loop() {
  // time changed, so readjust all the details
  if (oldsecond != second) {
    if (second > 59) {
      second = 0;
      minutes++;
      if (minutes > 59) {
        minutes = 0;
        hours++;
        if (hours > 23) {
         hours = 0;
        }
      }
    }          
    seconds = second;
    oldsecond = second;
  }

  // seconds is column 2 and has 6 bits
  k = 2;
  for(j=0; j<6; j++) {
    if (seconds >> j & 1) {
      showXY(k,j);
    }
  }

  // minutes is column 1 and has 6 bits
  k = 1;
  for(j=0; j<6; j++) {
    if (minutes >> j & 1) {
      showXY(k,j);
    }
  }

  // hours is column 0 and has 5 bits
  k = 0;
  for(j=0; j<5; j++) {
    if (hours >> j & 1) {
      showXY(k,j);
    }
  }

}

