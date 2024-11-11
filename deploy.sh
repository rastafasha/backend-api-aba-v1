#!/bin/bash

# Leer la rama actual directamente desde .git/HEAD
BRANCH=$(cat .git/HEAD | sed 's/ref: refs\/heads\///')

# Configurar DEPLOYPATH según la rama
if [ "$BRANCH" == "develop" ]; then
    DEPLOYPATH="/home/z779cvj9zm4g/public_html/aba-dev.malcolmcordova.com/backend-api-aba/"
    ENVFILE=".env.dev"
elif [ "$BRANCH" == "main" ]; then
    DEPLOYPATH="/home/z779cvj9zm4g/public_html/abatherapy.malcolmcordova.com/backend-api-aba/"
    ENVFILE=".env.prod"
else
    echo "Rama no reconocida. No se puede configurar DEPLOYPATH."
    exit 1
fi

# Exportar DEPLOYPATH
export DEPLOYPATH

# Obtener la fecha y hora actual
TIMESTAMP=$(date +"%Y-%m-%d %H:%M:%S")

# Registrar el inicio del despliegue con la fecha y hora
echo "Starting at $TIMESTAMP" >> $DEPLOYPATH/deploy.log 2>&1

# Copiar archivos al directorio de despliegue
rsync -av --delete \
    --exclude='.git/' \
    --exclude='vendor' \
    --exclude='deploy.log' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    . $DEPLOYPATH >> $DEPLOYPATH/deploy.log 2>&1

# Copiar archivos específicos
/bin/cp -R .cpanel.yml $DEPLOYPATH >> $DEPLOYPATH/deploy.log 2>&1
/bin/cp -R .htaccess $DEPLOYPATH >> $DEPLOYPATH/deploy.log 2>&1
/bin/cp "$ENVFILE" "$DEPLOYPATH/.env" >> $DEPLOYPATH/deploy.log 2>&1

# Cambiar al directorio de despliegue
cd $DEPLOYPATH >> $DEPLOYPATH/deploy.log 2>&1

# Actualizar dependencias con Composer
php /opt/cpanel/composer/bin/composer update >> $DEPLOYPATH/deploy.log 2>&1

# Generar documentación de Swagger
php artisan l5-swagger:generate >> $DEPLOYPATH/deploy.log 2>&1

# Migrar y sembrar la base de datos
php artisan migrate:fresh --seed >> $DEPLOYPATH/deploy.log 2>&1

# Opcional: otros comandos de Artisan
# php artisan migrate --force
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache
# php artisan db:seed --class=TipoDemoraSeeder
