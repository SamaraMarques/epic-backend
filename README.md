Passo a passo para execução do backend

 - Instalar docker e docker compose

 - Criar um arquivo .env com base no .env.example

 - No terminal, na raiz do projeto, execute o comando "docker compose build app"

 - Após buildar a aplicação execute o comando "docker compose up"

 - A aplicação irá subir juntamente com o banco e uma instancia do ngnix

 - Abra outra aba do terminal e execute os seguintes comandos:
   - "docker exec -it epic-app php artisan migrate"
   - "docker exec -it epic-app php artisan key:generate"

 - A aplicação deverá estar executando após a execução desses passos