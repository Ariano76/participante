
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

DROP FUNCTION IF EXISTS `bono_familiar`;
DELIMITER |
CREATE FUNCTION `bono_familiar`(codbenficiario int) RETURNS decimal(6,2)
	NO SQL
BEGIN
    IF codbenficiario IS NULL THEN
	 RETURN 0; -- si no existe usuario devuelve 0
	ELSE
	 RETURN (select CASE 
	 if(length(concat(i.nombre_1a,' ',i.nombre_1b))<3,0,1) + 
	 if(length(concat(i.nombre_2a,' ',i.nombre_2b))<3,0,1) + 
	 if(length(concat(i.nombre_3a,' ',i.nombre_3b))<3,0,1) +	
	 if(length(concat(i.nombre_4a,' ',i.nombre_4b))<3,0,1) + 
	 if(length(concat(i.nombre_5a,' ',i.nombre_5b))<3,0,1) +	
	 if(length(concat(i.nombre_6a,' ',i.nombre_6b))<3,0,1) + 
	 if(length(concat(i.nombre_7a,' ',i.nombre_7b))<3,0,1) + 1
	 WHEN 1 THEN (select asignacion from finanzas_bono_familiar where id_familiar=1)
	 WHEN 2 THEN (select asignacion from finanzas_bono_familiar where id_familiar=2)
	 WHEN 3 THEN (select asignacion from finanzas_bono_familiar where id_familiar=3)
	 WHEN 4 THEN (select asignacion from finanzas_bono_familiar where id_familiar=4)
	 WHEN 5 THEN (select asignacion from finanzas_bono_familiar where id_familiar=5)
	 ELSE (select asignacion from finanzas_bono_familiar where id_familiar=6)
	 END AS 'monto'
	 from integrantes i where i.id_beneficiario = codbenficiario);
	 -- si existe el usuario devolvera su bono familiar
    END IF;
END |
DELIMITER ;

DROP FUNCTION IF EXISTS `bono_conectividad`;
DELIMITER |
CREATE FUNCTION `bono_conectividad`(codbenficiario int) RETURNS decimal(5,2)
	NO SQL
BEGIN
    IF codbenficiario IS NULL THEN
	 RETURN 0; -- si no existe usuario devuelve 0
	ELSE
	 RETURN (select  
	  IF((c.laptop=1 or c.smartphone=1) and dersec.interesado_participar_nutricion=1 
      and (c.como_accede_a_internet="Por wifi  por horas" 
      or c.como_accede_a_internet="Un conocido le provee acceso wifi o plan de datos en celular, por algunas horas/días" 
      or c.como_accede_a_internet="Por datos de celular que recarga de forma interdiaria (prepago)" 
      or c.como_accede_a_internet="Ninguna de las anteriores"),
      (SELECT asignacion from finanzas_bono_conectividad where id_conectividad = 1), 0) as monto 
	  from comunicacion as c inner join derivacion_sectores as dersec on c.id_beneficiario = dersec.id_beneficiario
      where c.id_beneficiario = codbenficiario);
	  -- si existe el usuario devolvera su bono de conectividad
    END IF;
END |
DELIMITER ;




/*********************************
-- CREAR VISTAS
*********************************/
DROP VIEW IF EXISTS vista_finanzas_consulta;
CREATE VIEW `vista_finanzas_consulta` AS
	select fp.id_paquete,  fe1.estado, fp.fecha as 'fecha_envio', usu.nombre_usuario, 
    fe2.estado as 'estado_aprobacion', count(fpd.id_paquete_detalle) as 'numero_beneficiarios', fpa.observaciones
	from finanzas_paquete as fp inner join finanzas_paquete_aprobacion as fpa on fp.id_paquete = fpa.id_paquete
	inner join finanzas_estados as fe1 on fp.id_estado = fe1.id_estado
	inner join finanzas_estados as fe2 on fpa.id_estado = fe2.id_estado
	inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
    inner join usuarios as usu on fp.id_usuario = usu.id_usuario
	group by fp.id_paquete,  fe1.estado, fp.fecha , usu.nombre_usuario, fe2.estado, fpa.observaciones;
DELIMITER ;

