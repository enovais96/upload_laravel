# Projeto Upload com Laravel
O intuito deste projeto foi aplicar boas práticas usando laravel 11 + PHP 8 em ambiente docker. O desafio é realizar uma rota via API Rest e processar esses dados.

# Programas necessários para utilização
	- Docker
	- Docker compose
    obs: Testado e validado no sistema operacional Ubuntu 22.04.1

# Passo a passo para rodar
	1 - Na raiz do projeto acessar o terminal e rodar o comando "docker-compose build"
	2 - Na raiz do projeto acessar o terminal e rodar o comando "docker-compose up -d"
    3 - Na raiz do projeto criar uma cópia do arquivo ".env.example" com o nome ".env"
    4 - Executar o comando no terminal "docker exec -it upload_laravel composer install"
    5 - Executar o comando no terminal "docker exec -it upload_laravel php artisan key:generate"
    6 - Executar o comando no terminal "docker exec -it upload_laravel php artisan migrate:install"
    7 - Executar o comando no terminal "docker exec -it upload_laravel php artisan migrate"
    8 - Acessar no navegador e validar se a url exibe uma tela do laravel "http://localhost:8989/"
	
# Como utilizar
Ao final dos passos acima o projeto estará funcional e pronto para ser usado, segue a o collection do Postman de exemplo para rota https://drive.google.com/file/d/1j-nChc6X-8CgOk9m4pa5z6obnCmQWc9R/view?usp=sharing

# IMPORTANTE
    1 - Para processar o arquivo enviado é necessário deixar rodando o seguinte comando no terminal "docker exec -it upload_laravel php artisan queue:work --timeout=300"
    2 - Comando para rodar os testes "docker exec -it upload_laravel php artisan test"

# Informações Adicionais
Foi informado no arquivo GenerateBoletoSendEmailJob como seria geração de boletos e envio de e-mail.
