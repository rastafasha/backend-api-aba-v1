#!/bin/bash

BRANCH=$(cat .git/HEAD | sed 's/ref: refs\/heads\///')
TIMESTAMP=$(date +"%Y-%m-%d_%H:%M:%S")
CURRENT_FOLDER=$(pwd)

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

DEPLOY_LOG="$CURRENT_FOLDER/storage/logs/deploy_$TIMESTAMP.log"
# Exportar DEPLOYPATH
export DEPLOYPATH
export ENVFILE
export TIMESTAMP
export DEPLOY_LOG


# Registrar el inicio del despliegue con la fecha y hora
echo "Starting at $TIMESTAMP" >> $DEPLOY_LOG 2>&1
echo "ENVFILE=$ENVFILE" >> $DEPLOY_LOG 2>&1

# Copiar archivos al directorio de despliegue
rsync -av --delete \
    --exclude='.git/' \
    --exclude='vendor' \
    --exclude='deploy.log' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    . $DEPLOYPATH >> $DEPLOY_LOG 2>&1

# Copiar archivos específicos
/bin/cp -R .htaccess $DEPLOYPATH >> $DEPLOY_LOG 2>&1
/bin/cp -R $ENVFILE $DEPLOYPATH/.env >> $DEPLOY_LOG 2>&1

# Cambiar al directorio de despliegue
cd $DEPLOYPATH >> $DEPLOY_LOG 2>&1

chmod 755 .
# Actualizar dependencias con Composer
php /opt/cpanel/composer/bin/composer update >> $DEPLOY_LOG 2>&1

# Generar documentación de Swagger
php artisan l5-swagger:generate >> $DEPLOY_LOG 2>&1

# Migrar y sembrar la base de datos
php artisan migrate:fresh --seed >> $DEPLOY_LOG 2>&1

# Opcional: otros comandos de Artisan
# php artisan migrate --force
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache
# php artisan db:seed --class=TipoDemoraSeeder