DROP VIEW IF EXISTS vista_finanzas_paquetes_aprobados;
CREATE VIEW `vista_finanzas_paquetes_aprobados` AS
	select fp.id_paquete, fp.fecha as 'fecha_envio', fe2.estado as 'estado_aprobacion', fpa.fecha_aprobacion, 
    count(fpd.id_paquete_detalle) as 'numero_beneficiarios'
	from finanzas_paquete as fp inner join finanzas_paquete_aprobacion as fpa on fp.id_paquete = fpa.id_paquete
	inner join finanzas_estados as fe2 on fpa.id_estado = fe2.id_estado
	inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
    where fpa.id_estado = 3
    group by fp.id_paquete, fp.fecha, fe2.estado, fpa.fecha_aprobacion;
DELIMITER ;

DROP VIEW IF EXISTS vista_finanzas_consulta_aprobacion;
CREATE VIEW `vista_finanzas_consulta_aprobacion` AS
	select fp.id_paquete, fe1.estado, fp.fecha as 'fecha_envio', usu.nombre_usuario, 
    fe2.estado as 'estado_aprobacion', fpa.fecha_aprobacion, fpa.observaciones, 
    count(fpd.id_paquete_detalle) as 'numero_beneficiarios'
	from finanzas_paquete as fp inner join finanzas_paquete_aprobacion as fpa on fp.id_paquete = fpa.id_paquete
	inner join finanzas_estados as fe1 on fp.id_estado = fe1.id_estado
    inner join finanzas_estados as fe2 on fpa.id_estado = fe2.id_estado
	inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
    inner join usuarios as usu on fp.id_usuario = usu.id_usuario
	group by fp.id_paquete,fe1.estado,fp.fecha,usu.nombre_usuario,fe2.estado,fpa.fecha_aprobacion,fpa.observaciones;
DELIMITER ;

drop view IF EXISTS vista_finanzas_bono_conectividad;
CREATE VIEW `vista_finanzas_bono_conectividad` AS
	SELECT id_conectividad, asignacion
    FROM finanzas_bono_conectividad;
DELIMITER ;

drop view IF EXISTS vista_finanzas_bono_familiar;
CREATE VIEW `vista_finanzas_bono_familiar` AS
	SELECT id_familiar, asignacion
    FROM finanzas_bono_familiar;
DELIMITER ;

DROP VIEW IF EXISTS vista_finanzas_reporte_jetperu;
CREATE VIEW `vista_finanzas_reporte_jetperu` AS
	SELECT month(fecha) as mes, year(fecha) as anio, count(id_jetperu) as total_registro 
    FROM finanzas_reporte_jetperu    
	group by month(fecha), year(fecha) order by year(fecha) desc, month(fecha) desc ;
DELIMITER ;

drop view IF EXISTS vista_finanzas_periodos;
CREATE VIEW `vista_finanzas_periodos` AS
	SELECT id_periodos, mes, anio, periodo
    FROM finanzas_periodos;
DELIMITER ;

drop view IF EXISTS vista_finanzas_dea;
CREATE VIEW `vista_finanzas_dea` AS
	SELECT id_dea, dea, descripcion
    FROM finanzas_dea;
DELIMITER ;

drop view IF EXISTS vista_finanzas_sof;
CREATE VIEW `vista_finanzas_sof` AS
	SELECT id_sof, cod_sof, descripcion
    FROM finanzas_sof;
DELIMITER ;

drop view IF EXISTS vista_finanzas_costc;
CREATE VIEW `vista_finanzas_costc` AS
	SELECT id_costc, cod_costc, descripcion
    FROM finanzas_costc;
DELIMITER ;

SELECT @i := @i + 1 as contador, vf.mes, vf.anio, vf.total_registro
		FROM vista_finanzas_reporte_jetperu as vf cross join (select @i := 0) r;


/*********************************
-- CREAR STORED PROCEDURE
*********************************/

