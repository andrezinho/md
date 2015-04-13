<?php
session_start();
require('../lib/spdo.php');
$tk = $_GET['token'];
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{       
	function Header()
	{

	}

	function Footer()
	{
        $this->SetY(-13);
        $this->SetFont('Arial','I',7);
        $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
	}

	function ffecha($fecha)
    {
        $n = explode("-",$fecha);
        return $n[2]."/".$n[1]."/".$n[0];        
    }

    function background($i)
    {
        if($i%2==0)
        {
            $this->SetFillColor(245, 245, 245);
            $this->SetTextColor(0,0,0);
        }
        else
        {
            $this->SetFillColor(255, 255, 255);
            $this->SetTextColor(0,0,0);
        }
    }
    function fill_cell($text,$w,$r,$g,$b)
    {
        $this->SetDrawColor(255,255,255);
        $this->SetFillColor($r, $g, $b); 
        $this->Cell(45, 7,utf8_decode($text), $border, 0, 'L', true);
        $this->SetDrawColor(0,0,0);
    }
	function FancyTable($r,$r_)
	{
        $tingreso = 0;
        $tegresos = 0;
        $saldo = 0;
        $i = 0;
        $h = 4;
        
        $this->Image('../images/logo.jpg',15,15,25);
        $this->Ln(21);

        $this->SetFont('Arial','B',18);
        $this->Cell(0, 7,utf8_decode("Cupón de Pago"), 0, 0, 'L', false);

        $this->SetFont('Arial','',10);
        $texto = "A continuación encontrarás el cupón para pagar tu reserva. Los págps se realizan mediante depósitos en cuenta bancaria los mismo que se muestran en este documento. Deberás presentar este Cupón junto al voucher de depósito para hacer efectivo el descuento.";
        $this->Ln(8);
        $this->MultiCellp(190, 4, utf8_decode($texto) , 0, 'J', false);

        $this->Ln(7);
        $border = "LTR";

        $this->SetDrawColor(255,255,255);
        $this->SetFillColor(191, 191, 191);        
        $this->SetFont('Arial','B',10);
        $this->Cell(45, 7,utf8_decode("Nombre"), $border, 0, 'L', true);
        $this->SetFillColor(231, 231, 231);        
        $this->SetFont('Arial','',10);
        $this->Cell(50, 7,utf8_decode($r->nombres." ".$r->apellidos), $border, 0, 'L', true);
        $this->SetFillColor(191, 191, 191);        
        $this->SetFont('Arial','B',10);
        $this->Cell(52, 7,utf8_decode("Documento de identificacion"), $border, 0, 'L', true);
        $this->SetFillColor(231, 231, 231);          
        $this->SetFont('Arial','',10);
        $this->Cell(43, 7,utf8_decode($r->nrodocumento), $border, 1, 'L', true);

        $this->SetFillColor(191, 191, 191);        
        $this->SetFont('Arial','B',10);
        $this->Cell(45, 7,utf8_decode("Código de Reserva"), $border."B", 0, 'L', true);
        $this->SetFillColor(231, 231, 231);
        $this->SetFont('Arial','',10);
        $this->Cell(50, 7,utf8_decode($r->numero), $border."B", 0, 'L', true);
        $this->SetFillColor(191, 191, 191);
        $this->SetFont('Arial','B',10);
        $this->Cell(52, 7,utf8_decode("Fecha Límite de Pago"), $border."B", 0, 'L', true);
        $this->SetFillColor(231, 231, 231);
        $this->SetFont('Arial','',10);
        $this->Cell(43, 7,utf8_decode($this->ffecha($r->fecha_fin)), $border."B", 1, 'L', true);

        $this->Ln(3);
        $this->SetFillColor(191, 191, 191);
        $this->SetFont('Arial','B',10);
        $this->Cell(0, 7,utf8_decode("Información del Cupón"), $border."B", 1, 'L', true);
        $this->Ln(2);

        $this->SetDrawColor(0,0,0);
        $this->Cell(0, 7,utf8_decode("Descuento :"), 0, 1, 'L', false);
        $this->SetFont('Arial','',10);               
        $this->MultiCellp(190, 4, $r->titulo2 , 0, 'J', false);

        $this->Ln(8);
        $this->SetFont('Arial','B',10);
        $this->Cell(45, 5,utf8_decode("Precio Real"), 0, 0, 'L', false);
        $this->Cell(45, 5,utf8_decode("Descuento"), 0, 0, 'L', false);
        $this->Cell(45, 5,utf8_decode("Precio Final"), 0, 1, 'L', false);
        $this->SetFont('Arial','',10);
        $this->Cell(45, 5,"S/. ".number_format($r->precio_regular,2), 0, 0, 'L', false);
        $this->Cell(45, 5,utf8_decode($r->descuento), 0, 0, 'L', false);
        $this->SetFont('Arial','B',10);
        $this->Cell(45, 5,"S/. ".number_format($r->precio,2), 0, 1, 'L', true);

        $this->Ln();
        $this->Cell(0, 5,utf8_decode("Empresa:"), 0, 1, 'L', false);
        $this->SetFont('Arial','',10);
        $this->Cell(0, 5,utf8_decode("Nombre: ".$r->razon_social), 0, 1, 'L', false);
        $this->Cell(0, 5,utf8_decode("Dirección: ".$r->direccion." - ".$r->ciudad), 0, 1, 'L', false);
        $this->Cell(0, 5,utf8_decode("Telefonos: ".$r->telefono1.", ".$r->telefono2." / Email: ".$r->email), 0, 1, 'L', false);

        $this->Ln();
        $this->SetFont('Arial','B',10);
        $this->Cell(0, 7,utf8_decode("Cuentas Bancarias:"), 0, 1, 'L', true);
        $this->SetFont('Arial','',10);
        
        $this->Ln(2);
        $this->SetDrawColor(191, 191, 191);
        $w = 30;
        $cont=0;
        foreach ($r_ as $r__) 
        {
            if($cont%2==0)
            {
                $this->SetFillColor(231, 231, 231);
            }
            else
            {
                $this->SetFillColor(255, 255, 255);
            }

            $cont +=1;

            $this->Cell($w+30, 5,utf8_decode($r__['banco']), 1, 0, 'L', true);
            $this->Cell($w+100, 5,": ".utf8_decode($r__['nrocuenta']), 1, 1, 'L', true);            
            
        }


        $this->Ln(5);
        $this->SetDrawColor(255, 255, 255);
        $this->SetFillColor(191, 191, 191);
        $this->SetFont('Arial','B',10);
        $this->Cell(0, 7,utf8_decode("Condiciones Comerciales: "), 0, 1, 'L', true);
        $this->Ln(2);

        $cc = strip_tags ($r->cc);
        $this->SetFont('Arial','',9);
        $this->MultiCellp(190, 4, $cc , 0, 'J', false);


	}
}



