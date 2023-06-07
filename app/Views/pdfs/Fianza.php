<?php

/*
 * Fichero que obtiene un archivo pdf con los datos de los seguimientos
 */

include_once('../../clases/modelos/ModBase.php');
include_once('../../clases/CBaseDatos.php');
include_once('../../clases/CCommand.php');
include_once('../../clases/CGenerales.php');
include_once('../../clases/Acceso.php');
include_once("../config/configBD.php");
include_once("../../clases/Utilidades.php");
include_once('../../clases/modelos/ModeloEmpresas.php');
include_once('../../clases/modelos/ModeloCentrosImpartidores.php');
require_once('../../clases/convertToPDF.php');
include_once('../../lib/LibreriaHTML_PDF/html2pdf.class.php');	

$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$modeloEmpresa = new ModeloEmpresas();
$resultado = $modeloEmpresa->dameDatosEmpresas($_GET["id"]);
$modelocentros = new ModeloCentrosImpartidores();
$resultadocodigo = $modelocentros->damecodigocentrocontrato($_GET["id"]);
//Ahora vamos a sacar el numero de acreditación
$contenido= "<link type='text/css' href='../../css/estiloCarta.css' rel='stylesheet'>".
	"<page backtop='17mm' backbottom='10mm' backleft='15mm'  backright='15mm' >".
	"<div class='container' style='font-size: 12px;'>
		Don/Doña ".$resultado[0]['RepresentanteLegEmp'].", con NIF núm. ".$resultado[0]['NifRepresentanteEmp'].", mayor de edad, como
		administrador de la mercantil ".$resultado[0]['NombreEmp']."  , con CIF ".$resultado[0]['CifEmp']." domiciliada en ".strtoupper($resultado[0]['TipoVia'])."
		".$resultado[0]['DireccionEmp']." ".$resultado[0]['LocalidadEmp']." (".$resultado[0]['ProvinciaEmp'].").
		<br><br>Don JOSÉ ENRIQUE RODRÍGUEZ RUZ, con NIF núm. 25332885H, mayor de edad y como
		administrador/a del Centro de Formación ABIRE ASESORES Y CONSULTORES EN
		FORMACIÓN, S.L.L, con CIF nº B93170504 y domicilio en C/ El Efebo, 6 Polígono Industrial de
		Antequera, Málaga, CP 29200, en su calidad de ADMINISTRADOR,
		<br><br><strong><u>EXPONE</u></strong><br><br>
		Que esta entidad está acreditada con el código ".$resultadocodigo[0]['codigosepeImp']." y es la encargada de impartir, en
		la modalidad de teleformación, la formación inherente al contrato de formación referido en el
		anexo I y,
		<br><br><strong><u>DECLARA, BAJO SU RESPONSABILIDAD QUE:</u></strong>
		<br><br>• La persona trabajadora especificada en el Acuerdo de Autorización Anexo I, cumple con
		los requisitos establecidos en el artículo 11.2 del texto refundido de la Ley del Estatuto de
		los Trabajadores, aprobado por el Real Decreto Legislativo 1/1995 de 24 de marzo y en el
		artículo 6 del Real Decreto 1529/2012, de 8 de noviembre, por el que se desarrolla el
		contrato para la formación y el aprendizaje y se establecen las bases de la formación
		profesional dual.
		<br><br>• La persona trabajadora reúne los requisitos de acceso a las acciones formativas
		contempladas en el Acuerdo Anexo I.
		<br><br>• En el caso en el que las acciones formativas contempladas en el Acuerdo constituyan un
		itinerario formativo, la persona trabajadora deberá reunir los requisitos de acceso en el
		momento de inicio de cada acción formativa.
		<br><br>• La persona representante de la empresa tiene facultad legal para suscribir el Acuerdo
		Anexo I.
		<br><br>• La persona representante de la entidad o centro de formación tiene facultad legal para
		suscribir el Acuerdo Anexo I.
		<br><br>• Las acciones formativas especificadas en el Acuerdo Anexo I, reúnen los requisitos
		especificados en los Reales Decretos que regulan los certificados de profesionalidad cuya
		formación van a impartir, de acuerdo con el apartado 12.bis del real decreto 34/2008, de
		18 de enero.
		<br><br>• El centro y/o la plataforma de teleformación, donde se va a implementar la actividad
		formativa se encuentra, según sea el caso, acreditados/inscritos/autorizados en las
		especialidades formativas contempladas en el Acuerdo Anexo I.
		<br><br>• Las personas formadoras cumplen con las prescripciones del art. 13 del Real Decreto
		34/2008 de 18 de enero y del certificado de profesionalidad correspondiente.
		<br><br>• En el caso de que alguna de las acciones formativas contempladas en el Acuerdo, se
		imparta en la modalidad de teleformación, el alumno o alumna posea las destrezas
		suficientes para ser usuario de la plataforma virtual en la que se apoya la acción formativa
		(Art. 6.2 de la Orden 1897/2013, de 10 de octubre, por la que se desarrolla el Real Decreto
		34/2008, de 18 de enero, por el que se regulan los certificados de profesionalidad dictados
		en su aplicación)
		<br><br>La inexactitud o falsedad, de carácter esencial, en cualquier dato, manifestación o documento
		que se acompañe o incorpore a esta declaración responsable, así como incumplimiento de los
		requisitos, obligaciones y compromisos establecidos, determinarán la imposibilidad de
		obtención de la correspondiente certificación de la actividad formativa autorizada como
		conducente a certificado de profesionalidad o acreditación parcial acumulable, sin perjuicio de
		las responsabilidades penales, civiles o administrativas que hubiera lugar.
		
		<br><br>Y para que así conste, firma esta declaración,
		<br><br>En Antequera, a ".strftime("%d")." de ".$meses[date('n')-1]." de " .strftime("%Y"). "
		<br><br>
	<div class='puntos'></div>
	<table>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>Fdo.: JOSÉ ENRIQUE RODRÍGUEZ RUZ<br>Administrador centro formación</td>
		</tr>
	</table>
	</div>
	<page_footer class='footer'>
		<span><strong>DATOS PARA NOTIFICACIONES</strong>
		<br>Centro de Formación Abire Asesores y Consultores en Formación, S.L. 
		<br>C/ El Efebo, 6. Pgno. Industrial de Antequera C.P. 29200 Málaga
		<br>antonioherrero@abire.es Telf.: 951 080 170</span>
	</page_footer>
	</page>";
	try{
		$html2pdf = new HTML2PDF('P', 'A4', 'es');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($contenido);
		$html2pdf->Output('DECLARACION_RESPONSABLE.pdf');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}