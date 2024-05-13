
/*********************************
-- CREAR FUNCIONES
*********************************/

DROP FUNCTION IF EXISTS `Codigo_User`;
DELIMITER |
CREATE FUNCTION `Codigo_User`(usuario varchar(50)) RETURNS int(11)
	NO SQL
BEGIN
	SET @usuario := (SELECT id_usuario FROM usuarios where nombre_usuario = usuario);
    IF @usuario IS NULL THEN
		RETURN 0; -- si no existe usuario devuelve 0
	ELSE
		RETURN (SELECT id_usuario FROM usuarios where nombre_usuario = usuario); 
        -- si existe el usuario devolvera su codigo
    END IF;
END |
DELIMITER ;


/*********************************
-- CREAR VISTAS
*********************************/

drop view IF EXISTS vista_usuaria;
CREATE VIEW `vista_usuaria` AS
	SELECT id_usuaria, reclutadora, invitada, fecha_nacimiento, estudio, fecha_estudio, dni, observacion
    FROM usuaria;
DELIMITER ;


/*********************************
-- CREAR STORED PROCEDURE
*********************************/

DROP PROCEDURE IF EXISTS `SP_Usuario_Insert`;
DELIMITER |
CREATE PROCEDURE `SP_Usuario_Insert`(in nombre varchar(50), in email varchar(100), 
in pass varchar(50), in idrol int, in idestado int, OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
	ROLLBACK;
	END;
 
	START TRANSACTION;
	SET @clave = password(pass);
    insert into usuarios(nombre_usuario, correo, contrasenia, id_rol, id_estado) 
    values (nombre, email, @clave, idrol, idestado);
    SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_Login_validar`;
DELIMITER |
CREATE PROCEDURE `SP_Login_validar`(in usuario varchar(50), in pass varchar(100), OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
	ROLLBACK;
	END;
 
	START TRANSACTION;
    SET @clave = password(pass);
    SELECT id_usuario into success FROM usuarios where nombre_usuario = usuario and contrasenia = @clave;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_user_rol`;
DELIMITER |
CREATE PROCEDURE `SP_user_rol`(in codusuario int, OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
	ROLLBACK;
	END;
 
	START TRANSACTION;    
    SELECT id_rol into success FROM usuarios where id_usuario = codusuario;
    COMMIT;
END |
DELIMITER ;




/*********************************
-- PRUEBAS
*********************************/

CALL SP_Paquete_Finanzas('la libertad');
call SP_paquete_finanzas_enviados_consulta();
set @x = 0;
set @x = Codigo_User('casa');
select @x;

SET @success = 0;
call SP_Paquete_Finanzas_Insert('arequipa','percy',@success);
select @success;

call SP_reporte_finanzas_regiones('arequipa');
SELECT * FROM vista_usuaria ;


call SP_reporte_finanzas_valorizacion(3)

