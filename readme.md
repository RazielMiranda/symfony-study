# SYMFONY

## Instalação

O symfony pode ser instalado tanto pelo composer quanto pelo instalador dele mesmo.

    Para criar um projeto completo:
    symfony new my_project_name --full

    Para criar um micro projeto:
    symfony new my_project_name

    ou

    Para criar um projeto completo:
    composer create-project symfony/website-skeleton my_project_name

    Para criar um micro projeto:
    composer create-project symfony/skeleton my_project_name

A única diferença entre esses dois comandos é o número de pacotes instalados por padrão. A opção --full instala todos os pacotes que você normalmente precisa para criar aplicativos da web, para que o tamanho da instalação seja maior.

O full traz o gerenciador de templates como o twik.

Basicamente o de micro projeto serve apenas para criar API e ela ser consumida.

startando um projeto:

    cd my-project/
    symfony server:start

#### Configurando um projeto existente do Symfony

Além de criar novos projetos Symfony, você também trabalhará em projetos já criados por outros desenvolvedores. Nesse caso, você só precisa obter o código do projeto e instalar as dependências com o Composer. Supondo que sua equipe use Git, configure seu projeto com os seguintes comandos:

    cd my-project/
    composer install

#### Instalando pacotes

    composer require logger

#### Verificando vulnerabilidades de segurança

    symfony check:security

#### Estrutura do symfony

    bin = binarios do symfony
    config = configuração de pacotes
    public = pasta publica do projeto
    src = pasta com os controller
    var = pasta que seria equivalente ao storage do laravel
    vendor = pacotes composer
    .env = arquivo de configuração de ambiente

### Personalização do framework: Symfony flex

Com o symfony podemos expandir de forma estruturada e sustentável, incrementando funcionalidades conforme a demanda do nosso projeto.

O symfony usa o symfony flex que fica escutando palavras chaves nos comandos do composer
quando essas palavras chaves aparecem, ele coloca as "receitas" em ação que são basicamente
um plugin que é adicionado no composer.lock alterando o fluxo de instalação dos pacotes.

Existem diversas receitas que podem ser encontradas em:

https://flex.symfony.com/

## Rotas

No symfony é possivel escolher como voce quer construir as suas rotas, as formas de escrever as rotas são:

- YAML
é um arquivo de configuração de fácil sintaxe, que já vem ativado com o symfony

- Annotations é o mais utilizado no symfony
Voce configura a rota através de comentarios dentro da função

- PHP
Forma clássica do PHP, atraves de classes e metodos

- XML
Uma variante do arquivo de configuração

### Rotas: YAML

Para configurar as rotas no symfony devemos ir até config e la já temos um arquivo chamado
routes.yaml que é o arquivo de rotas principais, e podemos já ver como funciona a estrutura das rotas:

    #index: -- esse primeiro parametro é o nome da rota
    #    path: / -- aqui vai ser a URL que vai bater
    #    controller: App\Controller\DefaultController::index -- aqui é o controller que vai ser chamado, 
   
Pelas normas PSR o namespace APP aponta para a pasta src que já foi definido no composer.lock. Após descomentar a rota acima, podemos ir ao nosso ambiente e ver a rota funcionando.

### Rotas: Annotations

Para utilizar a annotations no symfony, primeiro devemos instalar usando o comando

    composer require annotations

Em seguida podemos utilizar elas da seguinte forma direto no controller, primeiro se deve
adicionar o pacote ao controller

    use Symfony\Component\Routing\Annotation\Route;

para usar as anotações devemos em cima da função desejada colocar sempre em forma de comentario

    /**
    *
    */

E para terminar de configurar a rota se usa

    /**
    * @Route("/", methods={"POST", "GET"})
    */

Onde o primeiro parametro é a URL que bate, e o segundo parametro é os metodos que
se usa no formulário.

## Controllers

