CREATE DATABASE bd_estudios CHARACTER SET utf8mb4  COLLATE utf8mb4_spanish_ci;

SHOW CHARACTER SET LIKE 'utf%';
SHOW COLLATION WHERE Charset = 'utf8mb4';
DESCRIBE finanzas_paquete_aprobacion;
SHOW TABLE STATUS where name like 'finanzas_paquete_aprobacion';
SELECT CURRENT_DATE();

/*********************************
-- ELIMINAR TABLAS 
*********************************/

DROP TABLE if exists usuaria;
DROP TABLE if exists usuarios;
DROP TABLE if exists roles;

/*********************************
-- CREACION DE TABLAS 
*********************************/

CREATE TABLE usuaria (
	id_usuaria	integer NOT NULL AUTO_INCREMENT,
	reclutadora			varchar(50) NOT NULL,
	invitada			varchar(50) NOT NULL,
    fecha_nacimiento	DATETIME NOT NULL,
    estudio				varchar(100) NOT NULL,
    fecha_estudio		DATETIME NOT NULL,
    dni					varchar(8) NULL,
	observacion			varchar(100) NULL,
    PRIMARY KEY (id_usuaria)
) DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE usuarios
(	id_usuario		INTEGER NOT NULL,
	nombre_usuario	VARCHAR(50) NULL,
    correo 			VARCHAR(100) NULL,
	contrasenia	    VARCHAR(50) NULL,
    id_rol          INTEGER NULL,
	id_estado       INTEGER NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

ALTER TABLE usuarios ADD PRIMARY KEY (id_usuario);
ALTER TABLE usuarios MODIFY id_usuario INT NOT NULL AUTO_INCREMENT ;

CREATE TABLE roles
(	id_rol           INTEGER NOT NULL,
	nombre_rol        VARCHAR(50) NULL
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

ALTER TABLE roles ADD PRIMARY KEY (id_rol);
ALTER TABLE roles MODIFY id_rol INT NOT NULL AUTO_INCREMENT ;


/*********************************
-- CREACION DE LLAVES FORANEAS 
*********************************/

ALTER TABLE usuarios ADD FOREIGN KEY R_39 (id_rol) REFERENCES roles (id_rol);
ALTER TABLE usuarios ADD CONSTRAINT UC_usuarios UNIQUE (nombre_usuario);

/*********************************
-- INSERTANDO DATOS INICIALES 
*********************************/
insert into roles(nombre_rol) values('Administrador');
insert into roles(nombre_rol) values('Analista');

call SP_Usuario_Insert('percy', 'percy.herrera@puncheresearch.com', '10141618', 1, 1, @total);
call SP_Usuario_Insert('josecarlos', 'josecarlos.perez@puncheresearch.com', '123456', 2, 1, @total);
call SP_Usuario_Insert('miguel', 'miguel.cari@puncheresearch.com', '123456', 2, 1, @total);
call SP_Usuario_Insert('eunice', 'eunice.laguna@puncheresearch.com', '123456', 2, 1, @total);
call SP_Usuario_Insert('julia', 'julia.quito@puncheresearch.com', '123456', 2, 1, @total);
call SP_Usuario_Insert('rosa', 'rosa.urbano@puncheresearch.com', '123456', 2, 1, @total);


insert into usuaria (reclutadora, invitada, fecha_nacimiento, estudio, fecha_estudio, dni, observacion ) values 
('Edda Sanes Rivero','Elvira Huerta Tarazona','1976/04/13','LABIAL COLOR ADDICTION','2024/04/13','',''),
('Edda Sanes Rivero','Elvira Huerta Tarazona','1976/04/13','LABIAL COLOR ADDICTION','2024/04/13','',''),
('Rocio Zevallos','Michel García','1976/04/13','LABIAL COLOR ADDICTION','2024/04/13','','');

/***********************************************
-- REINICIAR EL AUTO INCREMENTE DE LAS TABLAS 
************************************************/
ALTER TABLE finanzas_periodos AUTO_INCREMENT = 1;
truncate table finanzas_periodos ;
select * from usuaria;