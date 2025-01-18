

## Estándares Frontend

### Arquitectura de Componentes

#### Componentización
Los elementos visuales recurrentes deben ser implementados como componentes Angular reutilizables. Esto incluye:
- Botones personalizados
- Tarjetas de información
- Formularios estandarizados
- Elementos de navegación
- Componentes de presentación de datos

#### Gestión de Estado y Llamadas API
- Las llamadas a la API deben realizarse exclusivamente en componentes a nivel de página
- Excepciones permitidas:
  - Componentes Tab que actúan como sub-páginas
  - Componentes completamente autónomos (requieren aprobación previa)
- Para justificar una excepción, se debe plantear en reunión de equipo

#### Optimización de Datos
- Evitar duplicación de llamadas al mismo endpoint en una misma ruta
- Utilizar apis de estado de Angular
- Preferir endpoints V2
- Utilizar parámetros de filtrado en backend en lugar de filtrar en frontend

### Tipado y Calidad de Código

#### Tipado
- Todas las variables nuevas deben estar tipadas explícitamente
- No se permite el uso de `any` excepto en casos justificados como:
  - Integración con librerías de terceros sin tipos disponibles
  - Datos dinámicos con estructura variable
- Cualquier excepción debe incluir al menos un comentario
- Utilizar interfaces para estructuras de datos complejas
- Implementar enums para valores predefinidos

#### Límites de Código
- Componentes limitados a 1000 líneas de código
- Estrategias para mantener componentes concisos:
  - Extraer lógica compleja a servicios
  - Crear sub-componentes para UI compleja
  - Utilizar patrones de diseño modernos
  - Las funciones deben ser pequeñas (no exceder 40 líneas de código)

### Testing Frontend

#### Requerimientos Mínimos
- Cada entrega de un trabajo debe incluir al menos una forma básica de testeo automatizado para ser considerada completa
- Cobertura mínima requerida:
  - Que el componente monte correctamente si es componente
  - Probar funcionalidad principal si la tiene
  - Probar integración si la hay

## Estándares Backend

### Integridad de Datos

#### Estructura de Base de Datos
- Cumplimiento de formas normales:
  - 1NF: Valores atómicos, no repetición de grupos
  - 2NF: Dependencias completas de clave primaria
  - 3NF: No dependencias transitivas
- Relaciones mediante claves foráneas
- No copiar información innecesariamente dentro de otras tablas

#### Migraciones y Seeders
- Si se realiza un cambio a alguna tabla, debe incluir su migración y actualizar seeders relevantes

### Testing Backend

#### Mantenimiento de Tests
- Suite de tests existente debe mantenerse en verde
- No se permite modificar tests existentes sin notificar (reunión de equipo o a mi personalmente)

#### Nuevas Funcionalidades
- Si se añade una nueva funcionalidad al backend, deben incluirse tests relevantes
- Si se crea un endpoint, como mínimo deben crearse tests para todos los métodos web que acepte, así como casos de uso que puedan producir errores

## Control de Versiones

### Flujo de Trabajo Git

#### Gestión de Ramas
1. Crear rama desde develop o main para cada tarea asignada. Se pueden fusionar tareas sólo si son de la misma área
2. Formato de nombre: `feature/descripcion-corta` o `fix/descripcion-corta`
3. Se recomienda mantener la rama actualizada desde su base si la tarea toma varios días
4. La única manera de pasar cambios a develop es mediante un PR

#### Pull Requests
- Requisitos para PR:
  1. Descripción de cambios
  2. Tests pasando
  3. Documentación actualizada
  4. Código revisado y limpio
- Proceso de revisión:
  1. Solicitar review
  2. Otro desarrollador debe aprobarlo, nunca la misma persona que hizo el PR
  3. Si el cambio afecta el funcionamiento de otras cosas, debe plantearse al resto del equipo

### Estándares de Commits
- Mensajes descriptivos y concisos
- Incluir contexto necesario
- Mantener commits atómicos y coherentes

## Proceso de Implementación

### Período de Adaptación
- Duración: 2 semanas iniciales
- Durante este tiempo, se considera "marcha blanca"
- Al término de este periodo, se evaluará en reunión si es necesario hacer ajustes
- Cualquier dificultad para llevar a cabo esto, es preferible conversarla que callarla
- Toda sugerencia para mejora es bienvenida

## Flujo de asignaciones
- Al recibir una nueva tarea, crear una rama
- Trabajar en la rama propia, realizando tests automatizados
- Al terminar, crear un PR y notificar el término, para quedar claros con el precio y pago
- Otra persona del equipo la revisa
- El cliente revisa, si es relevante
- En cualquiera de los puntos anteriores puede ser necesario volver atrás
- Se realiza el pago

## Beneficios Esperados

- Mayor calidad de código
- Reducción de errores en producción
- Mejor mantenibilidad
- Desarrollo más eficiente
- Clara trazabilidad del trabajo
- Facilitación de procesos de pago
- Mejora en la colaboración del equipo

## Conclusión

Estos estándares representan nuestro compromiso con la calidad y la excelencia técnica. Su implementación exitosa requiere la participación activa y el feedback de todo el equipo. Estaremos monitoreando y ajustando estos estándares según sea necesario para asegurar que cumplan con las necesidades del proyecto y del equipo.