DROP PROCEDURE IF EXISTS `SP_Paquete_Finanzas`;
DELIMITER |
CREATE PROCEDURE `SP_Paquete_Finanzas`(in depa varchar(50))
BEGIN
	SELECT enc.fecha_encuesta, b.region_beneficiario, b.en_que_provincia, b.en_que_distrito, b.transit_settle, 
    b.primer_nombre, b.segundo_nombre, b.primer_apellido, b.segundo_apellido, 
    CASE b.documentos_fisico_original 
     WHEN 'Primero' THEN 'Cedula'
     WHEN 'Segundo' THEN b.tipo_identificacion
     WHEN 'Ninguno' THEN 'Cedula'
     ELSE 'Cedula'
	END AS 'Tipo de Identificacion', 
    CASE b.documentos_fisico_original
     WHEN 'Primero' THEN b.numero_cedula
     WHEN 'Segundo' THEN b.numero_identificacion
     WHEN 'Ninguno' THEN b.numero_cedula
     ELSE b.numero_cedula
	END AS 'Numero de identificacion', b.documentos_fisico_original,    
    c.cual_es_su_numero_whatsapp, c.cual_es_su_numero_recibir_sms, c.cual_es_su_direccion, 
    if(length(concat(i.nombre_1a,' ',i.nombre_1b))<3,0,1) +	if(length(concat(i.nombre_2a,' ',i.nombre_2b))<3,0,1) + 
    if(length(concat(i.nombre_3a,' ',i.nombre_3b))<3,0,1) +	if(length(concat(i.nombre_4a,' ',i.nombre_4b))<3,0,1) + 
    if(length(concat(i.nombre_5a,' ',i.nombre_5b))<3,0,1) +	if(length(concat(i.nombre_6a,' ',i.nombre_6b))<3,0,1) + 
    if(length(concat(i.nombre_7a,' ',i.nombre_7b))<3,0,1) + 1
	as 'numero de personas en la familia',
    c.tiene_los_siguientes_medios_comunicacion, c.como_accede_a_internet, 
    F_SINO(dersec.interesado_participar_nutricion) as interesado_participar_nutricion, 
    IF((c.laptop=1 or c.smartphone=1) and dersec.interesado_participar_nutricion=1 
    and (c.como_accede_a_internet="Por wifi  por horas" 
    or c.como_accede_a_internet="Un conocido le provee acceso wifi o plan de datos en celular, por algunas horas/días" 
    or c.como_accede_a_internet="Por datos de celular que recarga de forma interdiaria (prepago)" 
    or c.como_accede_a_internet="Ninguna de las anteriores"),"Si","No") as bono_nutricion,
    b.id_beneficiario
	FROM beneficiario b inner join comunicacion c on b.id_beneficiario = c.id_beneficiario
	inner join educacion e on b.id_beneficiario = e.id_beneficiario
	inner join encuesta enc on b.id_beneficiario = enc.id_beneficiario 
	inner join derivacion_sectores dersec on b.id_beneficiario = dersec.id_beneficiario 
	inner join integrantes i on b.id_beneficiario = i.id_beneficiario 
	inner join estatus est on b.id_beneficiario = est.id_beneficiario 
	inner join estados on estados.id_estado = est.id_estado 
	where estados.id_estado = 1 and b.region_beneficiario=depa and 
    b.id_beneficiario not in (select fpd.id_beneficiario from finanzas_paquete_detalle fpd
	inner join finanzas_paquete_aprobacion fpa on fpd.id_paquete = fpa.id_paquete
	where fpa.id_estado in (2,3)
    );
END |
DELIMITER ;


