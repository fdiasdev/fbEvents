DESAFIO INGRESSE
================


Coleta de dados de eventos de usuários do Facebook


Instalação - Composer
----------------------

Recomendo criar uma cópia do projeto realizando clone do repositório git.

    cd my/project/dir
    git clone https://github.com/fdiasdev/fbEvents.git
    cd fbEvents
    php composer.phar install


Prerequisitos
-------------

- PHP 5.4
- Phalcon Framework
- MongoDB


Configuração
------------

Necessário informar no app/config.php, os parametros da app do facebook
(app_id, app_key), alem da url da callback

Também é necessário configurar um host no apache:

    <VirtualHost *:80>
        ServerName events.dev
        DocumentRoot /path/to/project/public
    </VirtualHost>

    <Directory "/path/to/project/public">
        Options Indexes Followsymlinks
        AllowOverride All
        Require all granted
    </Directory>
