#include <ESP8266WiFi.h>
#include <DNSServer.h>
#include <ESP8266WebServer.h>
#include "WiFiManager.h"
#include <SoftwareSerial.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>
#include <FS.h>
#include <EEPROM.h>

#define RESET_COUNT_ADDRESS 0
#define TIMEFRAME 5000

/** 
  Blink Code :
    1. 1 Times => Device Reseted
    2. 
**/

int digitalPins[] = { D0, D1, D2, D3, D4, D5, D6, D7, D8 };

// const char* apiEndpoint = "http://192.168.1.6:8000/api/getTable";
const char* SerialNumber = "A1B2C3D4E5F6";
const char* APName = "LALAIoT-A1B2C3D4E5F6";

unsigned long interval = 10000;  // 10 Sec
unsigned long previousMillis = 0;

unsigned long previousMillisWarning = 0;
const long intervalWarning = 180000;  // Setiap 3 Menit


char recordOwnerID[7] = "";
char apiEndpoint[254] = "";

void configModeCallback(WiFiManager* myWiFiManager) {
  Serial.println("Entered config mode");
  Serial.println(WiFi.softAPIP());
  //if you used auto generated SSID, print it
  Serial.println(myWiFiManager->getConfigPortalSSID());
}

void setup() {
  Serial.begin(9600);

  // Initialize the LED pin as an output
  pinMode(D0, OUTPUT);
  pinMode(D1, OUTPUT);
  pinMode(D2, OUTPUT);
  pinMode(D3, OUTPUT);
  pinMode(D4, OUTPUT);
  pinMode(D5, OUTPUT);
  pinMode(D6, OUTPUT);
  pinMode(D7, OUTPUT);
  pinMode(D8, OUTPUT);

  EEPROM.begin(512);
  WiFiManager wifiManager;

  if (!SPIFFS.begin()) {
    Serial.println("Failed to mount file system");
    return;
  }
  loadConfig();

  WiFiManagerParameter custom_recordOwnerID("RecordOwnerID", "Enter Record Owner ID", recordOwnerID, 7);
  WiFiManagerParameter custom_apiEndpoint("APIEndpoint", "API URL, ex: http://api.aissystem.org/api", apiEndpoint, 254);

  wifiManager.addParameter(&custom_recordOwnerID);
  wifiManager.addParameter(&custom_apiEndpoint);

  wifiManager.setAPCallback(configModeCallback);

  if (!wifiManager.autoConnect(APName)) {
    Serial.println("failed to connect and hit timeout");
    //reset and try again, or maybe put it to deep sleep
    ESP.reset();
    delay(1000);
  }

  strncpy(recordOwnerID, custom_recordOwnerID.getValue(), sizeof(recordOwnerID));
  strncpy(apiEndpoint, custom_apiEndpoint.getValue(), sizeof(apiEndpoint));

  Serial.println("WIFIManager connected!");
  // Print loaded configuration
  Serial.println("Loaded configuration:");
  Serial.print("RecordOwnerID: ");
  Serial.println(recordOwnerID);
  Serial.print("APIEndpoint: ");
  Serial.println(apiEndpoint);

  saveConfig(recordOwnerID, apiEndpoint);

  // strcpy(recordOwnerID, wifiManager.getParameter("RecordOwnerID")->getValue());

  // if (strlen(recordOwnerID) == 0) {
  //   Serial.println("RecordOwnerID is blank, restarting NodeMCU...");
  //   ESP.restart();  // Restart if RecordOwnerID is blank
  // } else {
  //   Serial.println("RecordOwnerID: " + String(recordOwnerID));  // Print the value if it's valid
  // }


  Serial.println("WiFi connected!");


  Serial.print("IP --> ");
  Serial.println(WiFi.localIP());
  Serial.print("GW --> ");
  Serial.println(WiFi.gatewayIP());
  Serial.print("SM --> ");
  Serial.println(WiFi.subnetMask());

  Serial.print("DNS 1 --> ");
  Serial.println(WiFi.dnsIP(0));

  Serial.print("DNS 2 --> ");
  Serial.println(WiFi.dnsIP(1));

}

