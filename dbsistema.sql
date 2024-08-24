-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2023 at 09:07 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbsistema`
--

-- --------------------------------------------------------

--
-- Table structure for table `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `codigo`, `nombre`, `stock`, `descripcion`, `imagen`, `condicion`) VALUES
(2, 10, '382974987234', 'Impresora Multi', 1, 'Multifuncional', '1522726906.jpg', 1),
(3, 10, '32432423423', 'Impresora', 34, 'IMpresora', '1522726914.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Audio y video', 'Todos los accesorios para equipos de sonido', 1),
(2, 'Software', 'Programas de computadora', 1),
(9, 'Dispositivos Electronicos', 'Todos los dispositivos Electronicos', 1),
(10, 'Muebles de oficina', 'Todos los muebles de oficina', 1),
(11, 'Impresoras y Fax', 'Todas las impresoras', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_ingreso`
--

CREATE TABLE `detalle_ingreso` (
  `iddetalle_ingreso` int(11) NOT NULL,
  `idingreso` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle_ingreso`
--

INSERT INTO `detalle_ingreso` (`iddetalle_ingreso`, `idingreso`, `idarticulo`, `cantidad`, `precio_compra`, `precio_venta`) VALUES
(1, 3, 2, 10, '500.00', '600.00'),
(2, 3, 3, 10, '20.00', '50.00'),
(3, 4, 2, 5, '500.00', '600.00'),
(4, 4, 3, 5, '20.00', '5.00'),
(5, 5, 2, 10, '1000.00', '2000.00'),
(6, 6, 2, 2, '100.00', '120.00'),
(7, 6, 3, 3, '10.00', '10.00');

--
-- Triggers `detalle_ingreso`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingreso` FOR EACH ROW BEGIN UPDATE articulo SET stock = stock + NEW.cantidad WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle_venta`
--

INSERT INTO `detalle_venta` (`iddetalle_venta`, `idventa`, `idarticulo`, `cantidad`, `precio_venta`, `descuento`) VALUES
(1, 1, 2, 3, '120.00', '0.00'),
(2, 1, 3, 3, '10.00', '0.00'),
(3, 2, 2, 2, '120.00', '0.00'),
(4, 3, 2, 1, '120.00', '12.00'),
(5, 4, 3, 1, '10.00', '1.00'),
(6, 5, 2, 1, '120.00', '0.00'),
(7, 5, 2, 1, '120.00', '0.00'),
(8, 6, 3, 1, '10.00', '0.00'),
(9, 7, 3, 1, '10.00', '0.00'),
(10, 8, 3, 1, '10.00', '0.00'),
(11, 9, 2, 1, '120.00', '0.00'),
(12, 10, 3, 1, '10.00', '0.00'),
(13, 12, 3, 1, '1000.00', '0.00'),
(14, 13, 2, 1, '120.00', '0.00'),
(15, 14, 3, 1, '10.00', '0.00'),
(16, 15, 2, 1, '120.00', '0.00'),
(17, 16, 3, 1, '10.00', '0.00'),
(18, 17, 3, 1, '10.00', '0.00'),
(19, 19, 2, 1, '120.00', '0.00'),
(20, 20, 3, 1, '10.00', '0.00'),
(21, 21, 3, 1, '10.00', '0.00'),
(22, 22, 2, 1, '120.00', '0.00'),
(23, 23, 2, 1, '120.00', '0.00');

--
-- Triggers `detalle_venta`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_venta` FOR EACH ROW BEGIN
UPDATE articulo SET stock = stock - NEW.cantidad
WHERE articulo.idarticulo = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ingreso`
--

CREATE TABLE `ingreso` (
  `idingreso` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `ingreso`
--

INSERT INTO `ingreso` (`idingreso`, `idproveedor`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_compra`, `estado`) VALUES
(3, 1, 1, 'Factura', '001', '0001', '2018-04-16 00:00:00', '16.00', '5200.00', 'Aceptado'),
(4, 2, 1, 'Factura', '002', '0002', '2018-04-17 00:00:00', '16.00', '2600.00', 'Aceptado'),
(5, 1, 1, 'Factura', '004', '0004', '2018-04-16 00:00:00', '16.00', '10000.00', 'Aceptado'),
(6, 2, 1, 'Boleta', '0009', '00912', '2018-04-17 00:00:00', '0.00', '230.00', 'Aceptado');

-- --------------------------------------------------------

--
-- Table structure for table `permiso`
--

CREATE TABLE `permiso` (
  `idpermiso` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `permiso`
--

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
(1, 'Escritorio'),
(2, 'Almacen'),
(3, 'Compras'),
(4, 'Ventas'),
(5, 'Acceso'),
(6, 'Consultas Compras'),
(7, 'Consulta Ventas');

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE `persona` (
  `idpersona` int(11) NOT NULL,
  `tipo_persona` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`idpersona`, `tipo_persona`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`) VALUES
(1, 'Proveedor', 'Benjamin', 'RUC', '7263128', 'Chicago Fire', '9872637318', 'correo@gmail.com'),
(2, 'Proveedor', 'Leon S.A', 'DNI', '26157', 'Conocido', '376782368', 'leon@gmail.com'),
(3, 'Proveedor', 'AAAA', 'DNI', '16237', 'con', '78263836', 'b@gail.com'),
(7, 'Cliente', 'Jose Luis Torres', 'INE', 'wqqwdf', 'avenida hombres ilustres', '561232323', 'dqwafitubi@gm233.com'),
(8, 'Cliente', 'Emanuel', 'INE', '123123', 'avenida hombres ilustres', '561121233', 'dafitubi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `cargo`, `login`, `clave`, `imagen`, `condicion`) VALUES
(1, 'Admin', 'DNI', '63238', 'Conocido', '27386126', 'admin@gmail.com', '', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '1523752615.jpg', 1),
(21, 'armando', 'DNI', '2', 'avenida hombres ilustres', '5611255716', 'dafitubi@gmail.com', '1', 'luis', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1678919654.png', 1),
(22, 'Usurio Taxal', 'INE', '123123123', 'avenida hombres ilustres', '561123123', 'dafitubi@gmail.com', 'Ventas', 'usuario', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1679527284.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_permiso`
--

CREATE TABLE `usuario_permiso` (
  `idusuario_permiso` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idpermiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuario_permiso`
--

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `idusuario`, `idpermiso`) VALUES
(82, 1, 1),
(83, 1, 2),
(84, 1, 3),
(85, 1, 4),
(86, 1, 5),
(87, 1, 6),
(88, 1, 7),
(102, 21, 1),
(103, 21, 2),
(104, 21, 3),
(105, 21, 4),
(106, 21, 5),
(107, 21, 6),
(108, 21, 7),
(109, 22, 4);

-- --------------------------------------------------------

--
-- Table structure for table `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(20,2) NOT NULL,
  `total_venta` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `example` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `venta`
--

INSERT INTO `venta` (`idventa`, `idcliente`, `idusuario`, `tipo_comprobante`, `serie_comprobante`, `num_comprobante`, `fecha_hora`, `impuesto`, `total_venta`, `estado`, `example`) VALUES
(43, 7, 1, 'Camioneta', '2', '2', '2023-03-22 00:00:00', '0.00', '0.00', 'Aceptado', 'example'),
(44, 7, 1, 'Sedan', '5', '10000', '2023-03-22 00:00:00', '99.99', '0.00', 'Aceptado', 'example'),
(45, 7, 1, 'Sedan', '1212', '2121212', '2023-03-22 00:00:00', '99.99', '0.00', 'Aceptado', 'example'),
(47, 7, 1, 'Camioneta', '5', '10000000.0', '2023-03-22 00:00:00', '0.00', '0.00', 'Aceptado', 'example'),
(48, 7, 1, 'Sedan', '2', '123333', '2023-03-22 00:00:00', '10000.12', '0.00', 'Aceptado', 'example'),
(49, 7, 1, 'Camioneta', '7', '5.5', '2023-03-22 00:00:00', '103.13', '0.00', 'Aceptado', 'example'),
(50, 7, 1, 'Sedan', '2', '4.5', '2023-03-22 00:00:00', '84.38', '0.00', 'Aceptado', 'example'),
(51, 7, 1, 'Sedan', '5', '100.25', '2023-03-22 00:00:00', '0.19', '0.00', 'Aceptado', 'example'),
(52, 7, 1, 'Sedan', '4', '185.25', '2023-03-22 00:00:00', '9.88', '0.00', 'Aceptado', 'example'),
(53, 7, 22, 'Camioneta', '5', '800', '2023-03-22 00:00:00', '42.96', '0.00', 'Aceptado', 'example'),
(54, 8, 22, 'Camioneta', '12', '2322', '2023-03-22 00:00:00', '124.70', '0.00', 'Aceptado', 'example');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`),
  ADD KEY `fk_articulo_categoria_idx` (`idcategoria`);

--
-- Indexes for table `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`),
  ADD UNIQUE KEY `nombre_UNIQUE` (`nombre`);

--
-- Indexes for table `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD PRIMARY KEY (`iddetalle_ingreso`),
  ADD KEY `fk_detalle_ingreso_ingreso_idx` (`idingreso`),
  ADD KEY `fk_detalle_ingreso_articulo_idx` (`idarticulo`);

--
-- Indexes for table `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_detalle_venta_venta_idx` (`idventa`),
  ADD KEY `fk_detalle_venta_articulo_idx` (`idarticulo`);

--
-- Indexes for table `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`idingreso`),
  ADD KEY `fk_ingreso_persona_idx` (`idproveedor`),
  ADD KEY `fk_ingreso_usuario_idx` (`idusuario`);

--
-- Indexes for table `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`idpermiso`);

--
-- Indexes for table `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `login_UNIQUE` (`login`);

--
-- Indexes for table `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD PRIMARY KEY (`idusuario_permiso`),
  ADD KEY `fk_usuario_permiso_permiso_idx` (`idpermiso`),
  ADD KEY `fk_usuario_permiso_usuario_idx` (`idusuario`);

--
-- Indexes for table `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `fk_venta_persona_idx` (`idcliente`),
  ADD KEY `fk_venta_usuario_idx` (`idusuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  MODIFY `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `idingreso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permiso`
--
ALTER TABLE `permiso`
  MODIFY `idpermiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `persona`
--
ALTER TABLE `persona`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  MODIFY `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_ingreso`
--
ALTER TABLE `detalle_ingreso`
  ADD CONSTRAINT `fk_detalle_ingreso_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_ingreso_ingreso` FOREIGN KEY (`idingreso`) REFERENCES `ingreso` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_detalle_venta_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `fk_ingreso_persona` FOREIGN KEY (`idproveedor`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ingreso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usuario_permiso`
--
ALTER TABLE `usuario_permiso`
  ADD CONSTRAINT `fk_usuario_permiso_permiso` FOREIGN KEY (`idpermiso`) REFERENCES `permiso` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_permiso_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_venta_persona` FOREIGN KEY (`idcliente`) REFERENCES `persona` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
