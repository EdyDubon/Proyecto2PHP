create database proyecto2;

use proyecto2;

create table tb_usuarios(
	id_usuario int auto_increment,
	nombre_usuario varchar(50) not null,
	nombre_persona varchar(50) not null,
	passwd_usuario varchar(100) not null default 'abc12345',
	is_look varchar(10) not null default 'activa',
	is_admin char not null default '0',
	primary key (id_usuario)
);
insert into tb_usuarios (nombre_usuario, nombre_persona, passwd_usuario, is_look, is_admin) values('admin', 'Administrador sistema', 'desarrolloweb', 'activa', '1');


create table tb_cuentas_por_usuario(
	id_cuenta varchar(12) not null,
	id_usuario int not null,
	nombre_cuenta varchar(50) not null default 'sin alias',
	dpi varchar(15) not null default '000000000000000',
	saldo decimal(10,2),
	primary key(id_cuenta),
	foreign key (id_usuario) references tb_usuarios (id_usuario)
);

create table tb_cuentas_autorizadas_terceros (
	id_autorizacion int not null auto_increment,
	id_usuario int not null,
	id_cuenta_tercero varchar(12),
	monto_max decimal(10,2) default 1000.00,
	trx_max_xdia int default 20,
	alias varchar(50),
	primary key(id_autorizacion),
	foreign key (id_usuario) references tb_usuarios (id_usuario),
	foreign key (id_cuenta_tercero) references tb_cuentas_por_usuario (id_cuenta)
);

create table tb_resp_codes(
	resp_code varchar(3) not null,
	descripcion varchar(50) not null default 'No especificado',
	primary key (resp_code)
);

insert into tb_resp_codes (resp_code, descripcion) values ('110','RETIRO MONETARIO');
insert into tb_resp_codes (resp_code, descripcion) values ('210','DEPÓSITO MONETARIO');
insert into tb_resp_codes (resp_code, descripcion) values ('310','TRANSFERENCIA MONETARIA');


create table tr_log (
	audit int not null auto_increment,
	cuenta_origen varchar(12),
	cuenta_destino varchar(12),
	monto decimal(10,2),
	resp_code varchar(3),
	id_regla_autorizacion int,
	hora datetime default now(),
	primary key (audit),
	foreign key (resp_code) references tb_resp_codes (resp_code)
);

DELIMITER //
CREATE procedure contar_24hrs()
wholeblock:BEGIN
  declare str VARCHAR(255) default '';
  declare x INT default 0;
  declare conteo_h INT default 0;
  declare conteo_usuarios_trx int default 0;
  declare monto_trx_dia decimal(10,2) default 0;
  SET x = 0;

  WHILE x <= 23 DO
    select count(1) trx into conteo_h from tr_log where HOUR(hora) = x and DATE_FORMAT(hora, '%y-%m-%d') = CURDATE();
    SET str = CONCAT(str,conteo_h ,' ');
    SET x = x + 1;
  END WHILE;
  select count(DISTINCT (id_usuario)) count_usuarios into conteo_usuarios_trx  from vista_usuarios_trx_dia ;
  select sum(monto) into monto_trx_dia from tr_log tl where DATE_FORMAT(hora, '%y-%m-%d') = CURDATE();
  select str, conteo_usuarios_trx, monto_trx_dia ;
END //
DELIMITER ;


create VIEW vista_usuarios_trx_dia
AS
select id_usuario from tr_log tl 
inner join tb_cuentas_por_usuario tcpu on tcpu.id_cuenta = tl.cuenta_origen
where DATE_FORMAT(hora, '%y-%m-%d') = CURDATE()
UNION
select id_usuario from tr_log tl2 
inner join tb_cuentas_por_usuario tcpu2 on tcpu2.id_cuenta = tl2.cuenta_destino 
where DATE_FORMAT(hora, '%y-%m-%d') = CURDATE();


DELIMITER //
CREATE PROCEDURE retiro_monetario(
	IN cuenta_origen varchar(12),
	IN monto decimal(10,2),
	OUT resultado varchar(50))