$sql = "SELECT c.idcupon,
                c.token,
                c.numero,
                u.nombres,
                u.apellidos,
                u.nrodocumento,
                p.idpublicaciones,
                p.fecha_fin,
                p.precio_regular,
                p.descuento,
                p.precio,
                e.razon_social,
                l.direccion,    
                l.telefono1,
                l.telefono2,
                l.email,
                e.website,
                e.bcp,
                e.scotiabank,
                e.interbank,
                e.continental,
                e.otros,
                e.nacion,
                p.titulo2,
                p.cc,
                ub.descripcion as ciudad,
                e.idempresa
        FROM cupon as c inner join publicaciones as p on c.idpublicaciones = p.idpublicaciones
        inner join usuario as u on c.idcliente = u.idusuario
        inner join suscripcion as s on p.idsuscripcion = s.idsuscripcion
        inner join local as l on l.idlocal = s.idlocal
        inner join empresa as e on e.idempresa = l.idempresa
        inner join ciudad as ci on ci.cod = l.idubigeo
        inner join ubigeo as ub on ub.idubigeo = ci.idciudad
        where c.token = :tk ";
$stmt = $db->prepare($sql);
$stmt->bindParam(':tk',$tk,PDO::PARAM_STR);
$stmt->execute();
$r = $stmt->fetchObject();

if($r->nombres!="")
{
    $pdf=new PDF();
    $orientacion = 'P';
    $pdf->SetMargins(10, 15);
    $pdf->AddPage($orientacion);
    $pdf->AliasNbPages();

    $stmt_ = $db->prepare("SELECT b.idbancos,b.descripcion as banco,eb.nrocuenta
                                  from empresa_bancos as eb inner join bancos as b on b.idbancos=eb.idbancos
                                  where eb.idempresa =:ide");
    $stmt_->bindParam(':ide',$r->idempresa,PDO::PARAM_INT);
    $stmt_->execute();

    $pdf->FancyTable($r,$stmt_->fetchAll());
    $pdf->Output();
}
else
{   
    echo "<script>alert('No se ha encontrado el cupon.');window.close()</script>";
}

?>
