CREATE DATABASE savethec_finanzas CHARACTER SET utf8mb4  COLLATE utf8mb4_spanish_ci;

SHOW CHARACTER SET LIKE 'utf%';
SHOW COLLATION WHERE Charset = 'utf8mb4';
DESCRIBE finanzas_paquete_aprobacion;
SHOW TABLE STATUS where name like 'finanzas_paquete_aprobacion';

SELECT CURRENT_DATE();

/*********************************
-- ELIMINAR TABLAS 
*********************************/

DROP TABLE if exists finanzas_periodos;
DROP TABLE if exists finanzas_paquete_detalle;
DROP TABLE if exists finanzas_proveedor_pago;
DROP TABLE if exists finanzas_paquete_aprobacion;
DROP TABLE if exists finanzas_paquete;
DROP TABLE if exists finanzas_estados;
DROP TABLE if exists finanzas_bono_conectividad;
DROP TABLE if exists finanzas_bono_familiar;
DROP TABLE if exists finanzas_tipo_documento;
DROP TABLE if exists finanzas_stage_jetperu;
DROP TABLE if exists finanzas_stage_tpp;
DROP TABLE if exists finanzas_reporte_jetperu;
DROP TABLE if exists finanzas_reporte_tpp;
DROP TABLE if exists finanzas_stage_estado_financiero;
DROP TABLE if exists finanzas_estado_financiero;
DROP TABLE if exists finanzas_stage_ppto;
DROP TABLE if exists finanzas_stage_gasto;
DROP TABLE if exists finanzas_dea;
DROP TABLE if exists finanzas_costc;
DROP TABLE if exists finanzas_sof;
DROP TABLE if exists finanzas_stage_ppto_sof
/*********************************
-- CREACION DE TABLAS 
*********************************/

CREATE TABLE finanzas_periodos (
	id_periodos	integer NOT NULL AUTO_INCREMENT,
	mes			varchar(2) NOT NULL,
	anio		varchar(4) NOT NULL,
	periodo		varchar(10) NOT NULL default(concat(anio,mes)),
    PRIMARY KEY (id_periodos)
) DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
ALTER TABLE finanzas_periodos ADD CONSTRAINT const_periodos UNIQUE (mes,anio);


/*
CREATE TRIGGER asigna_periodo BEFORE INSERT ON finanzas_periodos
FOR EACH ROW 
BEGIN
  SET NEW.periodo = new.mes;
END;
*/

CREATE TABLE finanzas_paquete (
	id_paquete		INTEGER NOT NULL AUTO_INCREMENT,
	fecha			DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	id_estado		INTEGER NOT NULL DEFAULT 1,
	id_usuario		INTEGER NOT NULL,
    PRIMARY KEY (id_paquete)
) DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE finanzas_paquete_aprobacion (
	id_paquete_aprobacion	INTEGER NOT NULL AUTO_INCREMENT,
	id_paquete				INTEGER NOT NULL,
	id_estado				INTEGER NOT NULL,
	fecha_aprobacion		DATETIME NOT NULL,
    observaciones			VARCHAR(200) NULL,
	id_usuario_envio		INTEGER NULL,
    id_usuario_aprobacion	INTEGER NULL,
    PRIMARY KEY (id_paquete_aprobacion)
) DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE finanzas_paquete_detalle (
	id_paquete_detalle   INTEGER NOT NULL AUTO_INCREMENT,
	id_paquete           INTEGER NOT NULL,
	id_beneficiario      INTEGER NOT NULL,
    PRIMARY KEY (id_paquete_detalle)
) DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE finanzas_proveedor_pago (
	id_proveedor_pago    	INTEGER NOT NULL AUTO_INCREMENT,
	id_paquete_aprobacion 	INTEGER NOT NULL,
	fecha                	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	id_estado            	INTEGER NOT NULL,
	id_usuario           	INTEGER NOT NULL,
    PRIMARY KEY (id_proveedor_pago)
) DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE finanzas_estados
(	id_estado	INTEGER NOT NULL AUTO_INCREMENT,
	estado		VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_estado)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_bono_conectividad
