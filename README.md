<h1>Aprendizado com codeigniter 4</h1>

Este projeto foi construído com o intuito de aprendizagem, contribuir com quem deseja aprender o desenvolvimento com este framework.

<h3>Usando a aplicação</h3>

Faça o download dos arquivos ou clone-o em um diretório de sua escolha, então pode utilizá-lo através do servidor embutido no framework ou a partir do diretório raiz do servidor que estiver utilizando como Apache, IIS entre outros.

<strong>OBS</strong>: Por questão de esclarecimento, durante todo o processo de desenvolvimento, foi utilizado o servidor web do próprio framework através do comando <strong>“php spark serve”</strong>.

<h3>Alguns detalhes antes de começar</h3>

Verifique os arquivos de configuração contidos na pasta <strong>“app/Config”</strong> e as modifique para sua necessidade, ou então utilize um arquivo <strong>“.env”</strong>.

Lembre-se de criar previamente um <strong>banco de dados</strong> para a aplicação.

Em banco de dados <strong>Mysql/MariaDB</strong> é importante assim que instalado o xampp, executar <strong>mysql_upgrade</strong> para não ter problemas com os programas de modelagem, caso opte em realizar modificações no banco que não seja por meio das migrações.

<h3>Para sistemas baseados em Linux</h3>

- É preferível utilizar o <strong>composer</strong>  instalado manualmente, pois a versão do PHP que vem como dependência do composer (em determinadas distribuições) pode não ser a mesma versão do PHP que vem com o instalador do xampp. Um dos problemas mais comuns é o framework não encontrar as extensões que necessita do PHP.
- Assim que o composer estiver instalado, crie um link simbólico de <strong>/opt/lampp/bin/php</strong> para <strong>/usr/local/bin/php</strong> para o composer encontrar o PHP que vem instalado do xampp.

<h3>O sistema</h3>

- xampp server versão 8.1.5-0
- mariadb 10.4.24
- codeigniter 4.1.9
- linux kernel 5.15.41-1

<h3>O projeto</h3>

Este projeto trata de um sistema que faz o controle de tarefas <strong>básicas</strong> de uma empresa fictícia.

- clientes
- funcionários
- fornecedores
- vendas
- compras

Nele foram aplicados conceitos de <strong>CRUD</strong>, <strong>TRANSACTION</strong>, <strong>SERVICES</strong>, <strong>LIBRARIES</strong>, <strong>FILTERS</strong>, <strong>SESSION</strong>, <strong>EMAIL</strong>, <strong>ENTITIES</strong> entre outros... 

Bons estudos a todos.
