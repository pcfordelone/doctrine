### **Projeto Fase 02 - Code.Education - Módulo Doctrine**

**Pré-requisitos:**

1. PHP 5.5 ou posterior. Versões anteriores podem ocasionar erros;
2. Importar o arquivo code_doctrine em MYSQL em servidor local. Caso queria importar o arquivo em servidor externo, é necessária a configuração do banco no arquivo **bootstrap.php**
3. Para maior facilidade, utilize o server bult-in do próprio php.
4. rodar o comando em seu terminal: php composer.phar install

**Utilizando o server buil-in PHP:**  

1. Abra o terminal na raiz do projeto e digite php -S localhost:8000 -t public/ 
2. Em seu navegador digite localhost:8000
3. Pronto, você já irá visualizar a Página Inicial do Projeto.

**REST**

**Para acessar os dados em JSON utilizando qualquer API siga os passos a seguir:**

1. LISTAR TODOS OS PRODUTOS -> localhost:8000/api_produtos/ | método GET
2. LISTAR ÚNICO PRODUTO -> localhost:8000/api_produtos/{id_produto} | método GET
3. INCLUIR -> localhost:8000/api/produtos/ | método POST
4. ALTERAR -> localhost:8000/api/produtos/{id_produto} | método PUT 
5. EXCLUIR -> localhost:8000/api/produtos/{id_produto} | método DELETE 

Sugestão: Utilizar o app Postman - REST Cliente do Google Chrome para testes.