(	id_conectividad	INTEGER NOT NULL AUTO_INCREMENT,
	asignacion		decimal(5,2) NOT NULL,
    PRIMARY KEY (id_conectividad)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_bono_familiar
(	id_familiar		INTEGER NOT NULL AUTO_INCREMENT,
	asignacion		decimal(6,2) NOT NULL,
    PRIMARY KEY (id_familiar)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_tipo_documento
(	id_tipo_documento	INTEGER NOT NULL AUTO_INCREMENT,
	documento			VARCHAR(50) NOT NULL,
    PRIMARY KEY (id_tipo_documento)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_stage_jetperu
(	id_stage_jetperu       	INTEGER NOT NULL AUTO_INCREMENT,
	fecha	            	VARCHAR(50) NULL,
    nro_planilla            VARCHAR(50) NULL,
    nro_orden            	VARCHAR(50) NULL,
	region            		VARCHAR(50) NULL,
	apellidos_beneficiario	VARCHAR(50) NULL,
	nombres_beneficario		VARCHAR(50) NULL,
	tipo_documento			VARCHAR(50) NULL,
	documento_identidad   	VARCHAR(50) NULL,
	monto           		VARCHAR(50) NULL,
	estado               	VARCHAR(50) NULL,
	lugar_pago 				VARCHAR(50) NULL,
	fecha_pago 				VARCHAR(50) NULL,
	hora_pago            	VARCHAR(50) NULL,
	telefono_benef          VARCHAR(50) NULL,
	codigo_interno          VARCHAR(50) NULL,
	codSeguimiento          VARCHAR(50) NULL,
	nro_tarjeta             VARCHAR(50) NULL,
	tipo_transferencia   	VARCHAR(50) NULL,
	donante           		VARCHAR(50) NULL,
    nom_usuario           	VARCHAR(50) NULL,
    PRIMARY KEY (id_stage_jetperu)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_reporte_jetperu
(	id_jetperu				INT NOT NULL AUTO_INCREMENT,
	fecha	            	date NULL,
    nro_planilla            VARCHAR(50) NULL,
    nro_orden            	INT NULL,
	region            		VARCHAR(50) NULL,
	apellidos_beneficiario	VARCHAR(50) NULL,
	nombres_beneficario		VARCHAR(50) NULL,
	tipo_documento			VARCHAR(50) NULL,
	documento_identidad   	VARCHAR(50) NULL,
	monto           		DECIMAL(6,2) NULL,
	estado               	VARCHAR(50) NULL,
	lugar_pago 				VARCHAR(50) NULL,
	fecha_pago 				DATE NULL,
	hora_pago            	TIME NULL,
	telefono_benef          VARCHAR(50) NULL,
	codigo_interno          INT NULL,
	codSeguimiento          VARCHAR(50) NULL,
	nro_tarjeta             VARCHAR(50) NULL,
	tipo_transferencia   	VARCHAR(50) NULL,
	donante           		VARCHAR(50) NULL,
    nom_usuario           	VARCHAR(50) NULL,
    PRIMARY KEY (id_jetperu)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_stage_tpp
(	id_stage_tpp       		INTEGER NOT NULL AUTO_INCREMENT,
	codigo_seguimiento     	VARCHAR(50) NULL,
    nro_tarjeta				VARCHAR(50) NULL,
    tipo_documento			VARCHAR(50) NULL,
    nro_documento			VARCHAR(50) NULL,
	nombres_apellidos		VARCHAR(50) NULL,
    sucursal               	VARCHAR(50) NULL,
	estado               	VARCHAR(50) NULL,
	saldo           		VARCHAR(50) NULL,
    nom_usuario				VARCHAR(50) NULL,
    PRIMARY KEY (id_stage_tpp)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_reporte_tpp
(	id_tpp       		INTEGER NOT NULL AUTO_INCREMENT,
	codigo_seguimiento	VARCHAR(50) NULL,
    nro_tarjeta			VARCHAR(50) NULL,
    tipo_documento		VARCHAR(50) NULL,
    nro_documento		VARCHAR(50) NULL,
	nombres_apellidos	VARCHAR(50) NULL,
    sucursal			VARCHAR(50) NULL,
	estado				VARCHAR(50) NULL,
	saldo				DECIMAL(6,2) NULL,
    nom_usuario			VARCHAR(50) NULL,
    PRIMARY KEY (id_tpp)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_stage_estado_financiero
(	id_stage_estado     INTEGER NOT NULL AUTO_INCREMENT,
	account_			VARCHAR(50) NULL,
    period            	VARCHAR(50) NULL,
    trans_date         	VARCHAR(50) NULL,
	usd_amount			VARCHAR(50) NULL,
	cur					VARCHAR(50) NULL,
	trans_cur_amt		VARCHAR(50) NULL,
	donor_currency		VARCHAR(50) NULL,
	donor_cur_amount	VARCHAR(50) NULL,
	costc	       		VARCHAR(50) NULL,
	project           	VARCHAR(50) NULL,
	sof					VARCHAR(50) NULL,
	dea					VARCHAR(50) NULL,
	dea_t            	VARCHAR(50) NULL,
	text_		        VARCHAR(510) NULL,
	trans_no			VARCHAR(50) NULL,
	analysis_type_t     VARCHAR(50) NULL,
	analysis			VARCHAR(50) NULL,
	analysis_t			VARCHAR(50) NULL,
    PRIMARY KEY (id_stage_estado)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_estado_financiero
(	id_estado_financiero	INTEGER NOT NULL AUTO_INCREMENT,
	account_		integer NULL,	
    period			integer NULL,	
    trans_date		date NULL,
	usd_amount		decimal(8,2) NULL,	
    cur				VARCHAR(50) NULL,	
    trans_cur_amt	decimal(8,2) NULL,
	donor_currency	VARCHAR(50) NULL,	
    donor_cur_amount	decimal(8,2) NULL,	
    costc			integer NULL,
	project			integer NULL,	
    sof				integer NULL,	
    dea				VARCHAR(50) NULL,	
    dea_t			VARCHAR(255) NULL,
	text_			VARCHAR(510) NULL,	
    trans_no		integer NULL,	
    analysis_type_t	VARCHAR(50) NULL,
	analysis		VARCHAR(50) NULL,	
    analysis_t		VARCHAR(255) NULL,
    PRIMARY KEY (id_estado_financiero)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_stage_ppto
(	id_stage_ppto	INTEGER NOT NULL AUTO_INCREMENT,
	dea				VARCHAR(50) NULL,
    anio			VARCHAR(50) NULL,
    mes				VARCHAR(50) NULL,
    periodo			VARCHAR(50) NULL,
    monto			VARCHAR(50) NULL,
    PRIMARY KEY (id_stage_ppto)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_stage_ppto_sof
(	id_stage_ppto_sof	INTEGER NOT NULL AUTO_INCREMENT,
	ccent			VARCHAR(50) NULL,
    sof				VARCHAR(50) NULL,
    dea				VARCHAR(50) NULL,
    anio			VARCHAR(50) NULL,
    mes				VARCHAR(50) NULL,
    periodo			VARCHAR(50) NULL,
    monto			VARCHAR(50) NULL,
    PRIMARY KEY (id_stage_ppto_sof)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_stage_gasto
(	id_stage_gasto	INTEGER NOT NULL AUTO_INCREMENT,
	dea				VARCHAR(50) NULL,
    anio			VARCHAR(50) NULL,
    mes				VARCHAR(50) NULL,
    periodo			VARCHAR(50) NULL,
    monto			VARCHAR(50) NULL,
    PRIMARY KEY (id_stage_gasto)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_dea
(	id_dea		INTEGER NOT NULL AUTO_INCREMENT,
	dea			VARCHAR(50) NULL,
    descripcion	VARCHAR(255) NULL,
    PRIMARY KEY (id_dea)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  

CREATE TABLE finanzas_sof
(	id_sof		INTEGER NOT NULL AUTO_INCREMENT,
	cod_sof		VARCHAR(10) NOT NULL,
    descripcion	VARCHAR(255) NULL,
    PRIMARY KEY (id_sof)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  
ALTER TABLE finanzas_sof ADD CONSTRAINT unique_cod_sof UNIQUE (cod_sof);

CREATE TABLE finanzas_costc
(	id_costc	INTEGER NOT NULL AUTO_INCREMENT,
	cod_costc	VARCHAR(8) NOT NULL,
    descripcion	VARCHAR(255) NULL,
	PRIMARY KEY (id_costc)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;  
ALTER TABLE finanzas_costc ADD CONSTRAINT unique_cod_costc UNIQUE (cod_costc);

/*********************************
-- CREACION DE LLAVES FORANEAS 
*********************************/
ALTER TABLE finanzas_paquete_aprobacion ADD FOREIGN KEY R_4 (id_paquete) REFERENCES finanzas_paquete (id_paquete);
ALTER TABLE finanzas_paquete_aprobacion ADD FOREIGN KEY R_2 (id_usuario_envio) REFERENCES usuarios (id_usuario);
ALTER TABLE finanzas_paquete_aprobacion ADD FOREIGN KEY R_7 (id_usuario_aprobacion) REFERENCES usuarios (id_usuario);
ALTER TABLE finanzas_paquete_aprobacion ADD FOREIGN KEY R_8 (id_estado) REFERENCES finanzas_estados (id_estado);

ALTER TABLE finanzas_paquete ADD FOREIGN KEY R_1 (id_usuario) REFERENCES usuarios (id_usuario);
ALTER TABLE finanzas_paquete_detalle ADD FOREIGN KEY R_3 (id_paquete) REFERENCES finanzas_paquete (id_paquete);
ALTER TABLE finanzas_paquete ADD FOREIGN KEY R_9 (id_estado) REFERENCES finanzas_estados (id_estado);

ALTER TABLE finanzas_proveedor_pago ADD FOREIGN KEY R_6 (id_paquete_aprobacion) REFERENCES finanzas_paquete_aprobacion (id_paquete_aprobacion);
ALTER TABLE finanzas_proveedor_pago ADD FOREIGN KEY R_5 (id_usuario) REFERENCES usuarios (id_usuario);




/*********************************
-- INSERTANDO DATOS INICIALES 
*********************************/

insert into finanzas_estados (estado) values ('Enviado');
insert into finanzas_estados (estado) values ('Pendiente');
insert into finanzas_estados (estado) values ('Aprobado');
insert into finanzas_estados (estado) values ('Rechazado');

insert into finanzas_bono_conectividad (asignacion) values (120.25);

insert into finanzas_bono_familiar (asignacion) values (300.25),(2550.50),(900.50),(1300.50),(5300.50),(9300.50);
insert into finanzas_tipo_documento (documento) 
values ('DNI'),('Otro'),('CPP'),('Carnet Extranjeria'),('Ruc'),('Pasaporte'),('PTP'),('Cedula'),('Carné de Refugiado');

insert into finanzas_periodos (mes, anio) values ('01','2021'),('02','2021'),('03','2021'),('04','2021'),('05','2021'),
('06','2021'),('07','2021'),('08','2021'),('09','2021'),('10','2021'),('11','2021'),('12','2021'),('01','2022'),
('02','2022'),('03','2022'),('04','2022'),('05','2022'),('06','2022'),('07','2022'),('08','2022'),('09','2022'),
('10','2022'),('11','2022'),('12','2022');

insert into finanzas_dea (dea, descripcion) values ('1051151','Country Support Staff'),
('1051152','National Staff - Fringe'),('1051153','Country support Staff - Fringe'),
('1051154','National Travels - Airfares'),('1051155','National Travels Support Staff - Airfares'),
('1051156','Local transportation'),('1051157','Local transportation - Support Staff'),('1051158','Per Diem'),
('1051159','Per Diem - Support Staff'),('1051160','Items with a unit cost of less than $5,000 Laptop/Computers'),
('1051161','Items with a unit cost of less than $5,000 Phones'),
('1051162','Items with a unit cost of less than $5,000 Tablets'),
('1051163','Items with a unit cost of less than $5,000 Printers'),
('1051164','Items with a unit cost of less than $5,000 Accessories (headphones, mouse, others)'),
('1051165','Items with a unit cost of less than $5,000 Basic Licenses (antivirus, office, security)'),
('1051166','Items with a unit cost of less than $5,000 Other Licenses (Creative Cloud)'),
('1051167','Consultancy team psychological support - staff'),
('1051168','Consultant for Lessons learned & Systematization'),
('1051169','Consultant Final Report'),('1051170','Baseline and endline evaluation'),
('1051171','Consultant to Update virtual platform'),
('1051172','Consultancy Child safeguarding'),('1051173','Office Supplies'),('1051174','Computer Supplies'),
('1051175','Start-up supplies'),('1051176','Communications (telephone, fax, etc.)'),
('1051177','Postage/Parcel Delivery'),('1051178','Building maintenance & repair'),('1051179','Translation'),
('1051180','Subscription (bitly, wsp, zoom, sms)'),('1051181','Legal Fees'),('1051182','Advertising'),
('1051183','Staff development- national and regional team'),('1051184','Branding'),('1051185','Premises'),
('1051186','Safety & Security (EPP´S)'),('1051187','Transit Package (T)'),
('1051188','Settlement packages (E1, E2, E3)'),('1051189','Transfer Fees'),
('1051190','Staff transport - Distribution days'),('1051191','Rent cost nutrición'),
('1051192','Communication materials for the migrant (print materials)'),
('1051193','Food assistance communication materials for the migrant, in-transit population (Kits for migrants)'),
('1051194','Social and behavior change communications (messaging)'),
('1051195','Capacity-building for local institutional actors (contests, communicational material for ollas communes, demonstrative sessions)'),
('1051196','Training and support to community health workers/promoters in MIYCN-E in host communities.'),
('1051197','Group sensitization sessions to promote recommended MIYCN-E practices (Communication materials, nutrition kits, and raffles to be used to promote participation)'),
('1051198','Training and support to PLW (Counselling for women in reproductive age)'),
('1051199','Communication strategy for sensitizing immigrants on the importance of maintaining good nutrition standards (Messaging via whatsapp and social media, communication material)'),
('1051200','Spaces to promote breastfeeding practices (Lactawawitas)'),
('1051201','Connectivity voucher for nutrition beneficiaries'),
('1051202','Capacity strengthening of SC staff in MIYCN-E'),('1051203','Staff transport'),('1051204','Rent cost cash'),
('1051205','Digital platforms and communications (license and fees for Zoom, Whatsapp)'),
('1051206','Nutrition communication materials for the migrant, in-transit population (Kits for babies)'),
('1051207','Workshops'),('1051208','Call center'),('1051111-1051150','National Staff'),
('C84008179','Country Shared Costs - Other'),('F84008179','Country Shared Costs - Non salary benefits'),
('N84008179','Country Shared Costs - National salaries'),('P84008179','Country Shared Costs - Premise costs'),
('T84008179','Country Shared Costs - Travel & Lodging'),
('V84008179','Country Shared Costs – Vehicle & transport costs');

insert into finanzas_sof (cod_sof, descripcion) 
values ('84008179','BHA Migrantes'),('84008177','BPRM'),('99400764','GIZ'),('84006612','GIRD MRNO BHA'),('84008198
','CHLOE'),('84008349','Más Diversidad (ECW)'),('99701132','Humanitarian Fund');

insert into finanzas_costc (cod_costc, descripcion) 
values ('60400','Country Office Peru'),('60412','Field Office Huancavelica'),('60411','Peru Programme costs'),
('60405','Field Office Lambayeque'),('60406','Field Office Lima NorEste'),('60407','Field Office Arequipa'),
('60408','Field Office Piura'),('60410','Field Office Libertad'),('60413','Field Office Lima Norte GRD');


/***********************************************
-- REINICIAR EL AUTO INCREMENTE DE LAS TABLAS 
************************************************/
ALTER TABLE finanzas_periodos AUTO_INCREMENT = 1;
truncate table finanzas_periodos ;