DROP PROCEDURE IF EXISTS `SP_Paquete_Finanzas_Insert`;
DELIMITER |
CREATE PROCEDURE `SP_Paquete_Finanzas_Insert`(in depa varchar(50), in usuario varchar(50), OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
    
	BEGIN     -- ERROR
		SET success = 0;
	ROLLBACK;
	END;
 
	START TRANSACTION;
    SET success = 2; -- CODIGO 2, NO EXISTEN REGISTROS PARA INSERTAR
	
    select @count_records := count(b.id_beneficiario) from beneficiario b 
	inner join estatus est on b.id_beneficiario = est.id_beneficiario 
	inner join estados on estados.id_estado = est.id_estado 
	where estados.id_estado = 1 and b.region_beneficiario = depa and 
    b.id_beneficiario not in (select fpd.id_beneficiario from finanzas_paquete_detalle fpd
	inner join finanzas_paquete_aprobacion fpa on fpd.id_paquete = fpa.id_paquete
	where fpa.id_estado in (2,3));
    
    SET @usuario = Codigo_User(usuario);
    
    IF @count_records > 0 AND @usuario > 0 THEN
		insert into finanzas_paquete(id_usuario) values (@usuario);
		
        SET @codigo_paquete := last_insert_id();
      
		insert into finanzas_paquete_detalle(id_paquete, id_beneficiario)  
		SELECT @codigo_paquete, b.id_beneficiario FROM beneficiario b 
		inner join estatus est on b.id_beneficiario = est.id_beneficiario 
		inner join estados on estados.id_estado = est.id_estado 
		where estados.id_estado = 1 and b.region_beneficiario = depa and 
		b.id_beneficiario not in (select fpd.id_beneficiario from finanzas_paquete_detalle fpd
		inner join finanzas_paquete_aprobacion fpa on fpd.id_paquete = fpa.id_paquete
		where fpa.id_estado in (2,3));
        
        /* estado = 2 (pendiente) */
        insert into finanzas_paquete_aprobacion(id_paquete, id_estado, id_usuario_envio) 
        values(@codigo_paquete, 2, @usuario);
        
		SET success = 1; -- CODIGO 1, SE INSERTARON REGISTROS
	END IF;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_reporte_finanzas_regiones`;
DELIMITER |
CREATE PROCEDURE `SP_reporte_finanzas_regiones`()
BEGIN
	select distinct(b.region_beneficiario) region
	FROM beneficiario b inner join estatus est on b.id_beneficiario = est.id_beneficiario 
	inner join estados on estados.id_estado = est.id_estado 
	where estados.id_estado = 1 and 
	b.id_beneficiario not in (select fpd.id_beneficiario from finanzas_paquete_detalle fpd
	inner join finanzas_paquete_aprobacion fpa on fpd.id_paquete = fpa.id_paquete
	where fpa.id_estado in (2,3) ) 
	order by b.region_beneficiario;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_reporte_finanzas_valorizacion`;
DELIMITER |
CREATE PROCEDURE `SP_reporte_finanzas_valorizacion`(in codpaquete int)
BEGIN
	select fpd.id_beneficiario, fp.id_paquete, fe.estado as estado_aprobacion,
	enc.fecha_encuesta, b.region_beneficiario, b.en_que_provincia, b.en_que_distrito, b.transit_settle, 
    b.primer_nombre, b.segundo_nombre, b.primer_apellido, b.segundo_apellido, 
    CASE b.documentos_fisico_original 
     WHEN 'Primero' THEN 'Cedula'
     WHEN 'Segundo' THEN b.tipo_identificacion
     WHEN 'Ninguno' THEN 'Cedula'
     ELSE 'Cedula'
	END AS 'Tipo de Identificacion', 
    CASE b.documentos_fisico_original
     WHEN 'Primero' THEN b.numero_cedula
     WHEN 'Segundo' THEN b.numero_identificacion
     WHEN 'Ninguno' THEN b.numero_cedula
     ELSE b.numero_cedula
	END AS 'Numero de identificacion', b.documentos_fisico_original, 
    c.cual_es_su_numero_whatsapp, c.cual_es_su_numero_recibir_sms, c.cual_es_su_direccion, 
    if(length(concat(i.nombre_1a,' ',i.nombre_1b))<3,0,1) +	if(length(concat(i.nombre_2a,' ',i.nombre_2b))<3,0,1) + 
    if(length(concat(i.nombre_3a,' ',i.nombre_3b))<3,0,1) +	if(length(concat(i.nombre_4a,' ',i.nombre_4b))<3,0,1) + 
    if(length(concat(i.nombre_5a,' ',i.nombre_5b))<3,0,1) +	if(length(concat(i.nombre_6a,' ',i.nombre_6b))<3,0,1) + 
    if(length(concat(i.nombre_7a,' ',i.nombre_7b))<3,0,1) + 1 as 'numero de personas en la familia',
    F_SINO(dersec.interesado_participar_nutricion) as interesado_participar_nutricion, 
    IF((c.laptop=1 or c.smartphone=1) and dersec.interesado_participar_nutricion=1 
    and (c.como_accede_a_internet="Por wifi  por horas" 
    or c.como_accede_a_internet="Un conocido le provee acceso wifi o plan de datos en celular, por algunas horas/días" 
    or c.como_accede_a_internet="Por datos de celular que recarga de forma interdiaria (prepago)" 
    or c.como_accede_a_internet="Ninguna de las anteriores"),"SI","NO") as bono_nutricion,
    c.como_accede_a_internet, c.tiene_los_siguientes_medios_comunicacion, 
    bono_conectividad(fpd.id_beneficiario) as bono_conectividad,
    curdate() as fecha_estadia_1, bono_familiar(fpd.id_beneficiario) AS 'importe transferido estadia_1',
    DATE_ADD(curdate(), INTERVAL 1 MONTH) as fecha_estadia_2, 
    bono_familiar(fpd.id_beneficiario) AS 'importe transferido estadia_2',
    DATE_ADD(curdate(), INTERVAL 2 MONTH) as fecha_estadia_3,
    bono_familiar(fpd.id_beneficiario) AS 'importe transferido estadia_3',
    DATE_ADD(curdate(), INTERVAL 3 MONTH) as fecha_estadia_4,
    bono_familiar(fpd.id_beneficiario) AS 'importe transferido estadia_4'
	from finanzas_paquete as fp inner join finanzas_paquete_aprobacion as fpa on fp.id_paquete = fpa.id_paquete
	inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
    inner join finanzas_estados as fe on fpa.id_estado = fe.id_estado
	inner join beneficiario b on fpd.id_beneficiario = b.id_beneficiario
	inner join comunicacion c on fpd.id_beneficiario = c.id_beneficiario
	inner join educacion e on fpd.id_beneficiario = e.id_beneficiario
	inner join encuesta enc on fpd.id_beneficiario = enc.id_beneficiario 
	inner join derivacion_sectores dersec on fpd.id_beneficiario = dersec.id_beneficiario 
	inner join integrantes i on fpd.id_beneficiario = i.id_beneficiario 
	inner join estatus est on b.id_beneficiario = est.id_beneficiario 
	inner join estados on estados.id_estado = est.id_estado 
	where fp.id_paquete = codpaquete;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_limpiar_stage_jetperu`;
DELIMITER |
CREATE PROCEDURE `SP_limpiar_stage_jetperu`(in usuario varchar(50), OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN
		SET success = 0; -- ERROR
	ROLLBACK;
	END;
	START TRANSACTION;
		delete from finanzas_stage_jetperu where nom_usuario = usuario;        
        SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_limpiar_stage_tpp`;
DELIMITER |
CREATE PROCEDURE `SP_limpiar_stage_tpp`(in usuario varchar(50), OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN
		SET success = 0; -- ERROR
	ROLLBACK;
	END;
	START TRANSACTION;
		delete from finanzas_stage_tpp where nom_usuario = usuario;        
        SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_limpiar_stage_ppto`;
DELIMITER |
CREATE PROCEDURE `SP_limpiar_stage_ppto`(OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN
		SET success = 0; -- ERROR
	ROLLBACK;
	END;
	START TRANSACTION;
		delete from finanzas_stage_ppto ;        
        SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_limpiar_stage_ppto_sof`;
DELIMITER |
CREATE PROCEDURE `SP_limpiar_stage_ppto_sof`(OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN
		SET success = 0; -- ERROR
	ROLLBACK;
	END;
	START TRANSACTION;
		delete from finanzas_stage_ppto_sof ;        
        SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_limpiar_stage_gastos`;
DELIMITER |
CREATE PROCEDURE `SP_limpiar_stage_gastos`(OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN
		SET success = 0; -- ERROR
	ROLLBACK;
	END;
	START TRANSACTION;
		delete from finanzas_stage_gasto ;        
        SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_finanzas_clean_jetperu`;
DELIMITER |
CREATE PROCEDURE `SP_finanzas_clean_jetperu`(OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
	ROLLBACK;
	END;
 
	START TRANSACTION;
	UPDATE finanzas_stage_jetperu SET 
    fecha=TRIM(fecha), nro_planilla=TRIM(nro_planilla), nro_orden=TRIM(nro_orden), region=TRIM(region), 
    apellidos_beneficiario=TRIM(apellidos_beneficiario), nombres_beneficario=TRIM(nombres_beneficario), 
    tipo_documento=TRIM(tipo_documento), documento_identidad=TRIM(documento_identidad), monto=TRIM(monto),
    estado=TRIM(estado), lugar_pago=TRIM(lugar_pago), fecha_pago=TRIM(fecha_pago), hora_pago=TRIM(hora_pago),
    telefono_benef=TRIM(telefono_benef), codigo_interno=TRIM(codigo_interno), codSeguimiento=TRIM(codSeguimiento), 
    nro_tarjeta=TRIM(nro_tarjeta), tipo_transferencia=TRIM(tipo_transferencia), donante=TRIM(donante),
    -- fecha = user_regex_replace('[.]', '', fecha), fecha_pago = user_regex_replace('[.]', '', fecha_pago),
    fecha_pago = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(fecha_pago, CHAR(10), ''), CHAR(13), ''), CHAR(9), ''), CHAR(160), ''),CHAR(32), ''),
    fecha = REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(fecha, CHAR(10), ''), CHAR(13), ''), CHAR(9), ''), CHAR(160), ''),CHAR(32), ''),
    fecha = SUBSTRING(fecha, 2, 10), fecha_pago = SUBSTRING(fecha_pago, 2, 10), monto = REPLACE(monto,',', '');
    SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_finanzas_clean_tpp`;
DELIMITER |
CREATE PROCEDURE `SP_finanzas_clean_tpp`(OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
	ROLLBACK;
	END;
 
	START TRANSACTION;
	UPDATE finanzas_stage_tpp SET 
    codigo_seguimiento=TRIM(codigo_seguimiento), nro_tarjeta=TRIM(nro_tarjeta), tipo_documento=TRIM(tipo_documento), 
    nro_documento=TRIM(nro_documento), nombres_apellidos=TRIM(nombres_apellidos), sucursal=TRIM(sucursal), 
    estado=TRIM(estado), saldo=TRIM(saldo), saldo = REPLACE(saldo,',', '');
    SET success = 1;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_migrar_data_jetperu`;
