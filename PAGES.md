/smartlearn
│── /public           # Mantém os ficheiros públicos acessíveis diretamente pelo navegador, como index.php, imagens e scripts front-end.
│── /src              # Lógica central da aplicação
│   ├── /controladores  # Processa as requisições, coordena a lógica entre modelos e visualizações.
│   ├── /modelos        # Define as interações com a base de dados (CRUD, lógica de negócio).
│   ├── /visualizacoes  # Armazena os ficheiros de interface (templates HTML, layouts).
│   ├── /helpers        # Funções auxiliares como validação de dados, conversões, formatações.
│   ├── /config         # Mantém configurações centralizadas, o que facilita ajustes globais. (base de dados, constantes)
│   ├── /middlewares    # Excelente para autenticação e segurança.
│── /assets           # Bem definido para armazenar CSS, JavaScript e imagens.
│── /base_dados       # Boa prática para armazenar scripts SQL, migrações e backups.
│── /logs             # Muito útil para depuração e segurança, registando erros e atividades do sistema.
│── /testes           # Importante para garantir qualidade e funcionamento correto das funcionalidades.
│── .htaccess         # Essencial para segurança, reescrita de URLs e configurações do Apache.
│── config.php        # Centraliza configurações como credenciais da base de dados.
