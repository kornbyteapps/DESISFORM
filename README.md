# Formulario votación Desis

_Formulario de contacto elaborado para prueba técnica Desis.cl_

## Clonar proyecto 🚀

_Para clonar el proyecto:_
```
git clone https://github.com/kornbyteapps/DESISFORM.git
```

### Pre-requisitos 📋

_Installar Xampp En su versión mas actual(en este caso 8.2.12)_

_Modificar el puerto por defecto de mysql a 4306 accediendo al archivo my.ini(en xampp click en config de mysql y abrir el archivo  y editar el port en el apartado # Here follows entries for some specific programs_
_# Here follows entries for some specific programs 

# The MySQL server
default-character-set=utf8mb4
[mysqld]
port=4306_

### Puesta a punto 🔧

_Una vez instalado lo anterior debemos proceder a configurar dentro del proyecto la base de datos que tengamos destinada para este fin_

-DEVELOP: Para iniciar el proyecto en develop debemos modificar el archivo LOCAL dentro de la carpeta Settings y añadir
los datos propios de nuestra base de datos_
``` python
  DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.mysql',
        'HOST': 'hostname',
        'PORT': 'puerto',
        'USER':'usuario',
        'PASSWORD':'password',
        'NAME':'name_db',
        'OPTIONS':{
            'init_command':"SET sql_mode='STRICT_TRANS_TABLES'"
        }
    }
}
```
_Adicional añadir los hosts permnitidos para las requests en_
``` python
ALLOWED_HOSTS = ['examplelocalhost:8800']

```
_PRODUCTION: para iniciar el proyecto en producción debemos realizar el procedimiento anterior pero para el archivo PRODUCTION.PY dentro de la carpeta Settings_
_Es necesario ademas realizar cambios a los archivos Settings/base.py, wsgi.py, asgi.py ,manage.py
```python
En manage.py : os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'tickets.settings.production)linea 9

En wsgi.py :os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'tickets.settings.production)linea 14

En asgi.py :os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'tickets.settings.production)linea 14

```

_Para el archivo Base modificar_

```python
ALLOWED_HOSTS = ['examplelocalhost:8800']
y pasar DEBUG = True a DEBUG = False

Setear adicionalmente el tiempo de vida para los tokens JWT use y refresh 
SIMPLE_JWT={
    'ACCES_TOKEN_LIFETIME':timedelta(hours=120),
    'REFRESH_TOKEN_LIFETIME':timedelta(hours=120),
    'ROTATE_REFRESH_TOKENS':True,
    'BLACKLIST_AFTER_ROTATION':True

}
```

_Una vez configurado lo anterior, procederemos a ejecutar las migraciones correspondientes de la siguiente forma_

## Para las migraciones ⚙️

_En la consola y dentro de la carpeta principal del proyecto ejecutar_

```
$ python manage.py makemigrations

luego
$ python manage.py migrate

Creamos un super usuario con
$ python manage.py createsuperuser

Finalmente corremos el servidor con
$ python manage.py runserver
```

### Para la documentación añadida del proyecto una vez corriendo dirigirse a la dirección local en la que esté corriendo el servidor /docu, ej:http://127.0.0.1:8000/docu/ 

para detalles sobre modelos creados con el ORM de DRF dirigirse a la carpeta apps/nombreapp/models.py⌨️


## Construido con 🛠️

_Herramientas principales:_

* [Python 3.9.13](https://www.python.org) - Version python
* [Django Rest Frameowrk oficial](https://www.django-rest-framework.org) - Api rest
* [Django Rest Frameowrk external](https://www.cdrf.co)Api rest docu extraoficial
* [Simple jwt](https://django-rest-framework-simplejwt.readthedocs.io/en/latest/) - generador de jwt
* [Django 4.0.6](https://docs.djangoproject.com/en/4.0/) - Core Framework django
* [django-simple-history](django-simple-history.readthedocs.io/en/latest/) - Registros historicos en bd
* [django-cors-headers](https://pypi.org/project/django-cors-headers/) - Manejador para CORS refrente a los headers enviados en las requests


## Expresiones de Gratitud 🎁

* Invita una cerveza 🍺 o un café ☕ a alguien del equipo. 
---
⌨️ con ❤️ por [Pududev](https://github.com/kornbyteapps) 😊