Basta ir ate a pasta 'src' e dentro da pasta 'Controller' criamos um arquivo de Controller que desejamos, pois, o erro é exatamente sobre isso, a rota está batendo e quando invoca o controller ele nao existe, após chegar na pasta e criar o arquivo podemos escrever algo como:


    <?php

    namespace App\Controller;

    class DefaultController
    {
        public function index()
        {
        echo "oi";
        }
    }

Com isso temos um novo erro sendo o que devemos retornar um objeto do tipo response ficando algo como:

    <?php

    namespace App\Controller;
    use Symfony\Component\HttpFoundation\Response;

    class DefaultController
    {
        public function index()
        {
            //echo "oi";
            return new Response("Roi",200);
        }
    }

Outra forma é criarmos uam variavel e irmos manipulando o objeto com ela:


    class DefaultController
    {
        public function index()
        {
            $resp = new Response();
            $resp->setContent("Roi symfony sou o IZ mario!");
            $resp->setStatusCode(200);

            return $resp;
        }
    }


Lidando com a função de forma que a requisição receba dados via GET:

    <?php

    namespace App\Controller;
    use Symfony\Component\HttpFoundation\Response; -- Adicionar pacote de response
    use Symfony\Component\HttpFoundation\Request;

    class DefaultController
    {
        public function index(Request $req): Response  -- Adicionar o tipo para e o parametro para ficar mais tipado
        {
            $resp = new Response();
            $resp->setContent(json_encode(
                [
                    "recebido" => $req->get('nome'),
                    "IP" => $req->getClientIp()
                ]
            ));
            $resp->setStatusCode(200);

            return $resp;
        }
    }

## CONTROLLERS: API REST

1. Dentro da pasta src/Controller/ criar uma pasta "Api"
2. Dentro dessa pasta criar o arquivo com o mesmo nome do controller
3. Escrever código da API algo como:

        <?php

        namespace App\Controller\Api;

        use Symfony\Component\Routing\Annotation\Route;
        use Symfony\Component\HttpFoundation\JsonResponse;

        /**
        * @Route("/api/v1", name="api_usuario_")
        */

        class UsuarioController
        {
            /**
            * @Route("/lista", methods={"GET"}, name="lista")
            */
            public function lista(): JsonResponse
            {
                return new JsonResponse(["Implementar lista na API", 404]);
            }


            /**
            * @Route("/cadastra", methods=("POST"), name="cadastra")
            */
            public function cadastra(): JsonResponse
            {
                return new JsonResponse(["Implentar cadastro na API", 404]);
            }

        }


4. Para debugar as API usamos o comando symfony debug:router dessa forma conseguimos, ver todas as rotas de API
5. No symfony conseguimos dar nomes as rotas para isso basta adicioanar o parametro name="" na rota:

        /**
         * @Route("/lista", methods={"GET"}, name="lista")
         */

6. Colocando o prefixo acima da classe se altera o nome da onde a rota está

        /**
        * @Route("/api/v1", name="api_usuario_")
        */
        class UsuarioController

Conceitos de REST:

- Não retorna tela, e nada diferente de um JSON.
- Pode se versionar a API com pastas.
- Se usa a response em JsonResponse.
- Sempre retorna um codigo de status: 200, 404, 301.
- Com as API REST deve ser possivel executar um CRUD.

## VIEWS: TWIG

É o gerenciador de template do symfony, como usar?

    composer require twig

- Vai ser adicionado uma pasta chamada templates
- e um novo arquivo yaml do twig onde se pode customizar ele
- aqui temos um arquio base que vai ser o template pricipal
- para usar o template base basta apenas usar o extends
- com isso consegue usar e gerenciar o conteudo atraves do template

Se deve adicionar o extends na classe:

    extends AbstractController

e importar a biblioteca tambem:

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

Após a importação da biblioteca e da extensão da classe, pode começar a usar os metodos:

    /**
    * @Route("/", methods={"GET"}, name="index")
    */
    public function index(): Response
    {
        return $this->render("usuario/form.html.twig");
    }

Dessa forma consegeu rendereiza o layout.

