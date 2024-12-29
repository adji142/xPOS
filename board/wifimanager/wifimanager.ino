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
#define TIMEFRAME 3000

int digitalPins[] = { D0, D1, D2, D3, D4, D5, D6, D7, D8 };

const char* apiEndpoint = "http://192.168.1.6:8000/api/getTable";
const char* SerialNumber = "A1B2C3D4E5F6";

unsigned long interval = 10000;  // 10 Sec
unsigned long previousMillis = 0;

unsigned long previousMillisWarning = 0;
const long intervalWarning = 180000;  // Setiap 3 Menit


char recordOwnerID[7];
WiFiManagerParameter custom_recordOwnerID("RecordOwnerID", "Enter Record Owner ID", "", 7);

WiFiManager wifiManager;

void configModeCallback(WiFiManager* myWiFiManager) {
  Serial.println("Entered config mode");
  Serial.println(WiFi.softAPIP());
  //if you used auto generated SSID, print it
  Serial.println(myWiFiManager->getConfigPortalSSID());
}

void setup() {
  Serial.begin(9600);

  EEPROM.begin(512);

  int resetCount = EEPROM.read(RESET_COUNT_ADDRESS);
  unsigned long lastResetTime = EEPROM.read(RESET_COUNT_ADDRESS + 1);

  if (millis() - lastResetTime < TIMEFRAME) {
    resetCount++; // Increment the reset count
  } else {
    resetCount = 1; // Reset the count if outside the timeframe
  }

  EEPROM.write(RESET_COUNT_ADDRESS, resetCount);
  EEPROM.write(RESET_COUNT_ADDRESS + 1, millis() & 0xFF);
  EEPROM.commit();

  String resetReason = ESP.getResetReason();
  Serial.println(resetReason);
  if (resetReason == "External System" || resetReason == "Power on") {
    // resetWiFiManager();
    ESP.restart();
  } else {
    Serial.println("NodeMCU reset due to another reason: " + resetReason);
  }

  if (resetCount >= 3) {
    Serial.println("3 short presses detected! Resetting WiFiManager...");
    EEPROM.write(RESET_COUNT_ADDRESS, 0); // Reset the counter
    EEPROM.commit();
    resetWiFiManager();
  } else {
    Serial.print("Reset count: ");
    Serial.println(resetCount);
    Serial.println("Waiting for more resets...");
  }

  delay(200);

  if (!SPIFFS.begin()) {
    Serial.println("Failed to mount file system");
    return;
  }
  loadConfig();

  wifiManager.addParameter(&custom_recordOwnerID);

  wifiManager.setAPCallback(configModeCallback);

  if (!wifiManager.autoConnect("TESTESP")) {
    Serial.println("failed to connect and hit timeout");
    //reset and try again, or maybe put it to deep sleep
    ESP.reset();
    delay(1000);
  }

  Serial.println("WIFIManager connected!");

  saveConfig();

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

  Serial.println("WiFi connected!");
  Serial.print("RecordOwnerID: ");
  Serial.println(recordOwnerID);

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

}

void loop() {
  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;
    if (WiFi.status() == WL_CONNECTED) {
      hitApi();
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

void hitApi() {
  unsigned long currentMillisWarning = millis();

  WiFiClient client;
  HTTPClient http;

  // Begin connection to the API
  http.begin(client, apiEndpoint);

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

void saveConfig() {
  File configFile = SPIFFS.open("/config.json", "w");
  if (configFile) {
    DynamicJsonDocument doc(1024);
    doc["RecordOwnerID"] = custom_recordOwnerID.getValue();
    serializeJson(doc, configFile);
    configFile.close();
    Serial.println("Configuration saved!");
  } else {
    Serial.println("Failed to open config file for writing.");
  }
}


void loadConfig() {
  File configFile = SPIFFS.open("/config.json", "r");
  if (configFile) {
    size_t size = configFile.size();
    if (size > 1024) {
      Serial.println("Config file size is too large.");
      return;
    }

    // Read and parse JSON
    DynamicJsonDocument doc(1024);
    DeserializationError error = deserializeJson(doc, configFile);
    if (!error) {
      strncpy(recordOwnerID, doc["RecordOwnerID"] | "", sizeof(recordOwnerID));
      Serial.println("Configuration loaded:");
      Serial.println("Configuration loaded:");
      Serial.println(recordOwnerID);
      // if (strlen(recordOwnerID) == 0) {
      //   Serial.println("RecordOwnerID is blank, restarting NodeMCU...");
      //   ESP.restart();  // Restart if RecordOwnerID is blank
      // } else {
      //   Serial.println("RecordOwnerID: " + String(recordOwnerID));  // Print the value if it's valid
      // }
    } else {
      Serial.println("Failed to parse config file.");
    }
    configFile.close();
  }
}

void resetWiFiManager() {
  Serial.println("Resetting WiFi settings...");
  WiFiManager wifiManager;
  wifiManager.resetSettings();  // Clear WiFi credentials

  digitalWrite(digitalPins[0], HIGH);
  delay(1000);
  digitalWrite(digitalPins[0], LOW);

  delay(1000);
  ESP.restart();  // Restart the ESP
}