DELIMITER |
CREATE PROCEDURE `SP_migrar_data_jetperu`(IN usuario varchar(50), OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
		ROLLBACK;
	END;
 
	START TRANSACTION;
     SET success = 2; -- CODIGO 2, NO EXISTEN REGISTROS PARA INSERTAR
     select @count_records := count(id_stage_jetperu) from finanzas_stage_jetperu where nom_usuario = usuario;
     SET @usuario = Codigo_User(usuario);
      IF @count_records > 0 AND @usuario > 0 THEN
	    INSERT INTO finanzas_reporte_jetperu ( fecha, nro_planilla, nro_orden, region, apellidos_beneficiario, 
        nombres_beneficario, tipo_documento, documento_identidad, monto, estado, lugar_pago, fecha_pago, hora_pago, 
        telefono_benef, codigo_interno, codSeguimiento, nro_tarjeta, tipo_transferencia, donante, nom_usuario) 
        SELECT IF (STR_TO_DATE(fecha, GET_FORMAT(DATE, 'EUR')) IS NULL, null, 
        STR_TO_DATE(fecha, GET_FORMAT(DATE, 'EUR'))) as fecha, nro_planilla, nro_orden, region, apellidos_beneficiario, 
        nombres_beneficario, tipo_documento, documento_identidad, cast(monto as decimal(6,2)) as monto, estado, lugar_pago, 
        IF (STR_TO_DATE(fecha_pago, GET_FORMAT(DATE, 'EUR')) IS NULL, null, 
        STR_TO_DATE(fecha_pago, GET_FORMAT(DATE, 'EUR'))) as fecha_pago,
        IF (TIME_FORMAT(hora_pago, '%T') IS NULL, null, TIME_FORMAT(hora_pago, '%T')) as hora, 
        telefono_benef, codigo_interno, codSeguimiento, nro_tarjeta, tipo_transferencia, donante, nom_usuario
        from finanzas_stage_jetperu where nom_usuario = usuario;	
        delete from finanzas_stage_jetperu where nom_usuario = usuario;
        SET success = 1; -- CODIGO 1, SE INSERTARON REGISTROS
      END IF;
    COMMIT;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_migrar_data_tpp`;
DELIMITER |
CREATE PROCEDURE `SP_migrar_data_tpp`(IN usuario varchar(50), OUT success INT)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN     -- ERROR
		SET success = 0;
		ROLLBACK;
	END;
 
	START TRANSACTION;
     SET success = 2; -- CODIGO 2, NO EXISTEN REGISTROS PARA INSERTAR
     select @count_records := count(id_stage_tpp) from finanzas_stage_tpp where nom_usuario = usuario;
     SET @usuario = Codigo_User(usuario);
      IF @count_records > 0 AND @usuario > 0 THEN
	    INSERT INTO finanzas_reporte_tpp ( codigo_seguimiento, nro_tarjeta, tipo_documento, nro_documento, 
        nombres_apellidos, sucursal, estado, saldo, nom_usuario) SELECT codigo_seguimiento, nro_tarjeta, 
        tipo_documento, nro_documento, nombres_apellidos, sucursal, estado, cast(saldo as decimal(6,2)), nom_usuario
        from finanzas_stage_tpp where nom_usuario = usuario;	
        delete from finanzas_stage_tpp where nom_usuario = usuario;
        SET success = 1; -- CODIGO 1, SE INSERTARON REGISTROS
      END IF;
    COMMIT;
END |
DELIMITER ;

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

DROP PROCEDURE IF EXISTS `SP_reporte_recarga_tpp`;
DELIMITER |
CREATE PROCEDURE `SP_reporte_recarga_tpp`(in codpaquete int)
BEGIN
	select CASE b.documentos_fisico_original
     WHEN 'Primero' THEN b.numero_cedula
     WHEN 'Segundo' THEN b.numero_identificacion
     WHEN 'Ninguno' THEN b.numero_cedula
     ELSE b.numero_cedula
	END AS 'numero_documento', b.primer_apellido as apepat, b.segundo_apellido as apemat, 
    concat(b.primer_nombre, ' ', b.segundo_nombre) as nombres, null as Numero_de_Tarjeta,
    bono_familiar(fpd.id_beneficiario) as monto, null as Numero_de_Operacion
	from finanzas_paquete as fp inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
	inner join beneficiario b on fpd.id_beneficiario = b.id_beneficiario
	where fpd.id_paquete = codpaquete;
END |
DELIMITER ;

DROP PROCEDURE IF EXISTS `SP_reporte_recarga_tpp_mas_bono`;
DELIMITER |
CREATE PROCEDURE `SP_reporte_recarga_tpp_mas_bono`(in codpaquete int)
BEGIN
	select CASE b.documentos_fisico_original
     WHEN 'Primero' THEN b.numero_cedula
     WHEN 'Segundo' THEN b.numero_identificacion
     WHEN 'Ninguno' THEN b.numero_cedula
     ELSE b.numero_cedula
	END AS 'numero_documento', b.primer_apellido as apepat, b.segundo_apellido as apemat, 
    concat(b.primer_nombre, ' ', b.segundo_nombre) as nombres, null as Numero_de_Tarjeta,
    bono_familiar(fpd.id_beneficiario) + bono_conectividad(fpd.id_beneficiario) as monto, null as Numero_de_Operacion
	from finanzas_paquete as fp inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
	inner join beneficiario b on fpd.id_beneficiario = b.id_beneficiario
	where fpd.id_paquete = codpaquete;
END |
DELIMITER ;



DROP PROCEDURE IF EXISTS `SP_reporte_recarga_jetperu_mas_bono`;
DELIMITER |
CREATE PROCEDURE `SP_reporte_recarga_jetperu_mas_bono`(in codpaquete int)
BEGIN
	select null as Refeplanilla, null as agencia, null as orden, curdate() as fecha,	    
    bono_familiar(fpd.id_beneficiario) + bono_conectividad(fpd.id_beneficiario) as monto,
    'PEN' as moneda, 'O' as canalpago, '010-020' as	agenciadestino, 'SAVE' as apepatremite,
	'THE CHILDREN' as apematremite, 'INTERNATIONAL' as nombremite, '5 - Ruc' as	tipoidremite,
	20547444125 as nroidremite, 'PER' as nacionremite, 'PER' as resideremite, null as tlffijoremite,
	null as tlfmovilremite, 'AV JAVIER PRADO OESTE 890' as domicremite, 'SAN ISIDRO' as	ciudadremite,
	'LIMA' as estadoremite, b.primer_apellido as apepatbenef, b.segundo_apellido as apematbenef, 
    concat(b.primer_nombre, ' ', b.segundo_nombre) as nombbenef, 
    CASE b.documentos_fisico_original 
     WHEN 'Primero' THEN '8 - Cedula'
     WHEN 'Segundo' THEN 
		CASE b.tipo_identificacion
			WHEN 'DNI' THEN '1 - DNI'
            WHEN 'CPP' THEN '3 - CPP'
            WHEN 'Carnet de Extranjeria' THEN '4 - Carnet de Extranjeria'
            WHEN 'Pasaporte' THEN '6 - Pasaporte'
            WHEN 'PTP' THEN '7 - PTP'
            WHEN 'Cedula' THEN '8 - Cedula'
            WHEN 'Carnet de Refugiado' THEN '9 - Carné de Refugiado'
            ELSE '2 - Otro'
		END 
     WHEN 'Ninguno' THEN '8 - Cedula'
     ELSE '8 - Cedula'
	END AS tipoidbenef, 
    CASE b.documentos_fisico_original
     WHEN 'Primero' THEN b.numero_cedula
     WHEN 'Segundo' THEN b.numero_identificacion
     WHEN 'Ninguno' THEN b.numero_cedula
     ELSE b.numero_cedula
	END AS nroidbenef, 
    null as nacionbenef, null as 'residebenef', c.cual_es_su_numero_whatsapp as tlffijobenef, 
    c.cual_es_su_numero_recibir_sms as tlfmovilbenef, c.cual_es_su_direccion as domicbenef,
    b.en_que_provincia as ciudadbenef,	b.en_que_provincia as estadobenef,
    null as nombrebanco, null as cuentabanco, null as tipocuenta, null as emailremite, null as emailbenef,
	null as codint, null as	codseguim, null as numtjt
	from finanzas_paquete as fp inner join finanzas_paquete_aprobacion as fpa on fp.id_paquete = fpa.id_paquete
	inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
    inner join finanzas_estados as fe on fpa.id_estado = fe.id_estado
	inner join beneficiario b on fpd.id_beneficiario = b.id_beneficiario
	inner join comunicacion c on fpd.id_beneficiario = c.id_beneficiario
    inner join integrantes i on fpd.id_beneficiario = i.id_beneficiario 
	where fpa.id_paquete = codpaquete;
END |
DELIMITER ;


DROP PROCEDURE IF EXISTS `SP_reporte_recarga_jetperu`;
DELIMITER |
CREATE PROCEDURE `SP_reporte_recarga_jetperu`(in codpaquete int)
BEGIN
	DECLARE exit handler for sqlexception
	BEGIN
     -- ERROR
	ROLLBACK;
	END;
    
	START TRANSACTION;    
	 select null as Refeplanilla, null as agencia, null as orden, curdate() as fecha,	    
     bono_familiar(fpd.id_beneficiario) as monto,
     'PEN' as moneda, 'O' as canalpago, '010-020' as	agenciadestino, 'SAVE' as apepatremite,
	 'THE CHILDREN' as apematremite, 'INTERNATIONAL' as nombremite, '5 - Ruc' as	tipoidremite,
	 20547444125 as nroidremite, 'PER' as nacionremite, 'PER' as resideremite, null as tlffijoremite,
	 null as tlfmovilremite, 'AV JAVIER PRADO OESTE 890' as domicremite, 'SAN ISIDRO' as	ciudadremite,
	 'LIMA' as estadoremite, b.primer_apellido as apepatbenef, b.segundo_apellido as apematbenef, 
     concat(b.primer_nombre, ' ', b.segundo_nombre) as nombbenef, 
     CASE b.documentos_fisico_original 
      WHEN 'Primero' THEN '8 - Cedula'
      WHEN 'Segundo' THEN 
		case b.tipo_identificacion
			when 'DNI' then '1 - DNI'
            when 'CPP' then '3 - CPP'
            when 'Carnet de Extranjeria' then '4 - Carnet de Extranjeria'
            when 'Pasaporte' then '6 - Pasaporte'
            when 'PTP' then '7 - PTP'
            when 'Cedula' then '8 - Cedula'
            when 'Carnet de Refugiado' then '9 - Carné de Refugiado'
            else '2 - Otro'
		end
      WHEN 'Ninguno' THEN '8 - Cedula'
     ELSE '8 - Cedula'
	 END AS 'tipoidbenef', 
     CASE b.documentos_fisico_original
      WHEN 'Primero' THEN b.numero_cedula
      WHEN 'Segundo' THEN b.numero_identificacion
      WHEN 'Ninguno' THEN b.numero_cedula
      ELSE b.numero_cedula
	 END AS 'nroidbenef', 
     null as nacionbenef, null as 'residebenef', c.cual_es_su_numero_whatsapp as tlffijobenef, 
     c.cual_es_su_numero_recibir_sms as tlfmovilbenef, c.cual_es_su_direccion as domicbenef,
     b.en_que_provincia as ciudadbenef,	b.en_que_provincia as estadobenef, null as nombrebanco, 
     null as cuentabanco, null as tipocuenta, null as emailremite, null as emailbenef,
	 null as codint, null as codseguim, null as numtjt
	 from finanzas_paquete as fp inner join finanzas_paquete_aprobacion as fpa on fp.id_paquete = fpa.id_paquete
	 inner join finanzas_paquete_detalle as fpd on fp.id_paquete = fpd.id_paquete
     inner join finanzas_estados as fe on fpa.id_estado = fe.id_estado
	 inner join beneficiario b on fpd.id_beneficiario = b.id_beneficiario
	 inner join comunicacion c on fpd.id_beneficiario = c.id_beneficiario
     inner join integrantes i on fpd.id_beneficiario = i.id_beneficiario 
	 where fpa.id_paquete = codpaquete;
	COMMIT;
END |
DELIMITER ;




select * from vista_finanzas_paquetes_aprobados;
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
SELECT * FROM vista_finanzas_consulta ;
SELECT * FROM vista_estatus;
select * from vista_finanzas_consulta_aprobacion;

call SP_reporte_finanzas_valorizacion(3)

