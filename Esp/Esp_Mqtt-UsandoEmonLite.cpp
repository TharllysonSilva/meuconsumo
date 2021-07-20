#include <Arduino.h>
#include <PubSubClient.h> //Importa a Biblioteca PubSubClient
#include <ESP8266WiFi.h> //Importa a Biblioteca ESP8266WiFi
#include "EmonLiteESP.h"

// -----------------------------------------------------------------------------
// Configuration
// -----------------------------------------------------------------------------

// Aanalog GPIO on the ESP8266
#define CURRENT_PIN             0

// If you are using a nude ESP8266 board it will be 1.0V, if using a NodeMCU there
// is a voltage divider in place, so use 3.3V instead.
#define REFERENCE_VOLTAGE       3.3

// Precision of the ADC measure in bits. Arduinos and ESP8266 use 10bits ADCs, but the
// ADS1115 is a 16bits ADC
#define ADC_BITS                10

// This is basically the volts per amper ratio of your current measurement sensor.
// If your sensor has a voltage output it will be written in the sensor enclosure,
// something like "30V 1A", otherwise it will depend on the burden resistor you are
// using.
#define CURRENT_RATIO           50

// This version of the library only calculate aparent power, so it asumes a fixes
// mains voltage
#define MAINS_VOLTAGE           227

// Number of samples each time you measure
#define SAMPLES_X_MEASUREMENT   1024

// Time between readings, this is not specific of the library but on this sketch
#define MEASUREMENT_INTERVAL    10000

//defines de id mqtt e tópicos para publicação e subscribe
//#define TOPICO_SUBSCRIBE ""     //tópico MQTT de escuta
#define TOPICO "sensor01"     //tópico MQTT de envio de informações para o broker
#define ID_MQTT "MeuConsumo"  //id mqtt (para identificação de sessão)

// -----------------------------------------------------------------------------
// Globals
// -----------------------------------------------------------------------------

EmonLiteESP power;

//Configuração Wifi
const char* SSID = "Santa Rosa";
const char* PASSWORD = "sdt193757";

//Configuração MQTT
const char* BROKER_MQTT = "10.0.0.15"; //Endereço do broker MQTT que se deseja utilizar
int BROKER_PORT = 1883; //Porta do Broker MQTT

//Variáveis e objetos globais
WiFiClient wifiClient; //Cria o obejeto wifiClient
PubSubClient client(wifiClient); //Instancia o cliente MQTT passando o objeto wifiClient

//Prototypes
void initSerial();
void initWiFi();
void initMQTT();
void reconectWiFi();
void calculaPotencia();
void VerificaConexoesWiFIEMQTT();
void powerMonitorSetup();

// -----------------------------------------------------------------------------
// Energy Monitor
// -----------------------------------------------------------------------------

unsigned int currentCallback() {
    // If usingthe ADC GPIO in the ESP8266
    return analogRead(CURRENT_PIN);

}

void powerMonitorSetup() {
    power.initCurrent(currentCallback, ADC_BITS, REFERENCE_VOLTAGE, CURRENT_RATIO);
}

/*
 *  Implementações das funções
 */
void setup()
{
    //inicializações:
    //InitOutput();
    //pinMode(analogPin, INPUT);
    Serial.begin(115200);
    initWiFi();
    initMQTT();
    powerMonitorSetup();

    //emon1.current(analogPin, 50);

}

//Função: inicializa e conecta-se na rede WI-FI desejada
//Parâmetros: nenhum
//Retorno: nenhum
void initWiFi()
{
    delay(10);
    Serial.println("------Conexao WI-FI------");
    Serial.print("Conectando-se na rede: ");
    Serial.println(SSID);
    Serial.println("Aguarde");

    reconectWiFi();
}

//Função: inicializa parâmetros de conexão MQTT(endereço do
//        broker, porta e seta função de callback)
//Parâmetros: nenhum
//Retorno: nenhum
void initMQTT()
{
    client.setServer(BROKER_MQTT, BROKER_PORT);   //informa qual broker e porta deve ser conectado
    //MQTT.setCallback(mqtt_callback);            //atribui função de callback (função chamada quando qualquer informação de um dos tópicos subescritos chega)
}

//Função: reconecta-se ao broker MQTT (caso ainda não esteja conectado ou em caso de a conexão cair)
//        em caso de sucesso na conexão ou reconexão, o subscribe dos tópicos é refeito.
//Parâmetros: nenhum
//Retorno: nenhum
void reconnectMQTT()
{
    while (!client.connected())
    {
        Serial.print("* Tentando se conectar ao Broker MQTT: ");
        Serial.println(BROKER_MQTT);
        if (client.connect(ID_MQTT))
        {
            Serial.println("Conectado com sucesso ao broker MQTT!");
            //client.subscribe(TOPICO);
        }
        else
        {
            Serial.println("Falha ao reconectar no broker.");
            Serial.println("Havera nova tentatica de conexao em 2s");
            delay(2000);
        }
    }
}

//Função: reconecta-se ao WiFi
//Parâmetros: nenhum
//Retorno: nenhum
void reconectWiFi()
{
    //se já está conectado a rede WI-FI, nada é feito.
    //Caso contrário, são efetuadas tentativas de conexão
    if (WiFi.status() == WL_CONNECTED)
        return;

    WiFi.begin(SSID, PASSWORD); // Conecta na rede WI-FI

    while (WiFi.status() != WL_CONNECTED)
    {
        delay(100);
        Serial.print(".");
    }

    Serial.println();
    Serial.print("Conectado com sucesso na rede ");
    Serial.print(SSID);
    Serial.println("IP obtido: ");
    Serial.println(WiFi.localIP());
}

//Função: verifica o estado das conexões WiFI e ao broker MQTT.
//        Em caso de desconexão (qualquer uma das duas), a conexão
//        é refeita.
//Parâmetros: nenhum
//Retorno: nenhum
void VerificaConexoesWiFIEMQTT()
{
    if (!client.connected())
        reconnectMQTT(); //se não há conexão com o Broker, a conexão é refeita

     reconectWiFi(); //se não há conexão com o WiFI, a conexão é refeita
}

//programa principal
void loop()
{
    //garante funcionamento das conexões WiFi e ao broker MQTT
    VerificaConexoesWiFIEMQTT();
    //keep-alive da comunicação com broker MQTT
    client.loop();

    static unsigned long last_check = 0;

    if ((millis() - last_check) > MEASUREMENT_INTERVAL) {

        double current = power.getCurrent(SAMPLES_X_MEASUREMENT);
        float potencia = 0;
        Serial.print(F("Current now: "));
        Serial.print(current);
        Serial.println(F("A"));
        Serial.print(F("Power now: "));
        potencia = int(current * MAINS_VOLTAGE);
        Serial.print(potencia);
        Serial.println(F("W"));

        client.publish(TOPICO, String(potencia).c_str());

        last_check = millis();

    }

}
