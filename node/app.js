const mosca = require('mosca'); //Importa o modulo Mosca
var redis = require("redis"),
    clientRedis = redis.createClient(); //Instancia do cliente redis para inserção de dados no BD

let settings = {
  port: 1883, //Define a porta de operação do MQTT
  id: 'mymosca',
  backend: {
    type: 'redis'
  },
  persistence: {
    factory: mosca.persistence.Redis
  }
};

let server = new mosca.Server(settings);

// Evento: ocorre quando um novo cliente se conecta ao Broker
server.on('clientConnected', function (cliente) {
    console.log('Cliente Conectado', cliente.id); // Exibe uma mensagem com o ID do cliente conectado
});

// Evento: ocorre quando um cliente se desconecta do Broker
server.on('clientDisconnected', function (cliente) {
    console.log('Cliente Desconectado: ', cliente.id);
});

server.on('ready', () => {
  // Configura callbacks de autenticação e autorização
  console.log('Broker MQTT aguardando conexões na porta', settings.port);
});

// Evento: ocorre quando um cliente publica no broker
server.on('published', (packet, client) => {
  //console.log('Message published on topic: ', packet.topic, '/', packet.payload.toString());
  console.log(packet.payload.toString() + ' A');
  var topic = packet.topic;
  var message = packet.payload.toString();
  Insert(topic, message);
});

//Função para inserção dos dados no Redis
function Insert(topic, message) {
  var data = formataData();
  //console.log(data);
  var topico = topic + "/" + data;
  clientRedis.HMSET(topico, {
    "potencia": message,
    "data": data
  });
}

//Função usada para formatar data para inserir no BD
function formataData() {
    var data = new Date();
    var dia = data.getDate();
    var mes = data.getMonth() + 1;
    var ano = data.getFullYear();
    var hora = data.getHours();
    var minuto = data.getMinutes();
    var segundo = data.getSeconds();

    //Condições para inserir o '0' no horario
    if(segundo<10) segundo = "0" + segundo;
    if(minuto<10) minuto = "0" + minuto;
    if(hora<10) hora = "0" + hora;
    if(dia<10) dia = "0" + dia;
    if(mes<10) mes = "0" + mes;

    data = dia + "-" + mes + "-" + ano;
    horario = hora + ":" + minuto + ":" + segundo;

    return data + '_' + horario;
}
