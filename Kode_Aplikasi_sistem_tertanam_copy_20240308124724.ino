#include <Arduino.h>
#include <WiFi.h>
#include "soc/soc.h"
#include "soc/rtc_cntl_reg.h"
#include "esp_camera.h"
#include <Wire.h>
#include <DHT.h>
#include <MySQL_Connection.h>
#include <MySQL_Cursor.h>
#include <ArduinoHttpClient.h>

const char* ssid = "Yaudah";
const char* password = "12345678";

String serverName = "192.168.137.1";
String serverPath = "/htdocs/upload_data.php";
const int serverPort = 80;
const int soilPin = 14;
#define RELAY_PIN1 15
#define RELAY_PIN2 13

WiFiClient client;
HttpClient httpClient = HttpClient(client, serverName, serverPort);

// CAMERA_MODEL_AI_THINKER
#define PWDN_GPIO_NUM     32
#define RESET_GPIO_NUM    -1
#define XCLK_GPIO_NUM      0
#define SIOD_GPIO_NUM     26
#define SIOC_GPIO_NUM     27

#define Y9_GPIO_NUM       35
#define Y8_GPIO_NUM       34
#define Y7_GPIO_NUM       39
#define Y6_GPIO_NUM       36
#define Y5_GPIO_NUM       21
#define Y4_GPIO_NUM       19
#define Y3_GPIO_NUM       18
#define Y2_GPIO_NUM        5
#define VSYNC_GPIO_NUM    25
#define HREF_GPIO_NUM     23
#define PCLK_GPIO_NUM     22


const int Interval = 30000;    // proses pengambilan photo interval 30 detik
unsigned long previousMillis = 0; 
String jsonres;

float temp;  // Declare temperature globally
float hum;
const int relay = 4;
String head;

// Sensor DHT
#define DHTPIN 2
#define DHTTYPE DHT22
DHT dht(DHTPIN, DHTTYPE);

void setup() {
  WRITE_PERI_REG(RTC_CNTL_BROWN_OUT_REG, 0); 
  Serial.begin(115200);

  WiFi.mode(WIFI_STA);
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);  
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(500);
  }
  Serial.println();
  Serial.print("ESP32-CAM IP Address: ");
  Serial.println(WiFi.localIP());

  camera_config_t config;
  config.ledc_channel = LEDC_CHANNEL_0;
  config.ledc_timer = LEDC_TIMER_0;
  config.pin_d0 = Y2_GPIO_NUM;
  config.pin_d1 = Y3_GPIO_NUM;
  config.pin_d2 = Y4_GPIO_NUM;
  config.pin_d3 = Y5_GPIO_NUM;
  config.pin_d4 = Y6_GPIO_NUM;
  config.pin_d5 = Y7_GPIO_NUM;
  config.pin_d6 = Y8_GPIO_NUM;
  config.pin_d7 = Y9_GPIO_NUM;
  config.pin_xclk = XCLK_GPIO_NUM;
  config.pin_pclk = PCLK_GPIO_NUM;
  config.pin_vsync = VSYNC_GPIO_NUM;
  config.pin_href = HREF_GPIO_NUM;
  config.pin_sscb_sda = SIOD_GPIO_NUM;
  config.pin_sscb_scl = SIOC_GPIO_NUM;
  config.pin_pwdn = PWDN_GPIO_NUM;
  config.pin_reset = RESET_GPIO_NUM;
  config.xclk_freq_hz = 20000000;
  config.pixel_format = PIXFORMAT_JPEG;

  // init with high specs to pre-allocate larger buffers
  if(psramFound()){
    config.frame_size = FRAMESIZE_VGA;
    config.jpeg_quality = 40;  //0-63 lower number means higher quality
    config.fb_count = 2;
  } else {
    config.frame_size = FRAMESIZE_VGA;
    config.jpeg_quality = 36;  //0-63 lower number means higher quality
    config.fb_count = 1;
  }
  
  // camera init
  esp_err_t err = esp_camera_init(&config);
  if (err != ESP_OK) {
    Serial.printf("Camera init failed with error 0x%x", err);
    delay(1000);
    ESP.restart();
  }

  sensor_t * s = esp_camera_sensor_get();
  s->set_framesize(s, FRAMESIZE_VGA);
  dht.begin();
  pinMode(RELAY_PIN1, OUTPUT);
  pinMode(RELAY_PIN2, OUTPUT);
  // digitalWrite(RELAY_PIN1, HIGH);
}

