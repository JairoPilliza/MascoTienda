create database TiendaMacotas;
Create table mascotas (
    id int(11) not null auto_increment primary key,
    especie varchar(20) not null,
    raza varchar(200) not null,
    detalle varchar(500) not null,
    fechaNacimiento datetime not null,
    estado enum('1','0'), 
    rutaFoto varchar(200)
);

Insert into mascotas values('','camino','pochon','El perro poochon es una raza híbrida entre un caniche y un bichon frisé originaria de Australia.','15-01-2021',1,'img/archivos/poochon.jpg');
Insert into mascotas values('','camino','labsky','Los labsky son un cruce entre un husky siberiano y un labrador, debido a esto, esta raza híbrida suele tener las características de sus progenitores','15-01-2021',1,'img/archivos/labsky.jpg');
Insert into mascotas values('','camino','pug','El pug, doguillo o carlino es un perro muy particular. ','15-01-2021',1,'img/archivos/pug.jpg');
Insert into mascotas values('','camino','rottweiler','El rottweiler es un perro fuerte, robusto y atlético. ','15-01-2021',1,'img/archivos/rottweiler.jpg');