/******************************************************************************
*                                                                             *
*    Obtendo desenhos para Matriz de led 8x8 via String na porta Serial       *
*                                                                             *
*    Versão: 1.0                                                              *
*    Data: 01/11/2013                                                         *
*    Autor: Alex Ishida                                                       *
*    Site: http://alexishida.com                                              *
*    E-mail: alexishida@gmail.com                                             *
*                                                                             *
******************************************************************************/

/* Definindo os pinos da matriz de Led */
int pinos[16]= {13, 12, 11, 10, 9, 8, 7, 6, 22, 23, 24, 25, 26, 27, 28, 29};
  
/* Definindo as colunas  */
int colunas[8] = {pinos[0], pinos[1], pinos[2], pinos[3], pinos[4], pinos[5], pinos[6], pinos[7]};

/* Definindo as linhas  */
int linhas[8] = {pinos[15], pinos[14], pinos[13], pinos[12], pinos[11], pinos[10], pinos[9], pinos[8]};


/* Definindo o tamanho da matriz dos desenho */
byte leds[8][8];

/* Setando variaveis */
byte col = 0;
String dados;


/* Bloco de configuração do Arduino */
void setup() {

  /* Setando todos os pinos para modo saída */
  for (int i = 0; i <= 16; i++) {
    pinMode(pinos[i], OUTPUT);
  }

  /* Resetando os dados da matriz de led */
  resetandoMatriz();

  /* Setando a velocidade bits por segundo. */
  Serial.begin(9600);
  
  /* Mostrando que a serial está conectada */
  //Serial.write("Conectado..");

}


/* Função para obter os dados via String da porta serial */
/* Retornando 1 - para dados obtidos com sucesso ou 0 sem captura dos dados */
int obtemDados() {
  
  /* Reseta os dados String */
  dados = "";

  if(Serial.available() > 0)
  {
    while(Serial.available() > 0)
    {
      dados += char(Serial.read());
      
      /* Da uma pausa para obter os dados */
      delay(3);
    }
    Serial.write("sucesso");
    return(1);

  }
  else {
    return(0);
  }


}



/* Função para preencher a matriz com o desenho obtido pela String da porta serial */
void gravaDesenho() {

  /* Reseta os dados */
  resetandoMatriz();
  int contDados = 0;
  
  for (int y = 0; y < 8; y++) {
    
    for (int x = 0; x < 8; x++) {
  
      /* Preenche a matriz dos desenhos apartir dos dados obtidos da função obtemDados() da porta serial */
      leds[y][x] = stringToInt(dados.substring(contDados,contDados+1));
      
      contDados++;
    }
  }

}

/* Resetando os dados da Matriz */
void resetandoMatriz() {

  /* Resetando os pinos da matriz */
  for (int a = 0; a <= 7; a++) {
    digitalWrite(colunas[a], LOW);
  }

  for (int b = 0; b <= 7; b++) {

    digitalWrite(linhas[b], LOW);
  }


  /* Resetando os dados do desenho da matriz */
  for (int i = 0; i < 8; i++) {
    for (int j = 0; j < 8; j++) {
      leds[i][j] = 0;
    }
  }
}


/* Mostra a imagem do desenho na matriz de led */
void mostrarImagem() {
  
  digitalWrite(colunas[col], LOW);  // Apaga toda a coluna anterior
  
  col++;
  if (col == 8) {
    col = 0;
  }
  
  for (int row = 0; row < 8; row++) {
    if (leds[col][7 - row] == 1) {
      digitalWrite(linhas[row], LOW);  // Acendo o led
    }
    else {
       
      digitalWrite(linhas[row], HIGH); // Apaga o led
   
    }
  }
  digitalWrite(colunas[col], HIGH); // Acende a coluna
  
  /* Pausa para formar os desenhos na matriz */
  delayMicroseconds(1000);
  
}

/* Converte o valor do String para Inteiro */
int stringToInt(String minhaString) {
  int i, x;
  int tam = minhaString.length() - 1;
  int numero = 0;

  for(i = tam; i >= 0; i--) {
    x = minhaString.charAt(i) - 48;
    numero += x * pow(10, tam - i);
  }
 
  return numero;
}


/* Laço principal do Arduino */
void loop() {
  
  /* Obtem os dados da porta Serial */
  if(obtemDados() == 1) {
   /* Preenche a matriz do desenho obtido na porta Serial */
   gravaDesenho();
   }
   
  /* Mostra a imagem do desenho na matriz de led */
  mostrarImagem();


}