BEGIN
DECLARE saldo_origen decimal(10,2);
select saldo into saldo_origen  from tb_cuentas_por_usuario where id_cuenta = cuenta_origen ;
if (saldo_origen < monto) then
	insert into tr_log (cuenta_origen, cuenta_destino, monto, resp_code) values (cuenta_origen, null, monto, '0' );
	select 'El monto supera el saldo de la cuenta' into resultado;
else 
	update tb_cuentas_por_usuario set saldo = saldo_origen - monto where id_cuenta = cuenta_origen;
	insert into tr_log (cuenta_origen, cuenta_destino, monto, resp_code) values (cuenta_origen, null, monto, '110' );
	select 'Se ha dispensado el dinero' into resultado;
end if;
END //
DELIMITER ;

DELIMITER // 
CREATE PROCEDURE deposito_monetario(
	IN cuenta_destino varchar(12),
	IN monto decimal(10,2),
	OUT resultado varchar(50))
BEGIN
DECLARE saldo_destino decimal(10,2);
	select saldo into saldo_destino  from tb_cuentas_por_usuario where id_cuenta = cuenta_destino ;
	update tb_cuentas_por_usuario set saldo = saldo_destino + monto where id_cuenta = cuenta_destino;
	insert into tr_log (cuenta_origen, cuenta_destino, monto, resp_code) values (null, cuenta_destino , monto, '210' );
	select 'Se ha depositado con éxito' into resultado;
END //
DELIMITER ;

 
DELIMITER //
CREATE PROCEDURE transferencia_monetaria(
	IN cuenta_origen varchar(12),
	IN cuenta_destino varchar(12),
	IN monto decimal(10,2),
	IN autorizacion int,
	OUT resultado varchar(50))
BEGIN
DECLARE saldo_origen decimal(10,2);
DECLARE saldo_destino decimal(10,2);
DECLARE max_monto decimal(10,2);
DECLARE trx_max int;
DECLARE trx_today_count int;
select saldo into saldo_origen  from tb_cuentas_por_usuario where id_cuenta = cuenta_origen ;
select saldo into saldo_destino  from tb_cuentas_por_usuario where id_cuenta = cuenta_destino ;
select monto_max into max_monto  from tb_cuentas_autorizadas_terceros where id_autorizacion  = autorizacion ;
select trx_max_xdia into trx_max from tb_cuentas_autorizadas_terceros where id_autorizacion = autorizacion ;
select count(1) into trx_today_count from tr_log where DATE_FORMAT(hora, '%y-%m-%d') = CURDATE() and resp_code <> 0 and id_regla_autorizacion = autorizacion ;
if (saldo_origen < monto ) then
	insert into tr_log (cuenta_origen, cuenta_destino, monto, id_regla_autorizacion, resp_code) values (cuenta_origen , cuenta_destino , monto, autorizacion ,'0' );
	select 'El monto supera el saldo de la cuenta origen' into resultado;
elseif ( max_monto < monto ) then
	insert into tr_log (cuenta_origen, cuenta_destino, monto, id_regla_autorizacion, resp_code) values (cuenta_origen , cuenta_destino , monto, autorizacion ,'0' );
	select 'El monto supera máximo válido en transferencia' into resultado;
elseif ( trx_max  <= trx_today_count  ) then
	insert into tr_log (cuenta_origen, cuenta_destino, monto, id_regla_autorizacion, resp_code) values (cuenta_origen , cuenta_destino , monto, autorizacion ,'0' );
	select 'Has agotado el no. de trx autorizadas por hoy!' into resultado;
else
	update tb_cuentas_por_usuario set saldo = saldo_origen - monto where id_cuenta = cuenta_origen;
	update tb_cuentas_por_usuario set saldo = saldo_destino + monto where id_cuenta = cuenta_destino;
	insert into tr_log (cuenta_origen, cuenta_destino, monto, id_regla_autorizacion, resp_code) values (cuenta_origen , cuenta_destino , monto, autorizacion ,'310' );
	select 'Se ha transferido el dinero' into resultado;
end if;
END //
DELIMITER ;
