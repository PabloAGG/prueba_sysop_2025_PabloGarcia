create database  IF NOT EXISTS SysOp_Prueba;
use SysOp_Prueba;

Create table  IF NOT EXISTS usuarios(
idUser int not null auto_increment primary key comment'identificador unico de cada usuario',
nombre nvarchar (100) not null comment'Nombre de pila del usuario ' ,
telefeno nvarchar(10) not null comment'Numero de contacto del usuario',
fechaNac date not null comment 'Natalcio del usuario',
rfc nvarchar(15) not null comment 'Registro Federal de Contribuyentes asociado al usuario',
correo nvarchar(255) not null unique comment 'Credencial del usuario para autenticacion',
contraseña nvarchar(255) not null comment'Contraseña hasheada del usuario',
tipo enum('Administrador','empleado','Ejecutivo'),
imgPath nvarchar(255) null comment'avatar del usuario',
estado boolean default 1 comment'estado para verificar etelefenol usuario'
);
INSERT INTO `usuarios` VALUES (1,'Pablo Garcia Garza','8131558877','2025-05-06','PERE750303HI5','ivan@gmail.com','$2y$10$gSKAm9TlYNKNK5LjFsEcte/9nDFToTgBwX5FOTu66XFArcZX1/OFu','empleado','../img/68673dceda017_default.webp',0),
(2,'Alan Adame','8131558879','2025-06-17','PERE750303GO9','Adame@gmail.com','$2y$10$zevT9obYm0RIDuvBWdcivO5wuLxA/bFhuRm.8ePDDGVQ4M56mtiTy','Administrador','IMG/6867f8134baf4_dv.jpg',1),
(3,'Santiago Hernandez de la Rosa','8131558800','2025-05-06','SANA750303HI5','santy@gmail.com','$2y$10$qtSHU.f61F3.NK/8F8NDYuqpuLTH6PQR39YcBuIaLEdtDihaDcsKm','Ejecutivo','IMG/6867f7162db1e_descargar.jpg',1),
(4,'Juan Montoya','8131778879','2004-03-10','JMGH750303HI5','montoya@gmail.com','$2y$10$B/QUpo4yXCZXAgzMnXow3.n.YkX9YjLt9e0yR03i03PurB4wqju8C','Ejecutivo','IMG/6867f1e35ef73_descargar.jpg',0),
(5,'Alan Fernando Gonzales Rocha','8131658577','2020-03-11','AFGR750303HIA','Ana@gmail.com','$2y$10$KpfTNkVAxedA/GkfW3PDWuTA5WkN1iKw0Z9eHMTbLL4S/DtqUAHbm','empleado','IMG/6867f8a2660f9_ChatGPT Image 4 jul 2025, 09_51_44 a.m..png',1),
(6,'Ana Alonso Acosta','8131558899','2000-02-11','ANAD750303HI5','anaA@gmail.com','$2y$10$S2phPR3jxxatKXTEsX42yeLbYSOIJmMRm5iUfaTeeZonipWe9vWwe','Ejecutivo','IMG/6867f8e8392db_Código fonte da área de trabalho e papel de parede por linguagem de computador com codificação e programação_ _ Foto Premium.jpg',1),
(7,'Admin','8131558811','1999-11-11','ADMN750303HI5','admin@gmail.com','$2y$10$86HU0tqqgcOwcecxJWT5jerwlHOa9d7zFClCfiu1G78H1hjPF6EXe','Administrador','IMG/686803a5493b0_Gemini_Generated_Image_n4gnvmn4gnvmn4gn.png',1);