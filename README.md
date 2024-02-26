# TesteAmplimed

# Tecnologias Utilizadas:
  **Laravel**
  **PHP**
  **JavaScript**
  **Ajax**
  **MySQL**
  **Xampp**

# Instrução de Uso
Para rodar o projeto será necessario fazer a instalação do Xampp de preferencia a versão 8.2.12, instalar o composer e o Laravel. Após isso o Xampp irá criar uma pasta no disco /C dentro dela abra a pasta httdocs delete tudo que tem dentro e coloque a pasta do projeto, abra pasta do projeto no cmd ou visual studio code, antes de rodar o projeto inicialize o Xampp e inicie o Apache e o MySql, acesse o admin do sql e importe o arquivo amplimed.sql do projeto, feito isso voce pode rodar o comando php artisan serve e deve funcionar. OBS: caso ocorra um erro na hora de utilizar uma das duas telas com conexão ao banco de dados veja no php.ini que fica na pasta raiz de onde está instalado o seu php se a linha extension=pdo_mysql possui um ; na frente, se tiver retire o ; e deve funcionar.

# Detalhamento do Projeto

Vamos começar do inicio, primeiramente gostaria de agradecer a AmpliMed pela oportunidade de estar realizando este teste, o projeto foi feito nos dias 24 e 25 de Fevereiro de 2024.

Como requisitado no projeto foi utilizado o Laravel/PHP para fazer as requisições as APIs de Clima e Cep bem como o salvamento dos dados para utilizar dentro do projeto como maneira de visualizar o historico de consultas.

# FrontEnd
O FrontEnd foi feito de maneira simples, porém, com algumas construções um pouco mais criativas apenas para ser mais bonito aos olhos, utilizando apenas de código "vanilla" por assim dizer. Ele consiste de 4 views sendo a "comparar" para consulta e comparação de tempo entre cidade, "busca" para buscar uma cidade ou clima e salvar a mesma no banco de dados, "index" para visualizar as consultas podendo filtrar por cidade e "home" para poder selecionar qual a função desejada.

No incio minha ideia seria ter apenas uma unica tela com dois inputs para selecionar a cidade, um botão para adicionar mais cidades e outro para abrir um iframe com o historico de consultas. Desisti pouco tempo após começar a fazer pois senti que seria algo muito bagunçado e não necessariamente a forma mais intuitiva de um usuario utilizar, por isso decidi separar a tela de consultas/comparação, a que iria salvar e o historico. Visto que mesmo que esse projeto tendo um chão e um teto outros projetos que tem um crescimento exponencial seria mais complicado de dar manutenção e implementar novas funcionalidades se estruturado da maneira que pensei inicialmente.

Quanto ao código escrito para o FrontEnd não houve um motivo muito especial, utilizei apenas html, css e javascript pois não achei que havia um motivo maior para usar um framework como React, Vue e etc. Quanto a construção coloquei o CSS que estaria se repetindo em um arquivo separado, utilizei algumas vezes a funcionalidade !important para coisas especificas bem como coloquei diretamente o CSS em algumas telas com uso único e também fiz uso do Media Query para melhorar o funcionamento no Mobile, adimito que para uso mobile tenho o costume de construir os elementos novamente do 0 especificamente para mobile visto que normalmente fica melhor mas decidi n"ao fazer nesse projeto, o JavaScript foi usado para ativar e desativar os componentes dos card, os qual são alimentados com as informações da resposta da API.

# BackEnd
O BackEnd optei em deixar o mesmo mais limpo visto que normalmente é mais facil de fazer o Debug de problemas no FrontEnd, por isso tenho o JavaScript tratando condições e requisições. Estruturei os Controllers dentro do caminho padrão do Laravel apenas opitando por criar a pasta "Api" para os controllers que fazem requisição as Apis de clima e cep.

Os 3 Controllers em uso são: CidadeController responsavel pela requisição a Api do Cep, ClimaController responsavel pela requisição a Api do Clima e CidadeClimaController o qual uso para buscar os registros no banco de dados para usar no historico. Se eu quisesse eu poderia ter utilizado apenas um Controller e feito 3 funções, mas não gosto de ter funcionalidades diferentes misturadas em um mesmo controller quando existe a possibilidade de separar.

Em resumo os dois controllers de api utilizam do curl para fazer as requisições as Api, usei algumas propriedades do mesmo para desativar a validação de SSL e utilizei algumas variaveis auxiliares para saber se a requisição estaria tendo a resposta salva no banco bem como para gravar o vinculo de cidade com clima. No controller do clima tentei fazer uma tradução para portugues baseado na lista de retornos que a Api disponibiliza visto que o parametro de linguagem precisa ser pago para usar, porém, a lista está desatualizada então podem haver erros no processo.

# Banco de Dados e Xampp
O banco de dados por padrão quis usar o MySql visto que meus projetos com Laravel sempre foram com MySql, o uso do Xampp foi apenas porque é a ferramenta que aprendi a usar para trabalhar com Laravel e banco de dados integrado localmente, sei que existem outras feramentas e maneiras de fazer isso mas como não havia um requerimento ou proibição no arquivo do projeto fiz o uso do Xampp.

Criei um banco de dados chamado climaamplimed com duas tabelas, clima e cidade, tanto as informações na tela quanto as gravadas na tabela são as mesmas, mesmo com a possibilidade de mostrar e gravar mais decidi usar as que considerei mais util na visão de um usuario normal. A unica coisa "diferente" no banco de dados é na tabela clima a qual eu gravo a coluna cidade_id a qua uso no ClimaController e CidadeClimaController para saber qual clima pertence a qual cidade para usar no historico.

** OBS: O arquivo em gif fica baixando a qualidade na hora que subo no readme, por isso estarei colocando um gif e um video nos arquivos do projeto também. **

![Home - Opera 2024-02-26 00-28-15 (2)](https://github.com/BMVBrun0/TesteAmplimed/assets/102544782/085520bf-d4ac-4bb5-bb63-bcc8257a569e)