### Customizando

    //Extendendo o layout
    {% extends "base.html.twig" %}
    
    {% block title %}ERRO!{% endblock %}

    {% block body %}
        <div class="alert alert-danger" role="alert">
            ERRO: ao cadastrar o usuario {{ fulano }}
        </div>
    {% endblock %}

Basta extender o layout e ai chamar o bloco que funciona como uma "variavel"
onde se troca apenas o conteudo dela. tudo que esta no bloco body, será 
refletido noa arquivo base.

Conseguimos tambem recever respostas em json e exibir elas colocando em {{ variavel }}
com isso conseguimos exibir o valor de uma variavel ou de algo.


## MODEL: DOCTRINE

O SYMFONY usa o doctrine como ORM para instalar use:

    composer require orm

ísso é uma receita.

Vai ser criado um arquivo yaml no packages chamado de doctrine, nesse arquivo
existe todas as confiurações do doctrine e o tipo de banco que ele vai aceitar
como vai ser escrita os models e os lugares onde será salva as entidades do BD.

Como padrão o ORM configura o mysql como banco de dados.

Tambem será adicionado 3 pastas ao projeto:

- migrations: aqui contem todo o script de modificações no banco de dados, o que tem de ser feito para a tabela ser criada, ou editada. Também versiona as migrations, em questão de estrutura

- entity: é a pasta que guarda as entidades do banco de dados.

- repositories: aqui é onde fica guardado os dados

Apos isso devemos configurar o banco de dados no env:

    DATABASE_URL=sqlite:///%kernel.project_dir%/var/symfony.sqlite3

Pode mudar o caminho das pastas e o nome do arquivo.

Após isso criar o banco de dados com:

    doctrine:database:create

Com isso podemos adicioanr tambem mais utilitario que auxilia na criação dos
controllers e dos models:

    composer require maker

Depois podemos criar a entidade com:

    make:entity

com isso vamos ir criando e configurando a entidade e depois vai ser
criado um arquivo na pasta entity e outro na repository.

Após configurar a tabela, é so rodar o comando:

    make:migration

ele vai criar um arquivo de migration, que serve para criar o banco de dados.

depois concretiza mandando isso pro bancod e ados:

    doctrine:migrations:migrate

Em seguida configuramos o controller para receber os dados algo como:

    use Symfony\Component\HttpFoundation\Request;
    use App\Entity\Usuario;

    /**
    * @Route("/salvar", methods={"POST"}, name="salvar")
    */
    public function salvar(Request $res): Response
    {
        $data = $res->request->all();

        $usuario = new Usuario;
        $usuario->setNome($data['nome']);
        $usuario->setEmail($data['email']);

        dump($usuario);

        //Para salvar no banco de dados
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($usuario);
        $doctrine->flush();

        dump($usuario);

        // dump($res->res->all());
        return $this->render("usuario/sucesso.html.twig", ['fulano' => $data]);
    }

Para exibir na view:

    {% for user in fulano %}
        <li>{{ user }}</li>
    {% endfor %}

Para executar um sql direto no BD:

    symfony console doctrine:query:sql "select * from usuarios";

Temos tambem o doctrine query language onde ele abstrai os SQL dos bancos de dados.

## MODEL: FUNÇÕES

Dentro do controller, conseguimos usar os metodos que criamos no Model, para isso dentro do model
devemos criar uma função e depois chamar essa função no controller.

Dentro da model (Repository):

    //pega todos os usuarios que são maior que 3
    public function ativos()
    {
        return $this->createQueryBuilder('u')
                    ->andWhere('u.id > :val')
                    ->setParameter('val')
                    ->getQuery()
                    //->getResult();
                    ->getArrayResult();

    }

Dentro do controller da api:

    public function lista(): JsonResponse
    {
        $doctrine = $this->getDoctrine()->getRepository(Usuario::class);
        dump($doctrine->ativos());

        return new JsonResponse(["Implementar lista na API", 404]);
    }