void loop() {
  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;
    if (WiFi.status() == WL_CONNECTED) {
      if(recordOwnerID == ""){
        digitalWrite(digitalPins[0], HIGH);
        delay(500);
        digitalWrite(digitalPins[0], LOW);
        delay(500);
        digitalWrite(digitalPins[0], HIGH);
        delay(500);
        digitalWrite(digitalPins[0], LOW);
        delay(500);
        Serial.println("Record Owner ID is Blank");
      }
      else if(apiEndpoint == ""){
        digitalWrite(digitalPins[0], HIGH);
        delay(500);
        digitalWrite(digitalPins[0], LOW);
        delay(500);
        digitalWrite(digitalPins[0], HIGH);
        delay(500);
        digitalWrite(digitalPins[0], LOW);
        delay(500);
        digitalWrite(digitalPins[0], HIGH);
        delay(500);
        digitalWrite(digitalPins[0], LOW);
        delay(2000);
        digitalWrite(digitalPins[0], HIGH);
        delay(2000);
        digitalWrite(digitalPins[0], LOW);
        delay(2000);
        Serial.println("API Endpoint is Blank");
      }
      else{
        checkCommand();
        hitApi();
      }
    } else {
      Serial.println("WiFi not connected");
    }
  }

  // digitalWrite(D0, HIGH);
  // digitalWrite(D1, HIGH);
  // digitalWrite(D2, HIGH);
  // digitalWrite(D3, HIGH);
  // digitalWrite(D4, HIGH);
  // digitalWrite(D5, HIGH);
  // digitalWrite(D6, HIGH);
  // digitalWrite(D7, HIGH);
  // digitalWrite(D8, HIGH);
  // delay(500);

  // digitalWrite(D0, LOW);
  // digitalWrite(D1, LOW);
  // digitalWrite(D2, LOW);
  // digitalWrite(D3, LOW);
  // digitalWrite(D4, LOW);
  // digitalWrite(D5, LOW);
  // digitalWrite(D6, LOW);
  // digitalWrite(D7, LOW);
  // digitalWrite(D8, LOW);
  // delay(500);
}

void checkCommand(){
  unsigned long currentMillisWarning = millis();

  WiFiClient client;
  HTTPClient http;
  WiFiManager wifiManager;

  http.begin(client, String(apiEndpoint) + "/getTable");
  http.addHeader("Content-Type", "application/json");
  String payload = String("{\"RecordOwnerID\":\"") + recordOwnerID + "\",\"SerialNumber\":\"" + SerialNumber + "\"}";
  int httpResponseCode = http.POST(payload);

  if (httpResponseCode > 0) {
    Serial.print("HTTP Response Code: ");
    Serial.println(httpResponseCode);

    // Get the response payload
    String response = http.getString();
    Serial.println("Response:");
    Serial.println(response);
    http.end();

    DynamicJsonDocument doc(1024);
    DeserializationError error = deserializeJson(doc, response);

    if (error) {
      Serial.print("Failed to parse JSON: ");
      Serial.println(error.f_str());
      return;
    }

    bool success = doc["success"];
    int command = doc["Command"];

    if(success){
      digitalWrite(digitalPins[0], HIGH);
      switch (command) {
        case 1 :
          ESP.restart();
          Serial.println("Table Status OFF");
          break;
        case 2 :
          wifiManager.resetSettings();
          WiFi.disconnect(true);
          ESP.restart();
          Serial.println("Table Status OFF");
          break;
      }

      http.begin(client, String(apiEndpoint) + "/checkCommand");
      http.addHeader("Content-Type", "application/json");
      String payload = String("{\"RecordOwnerID\":\"") + recordOwnerID + "\",\"SerialNumber\":\"" + SerialNumber + "\"}";
      int httpResponseCode = http.POST(payload);
      if (httpResponseCode > 0) {
        Serial.print("HTTP Response Code: ");
        Serial.println(httpResponseCode);

        // Get the response payload
        String response = http.getString();
        Serial.println("Response:");
        Serial.println(response);
      }

      http.end();

      digitalWrite(digitalPins[0], LOW);
    }
  }
}

