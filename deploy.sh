#!/bin/bash

# Leer la rama actual directamente desde .git/HEAD
BRANCH=$(cat .git/HEAD | sed 's/ref: refs\/heads\///')

# Configurar DEPLOYPATH según la rama
if [ "$BRANCH" == "develop" ]; then
    DEPLOYPATH="/home/z779cvj9zm4g/public_html/aba-dev.malcolmcordova.com/backend-api-aba/"
elif [ "$BRANCH" == "main" ]; then
    DEPLOYPATH="/home/z779cvj9zm4g/public_html/abatherapy.malcolmcordova.com/backend-api-aba/"
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
