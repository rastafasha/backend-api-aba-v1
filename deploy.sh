#!/bin/bash

# Obtener la rama actual
BRANCH=$(git rev-parse --abbrev-ref HEAD)

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
