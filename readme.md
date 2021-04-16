# C.R.U.D RAPIDO (UMA TABELA)

1 - Criar banco de dados baseado na conexão

	php bin/console doctrine:database:create

2 - Criar entidade (Tabela banco + model no symfony + controller dessa model + view + repository)

	php bin/console make:entity
		- Nome da tabela
		- Adicionar campos da tabela
			- Nesse momento pode apertar ? para mostrar todos os tipos
			- Definir o tipo
			- Definir o tamanho
			- Definir nulo ou nao

3 - Criar migrations (Criar um arquivo com os comandos SQL responsavel por criar o banco de dados)
	
	php bin/console make:migrations
		- Registra a migration no projeto criando um arquivo para ela

	php bin/console doctrine:migrations:migrate
		- Registra a migration no banco de dados

4 - Criar C.R.U.D controllers (Arquivos de controller com operações SQL + views para cada controller)
	
	php bin/console make:crud
		- Nome da entidade para espelhar as operações SQL
		- Nome dos controllers da entidade

5 - Subir server PHP

	php -S 127.0.0.1:8000
		- entrar na pasta public e rodar esse comando para subir um servidor embutido do PHP

#### TUTORIAL: https://www.youtube.com/results?search_query=criando+login+com+symfony+5


# TODO: # C.R.U.D RAPIDO (MUITAS TABELAS E TABELAS COM RELAÇÕES)

    ...

# Criação de sistema de usuarios com autenticação (REGISTRO R LOGIN)

1 - Criar model usuario

    php bin/console make:user

2 - Criar migração

    php bin/console make:migration

3 - Executar migração

    php bin/console doctrine:migrations:migrate

4 - Criar autenticação

    php bin/console make:auth

5 - Configurar security.yaml

    security
        - Ver se esta certo
    providers
        - Ver se esta certo

    TODO: ESTUDAR MELHOR SOBRE ESSAS PERMIÇÕES DE USUARIO
    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        # - { path: ^/admin, roles: ROLE_ADMIN }
        # - { path: ^/profile, roles: ROLE_USER }
        - { path: ^/login$, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/*, roles: ROLE_USER }
        - { path: ^/admin, roles: ROLE_ADMIN }

6 - Ir no controller criado de Autenticação (nesse caso: Security\LoginFormAuthenticator.php)

    Verificar
        - private $passwordEncoder;
        - public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
            {
                $this->entityManager = $entityManager;
                $this->urlGenerator = $urlGenerator;
                $this->csrfTokenManager = $csrfTokenManager;
                $this->passwordEncoder = $passwordEncoder;
            }
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    
    *Caso nao tenho nada disso o encoder nao foi instalado

7 - Instalar (ORM FIXTURES)

    //TODO: PESQUISAR PRA QUE SERVE
    composer require --dev orm-fixtures

    Adionar a classe nesse pacote ???
        <?php
        
        namespace App\DataFixtures;
        
        use App\Entity\User;
        use Doctrine\Bundle\FixturesBundle\Fixture;
        use Doctrine\Persistence\ObjectManager;
        use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
        
        class UserFixtures extends Fixture
        {
            private $encoder;
        
            public function __construct(UserPasswordEncoderInterface $encoder)
            {
                $this->encoder = $encoder;
            }
        
            public function load(ObjectManager $manager)
            {
                $user = new User();
                $user->setEmail('admin@mediaforce.com');
                $user->setPassword($this->encoder->encodePassword($user,'some'));
                $manager->persist($user);
        
                $manager->flush();
            }
        }

        Por fim rodar esse comando
            bin/console doctrine:fixtures:load    

#### TUTORIAL: https://www.youtube.com/watch?v=1lKHlYeusgQ