# Estudos de symfony

primeiro é necessario ter: PHP, MYSQL, APACHE E COMPOSER

### Como instalar:

- composer create-project symfony/skeleton <nome do projeto> // Instala apenas o básico
- composer create-project symfony/website-skeleton <nome do projeto> // Instala tudo que precisa
- pode se usar o server emnbutido do symfony

# symfony

- Baseado em MVC
    - MODEL: Onde fica as regras de negocio e interações com o banco de dados
        - DIR:

    - VIEW: Conceito de toda a parte visual do projeto
        - DIR: /templates

    - CONTROLLER: Onde é gerenciado o que vai ser mandado pra view e o que a model vai processar
        - DIR: /src 

- Para criar uma classe CONTROLLER 
    - composer require make
    - composer require annotations
    - ir ate a raiz do projeto:
        - php bin/console make:controller MainController

