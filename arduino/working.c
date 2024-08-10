int input;
int BryanPassword = 190376;
int NicolePassword = 384626;
String msg ="Please type your password";
String msgBryan ="Welcome Bryan. The door is now open";
String msgNicole ="Welcome Nicole. The door is now open";
String msgClosed ="Closed";

void setup() {
  Serial.begin(9600);
  pinMode(13,OUTPUT);
}
void loop() {
  Serial.println(msg);
  while(Serial.available()==0){
    input=Serial.parseInt();
    if (input == BryanPassword){
      digitalWrite(13,HIGH);
      Serial.print(msgBryan);
      delay(500);
      digitalWrite(13,LOW);
      delay(10000);
     }
    if (input == NicolePassword){
      digitalWrite(13,HIGH);
      Serial.print(msgNicole);
      delay(500);
      digitalWrite(13,LOW);
      delay(10000);
     }
    else{
      digitalWrite(13,HIGH);
      Serial.print(msgClosed);
      delay(500);
      digitalWrite(13,LOW);
    }
    delay(1000);
  }
}