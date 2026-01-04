<?php

namespace App\Classes;

/**
 *
 * PDF TEMPLATE
 *
 * @author Tharindu Lakshan<tahrinudmac@gmail.com>
 * @version 1.0.0
 * @copyright Copyright (c) 2015, Yasith Samarawickrama
 *
 */
use TCPDF;

class PdfBarcodeTemplate extends TCPDF{


    protected $data;

    public function __construct($data)
    {
        $this->data=$data;
        parent::__construct();
    }


    public function Footer() {

        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Set font
        $this->SetFont('helvetica', 'I', 9);
        $pagenumber='Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages();
        $footer='<table width="100%" align="center">
							<tbody>
								<tr><td style="line-height:0.5"></td></tr>
								<tr>
									<td>								
									 <br/>'.$pagenumber.'
									</td>
								</tr>
							</tbody>
						</table>';

        $this->writeHtml($footer);
    }
}
