Sistema Web para la Gestión de Justificantes.
Este repositorio contiene el script necesarios para configurar la base de datos que utiliza el sistema web.
Nota: Este proyecto depende completamente de la base de datos para funcionar.
___________________________________________________________________________________________________________________________________
📂 Contenido del Repositorio
  gestion_justificantes.sql: Archivo SQL para la creación y configuración inicial de la base de datos.
  
🚀 Instrucciones para Importar la Base de Datos
  *Requisitos previos*
  Antes de importar la base de datos, asegúrate de tener instalado:
  
  - Servidor de base de datos: MySQL (v8.0 o superior).
  - Herramienta de gestión: Línea de comandos de MySQL o una herramienta gráfica como MySQL Workbench.
    
  *Importación usando MySQL Workbench*
  -Abre MySQL Workbench y conéctate a tu servidor.
  -Crea una base de datos nueva si aún no existe:
      * Ve a la pestaña de Schemas.
      * Haz clic derecho y selecciona Create Schema.
      * Escribe el nombre de tu base de datos y confirma.
  -Ve a File > Open SQL Script y selecciona el archivo schema.sql.
  -Asegúrate de seleccionar la base de datos que acabas de crear como predeterminada.
  -Ejecuta el script presionando el botón de "Run" (⚡).
  
  *Importación usando phpMyAdmin*
  -Accede a phpMyAdmin desde tu navegador.
  -Crea una base de datos nueva:
      * Haz clic en la pestaña Base de datos.
      * Ingresa un nombre para la base de datos y selecciona la intercalación (utf8_general_ci es recomendada).
      * Haz clic en Crear.
  -Haz clic en la base de datos que acabas de crear.
  -Ve a la pestaña Importar.
  -Haz clic en Elegir archivo y selecciona el archivo schema.sql.
  -Haz clic en Continuar para ejecutar el script.
  
📦 Dependencias
    Para utilizar correctamente este sistema web, asegúrate de tener las siguientes herramientas configuradas:
    - PHP (v7.4 o superior): Lenguaje de programación para ejecutar el sistema web.
    - Servidor web Apache (se recomienda usar un paquete como XAMPP o WAMP).
    - MySQL Server configurado correctamente para conectar con el sistema.
    - Archivo de configuración PHP que establezca la conexión con tu base de datos. Asegúrate de incluir:
    - Host: localhost (o según la configuración de tu servidor).
    - Usuario y contraseña del servidor MySQL.
    - Nombre de la base de datos importada.
    
❓ Soporte
Si encuentras problemas al configurar o importar la base de datos, verifica que el archivo gestion_justificantes.sql no contiene errores y que tu servidor está configurado correctamente. 