void hitApi() {
  unsigned long currentMillisWarning = millis();

  WiFiClient client;
  HTTPClient http;

  // Begin connection to the API
  http.begin(client, String(apiEndpoint) + "/getTable");

  // Set headers and content type
  http.addHeader("Content-Type", "application/json");

  // Prepare JSON payload
  String payload = String("{\"RecordOwnerID\":\"") + recordOwnerID + "\",\"SerialNumber\":\"" + SerialNumber + "\"}";

  // Send HTTP POST request
  int httpResponseCode = http.POST(payload);

  // Check HTTP response code
  if (httpResponseCode > 0) {
    Serial.print("HTTP Response Code: ");
    Serial.println(httpResponseCode);

    // Get the response payload
    String response = http.getString();
    Serial.println("Response:");
    Serial.println(response);

    DynamicJsonDocument doc(1024);
    DeserializationError error = deserializeJson(doc, response);

    if (error) {
      Serial.print("Failed to parse JSON: ");
      Serial.println(error.f_str());
      return;
    }

    JsonArray data = doc["data"].as<JsonArray>();

    for (JsonObject obj : data) {
      int id = obj["id"];
      int status = obj["Status"];

      Serial.print("id: ");
      Serial.print(id);
      Serial.print(", Status: ");
      Serial.println(status);

      switch (status) {
        case 0:
          digitalWrite(digitalPins[id - 1], LOW);
          Serial.println("Table Status OFF");
          break;
        case 1:
          digitalWrite(digitalPins[id - 1], HIGH);
          Serial.println("Table Status ON");
          break;
        case 2:
          if (currentMillisWarning - previousMillisWarning >= intervalWarning) {
            previousMillisWarning = currentMillisWarning;
            digitalWrite(digitalPins[id - 1], LOW);
            delay(1000);
            digitalWrite(digitalPins[id - 1], HIGH);
            delay(1000);
            digitalWrite(digitalPins[id - 1], LOW);
            delay(1000);
            digitalWrite(digitalPins[id - 1], HIGH);
            delay(1000);
            digitalWrite(digitalPins[id - 1], LOW);
            delay(1000);
            digitalWrite(digitalPins[id - 1], HIGH);
            delay(1000);
            digitalWrite(digitalPins[id - 1], LOW);
            delay(1000);
            digitalWrite(digitalPins[id - 1], HIGH);
            Serial.println("Table Status WARNING");
          }
          else{
            Serial.println("Waiting WARNING");
          }
          break;
        case -1:
          digitalWrite(digitalPins[id - 1], LOW);
          Serial.println("Table Status CHECKOUT");
          break;
        case 3:
          digitalWrite(digitalPins[id - 1], HIGH);
          delay(3000);
          digitalWrite(digitalPins[id - 1], LOW);
          Serial.println("Table Status TEST DEVICE CONNECTION");
          break;
      }
    }


    // while(Serial.available()){
    //   inputString = response;
    //   node.print(inputString);
    // }

  } else {
    Serial.print("Error on sending POST: ");
    Serial.println(httpResponseCode);
  }

  // End the HTTP connection
  http.end();
}

void saveConfig(const char* A, const char* B) {
  File configFile = SPIFFS.open("/config.json", "w");
  if (configFile) {
    DynamicJsonDocument doc(1024);
    doc["RecordOwnerID"] = A;  // Save RecordOwnerID
    doc["APIEndpoint"] = B;     // Save APIEndpoint
    serializeJson(doc, configFile);
    configFile.close();
    Serial.println("Configuration saved to SPIFFS!");
    Serial.println(A);
  } else {
    Serial.println("Failed to open config file for writing.");
  }
}


void loadConfig() {
  Serial.println("Loading Config");
  File configFile = SPIFFS.open("/config.json", "r");
  if (configFile) {
    size_t size = configFile.size();
    if (size > 1024) {
      Serial.println("Config file size is too large.");
      return;
    }

    // Parse JSON from SPIFFS
    DynamicJsonDocument doc(1024);
    DeserializationError error = deserializeJson(doc, configFile);
    if (!error) {
      strncpy(recordOwnerID, doc["RecordOwnerID"] | "", sizeof(recordOwnerID));
      strncpy(apiEndpoint, doc["APIEndpoint"] | "", sizeof(apiEndpoint));
      Serial.println("Variable Configuration loaded:");
      Serial.print("Variable RecordOwnerID: ");
      Serial.println(recordOwnerID);
      Serial.print("Variable APIEndpoint: ");
      Serial.println(apiEndpoint);
    } else {
      Serial.println("Failed to parse config file.");
    }
    configFile.close();
  } else {
    Serial.println("No configuration file found.");
  }
}
