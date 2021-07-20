#include <Arduino.h>
#include <PubSubClient.h> //Importa a Biblioteca PubSubClient
#include <ESP8266WiFi.h> //Importa a Biblioteca ESP8266WiFi
//#include "EmonLiteESP.h"
#include "EmonLib.h"

EnergyMonitor SCT013;
int pinSCT = A0;
int tensao = 220;
int potencia;

//Seta o intervalo de envio para o broker
#define INTERVAL 15000

//defines de id mqtt e tópicos para publicação e subscribe
#define TOPICO "sensor01"     //tópico MQTT de envio de informações para o broker
#define ID_MQTT "MeuConsumo"  //id mqtt (para identificação de sessão)

//Configuração Wifi
const char* SSID = "RODOLFO - SPACEINFO";
const char* PASSWORD = "988295213";

//Configuração MQTT
const char* BROKER_MQTT = "10.0.0.15"; //Endereço do broker MQTT que se deseja utilizar
int BROKER_PORT = 1883; //Porta do Broker MQTT

//Variáveis e objetos globais
WiFiClient wifiClient; //Cria o obejeto wifiClient
PubSubClient client(wifiClient); //Instancia o cliente MQTT passando o objeto wifiClient

//Prototipos
void initSerial();
void initWiFi();
void initMQTT();
void reconectWiFi();
void VerificaConexoesWiFIEMQTT();

void setup()
{
  pinMode(pinSCT, INPUT);
  Serial.begin(115200);
  initWiFi();
  initMQTT();

  SCT013.current(pinSCT, 50);
}

//Inicializa e conecta-se na rede WI-FI desejada
void initWiFi()
{
  delay(10);
  Serial.println("------Conexao WI-FI------");
  Serial.print("Conectando-se na rede: ");
  Serial.println(SSID);
  Serial.println("Aguarde");

  reconectWiFi();
}

//Inicializa parâmetros de conexão MQTT(endereço do
//broker, porta e seta função de callback)
void initMQTT()
{
  client.setServer(BROKER_MQTT, BROKER_PORT);   //informa qual broker e porta deve ser conectado
  //MQTT.setCallback(mqtt_callback);            //atribui função de callback (função chamada quando qualquer informação de um dos tópicos subescritos chega)
}

//Reconecta-se ao broker MQTT (caso ainda não esteja conectado ou em caso de a conexão cair)
//em caso de sucesso na conexão ou reconexão, o subscribe dos tópicos é refeito.
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

//Reconecta-se ao WiFi
void reconectWiFi()
{
  //se já está conectado a rede WI-FI, nada é feito.
  //Caso contrário, são efetuadas tentativas de conexão
  if (WiFi.status() == WL_CONNECTED)
    return;
  // Conecta na rede WI-FI
  WiFi.begin(SSID, PASSWORD);

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

//Verifica o estado das conexões WiFI e ao broker MQTT.
//Em caso de desconexão (qualquer uma das duas), a conexão é refeita
void VerificaConexoesWiFIEMQTT()
{
  if (!client.connected())
    reconnectMQTT(); //se não há conexão com o Broker, a conexão é refeita

   reconectWiFi(); //se não há conexão com o WiFI, a conexão é refeita
}

//Programa principal
void loop()
{

  static unsigned long last_check = 0;

  //garante funcionamento das conexões WiFi e ao broker MQTT
  VerificaConexoesWiFIEMQTT();
  //keep-alive da comunicação com broker MQTT
  client.loop();

  if ((millis() - last_check) > INTERVAL) {
    // Calcula o valor da Corrente
    double Irms = SCT013.calcIrms(1480);
    // Calcula o valor da Potencia Instantanea
    potencia = Irms * tensao;

    client.publish(TOPICO, String(potencia).c_str());
    //Serial.print(Irms);
    //Serial.println(" A");

      last_check = millis();

  }

}
