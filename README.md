# Formulario votación Desis

_Formulario de contacto elaborado para prueba técnica Desis.cl_

## Clonar proyecto 🚀

_Para clonar el proyecto:_
```
git clone https://github.com/kornbyteapps/DESISFORM.git
```

### Pre-requisitos 📋

_Installar Xampp En su versión mas actual(en este caso 8.2.12)_

_Clonar el repositorio a  C:\xampp\htdocs_

-Importar base de datos votacion_db.sql desde phpmyadmin - para esto se crea una bd vacía, se selecciona y se le da a importar

Modificar el puerto por defecto de mysql a 4306 accediendo al archivo my.ini(en xampp click en config de mysql y abrir el archivo  y editar el port en el apartado # Here follows entries for some specific programs

Modificar el puerto por defecto del documento hayado en "C:\xampp\phpMyAdmin\config.inc.php" y agregar esta la linea $cfg['Servers'][$i]['port'] = 4306; en la seccion "/* Authentication type and info */"

_*Los archivos mencionados anteriormente se encuentran en este mismo repositorio en la carpeta "adicional"_

### Herramientas 🛠️

* [PHP 8.2.12](https://www.php.net) 
* [XAMPP 8.2.12](https://www.apachefriends.org/es/index.html)
* [MySQL 8.0](https://www.mysql.com)
* [Apache 2.4.5](https://httpd.apache.org)






