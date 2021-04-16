# RAPID C.R.U.D (ONE TABLE)

1 - criar banco de dados baseado na conexão

	php bin/console doctrine:database:create

2 - criar entidade (tabela banco + model no symfony + controller dessa model + view + repository)

	php bin/console make:entity
		- Nome da tabela
		- adicionar campos da tabela
			- nesse momento pode apertar ? para mostrar todos os tipos
			- denifir o tipo
			- deinir o tamanho
			- deinir nulo ou nao

3 - criar migrations (criar um arquivo com os comandos SQL responsavel por criar o banco de dados)
	
	php bin/console make:migrations
	
	php bin/console doctrine:migrations:migrate
		- executar de fato a migration

4 - criar C.R.U.D controllers
	
	php bin/console make:crud
		- Nome da entidade (Se colocar o nome de uma entidade "tabela" vai criar com base nos campos dela)
		- Nome dos controllers

5 - subir server pgp

	php -S 127.0.0.1:8000
		- entrar na pasta public e rodar
		- acessar URL

# Autenticação

	...