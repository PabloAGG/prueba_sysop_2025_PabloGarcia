create database SysOp_Prueba;
use SysOp_Prueba;

Create table usuarios(
idUser int not null auto_increment primary key comment'identificador unico de cada usuario',
nombre nvarchar (100) not null comment'Nombre de pila del usuario ' ,
telefeno nvarchar(10) not null comment'Numero de contacto del usuario',
fechaNac date not null comment 'Natalcio del usuario',
rfc nvarchar(15) not null comment 'Registro Federal de Contribuyentes asociado al usuario',
correo nvarchar(255) not null unique comment 'Credencial del usuario para autenticacion',
contraseña nvarchar(255) not null comment'Contraseña hasheada del usuario',
tipo enum('Administrador','empleado','Ejecutivo')
);