void loop() {
  unsigned long currentMillis = millis();

  if (currentMillis - previousMillis >= Interval) {
    Serial.println("Bersiap kirim foto dan data ke server..");
    uploadSensorData();
    previousMillis = currentMillis;
  }
}

void uploadSensorData() {
  camera_fb_t * fb = esp_camera_fb_get();
  
  float temperatureValue = dht.readTemperature();
  float humidityValue = dht.readHumidity();
  int soilValue = digitalRead(soilPin);
  
  Serial.print("Temp: ");
  Serial.print(temperatureValue);
  Serial.print(" Hum: ");
  Serial.println(humidityValue);

  if (soilValue == HIGH) {
    Serial.println("Tanah Kering");
  } else {
    Serial.println("Tanah Basah");
  }

  String url = "/htdocs/baca_data.php";

  // send the GET request
  Serial.println("making GET request");
  httpClient.get(url);

  // read the status code and body of the response
  int statusCode = httpClient.responseStatusCode();
  String response = httpClient.responseBody();
  Serial.print("Status code: ");
  Serial.println(statusCode);
  Serial.print("Response: ");
  Serial.println(response);

    // now parse the response looking for "content":
  int labelStart = response.indexOf("content\":");
  // find the first { after "content":
  int contentStart = response.indexOf("{", labelStart);
  // find the following } and get what's between the braces:
  int contentEnd = response.indexOf("}", labelStart);
  String content = response.substring(contentStart + 1, contentEnd);
  Serial.println(content);

  // now get the value after the colon, and convert to an int:
  int valueStart = content.indexOf(":");
  String valueString = content.substring(valueStart + 1);
  int number = valueString.toInt();
  Serial.print("Value string: ");
  Serial.println(valueString);
  Serial.print("Actual value: ");
  Serial.println(number);

  if (valueString == "nyala") {
    digitalWrite(RELAY_PIN2, HIGH);
  } else {
    digitalWrite(RELAY_PIN2, LOW);
  }

  if (soilValue == HIGH) {
    digitalWrite(RELAY_PIN1, HIGH);
    delay(7000);
    digitalWrite(RELAY_PIN1, LOW);
    delay(30000);
  } else {
    digitalWrite(RELAY_PIN1, LOW);
  }

  String soilData;

  if (soilValue == HIGH) {
    soilData = "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"tanah\"\r\n\r\n" + String("Tanah Kering");
  } else {
    soilData = "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"tanah\"\r\n\r\n" + String("Tanah Basah");
  }

  String relayData;

  if (digitalRead(RELAY_PIN2) == HIGH) {
      relayData = "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"pompa\"\r\n\r\n" + String("Pompa Nyala");
  } else {
      relayData = "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"pompa\"\r\n\r\n" + String("Pompa Mati");
  }
  
  String temperatureData = "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"suhu\"\r\n\r\n" + String(temperatureValue);
  String humidityData = "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"kelembaban\"\r\n\r\n" + String(humidityValue);
  String post_data = temperatureData + humidityData + relayData + soilData + "\r\n--dataMarker\r\nContent-Disposition: form-data; name=\"imageFile\"; filename=\"cekgambar.jpg\"\r\nContent-Type: image/jpeg\r\n\r\n";
  
  uint8_t *fbBuf = fb->buf;
  size_t fbLen = fb->len;
  
  for (size_t n = 0; n < fbLen; n = n + 1024) {
    if (n + 1024 < fbLen) {
      post_data.concat(reinterpret_cast<char*>(fbBuf), 1024);
      fbBuf += 1024;
    } else if (fbLen % 1024 > 0) {
      size_t remainder = fbLen % 1024;
      post_data.concat(reinterpret_cast<char*>(fbBuf), remainder);
    }
  }
  
  post_data += "\r\n--dataMarker--\r\n";
  
  esp_camera_fb_return(fb);
  
  if (client.connect(serverName.c_str(), serverPort)) {
    Serial.println("Connection successful!");
    uint32_t totalLen = post_data.length();
    client.print("POST " + serverPath + " HTTP/1.1\r\n");
    client.print("Host: " + serverName + "\r\n");
    client.print("Content-Length: " + String(totalLen) + "\r\n");
    client.print("Content-Type: multipart/form-data; boundary=dataMarker\r\n");
    client.print("\r\n");
    client.print(post_data);
  } else {
    Serial.println("Connection to " + serverName +  " failed.");
  }
  client.stop();
}







