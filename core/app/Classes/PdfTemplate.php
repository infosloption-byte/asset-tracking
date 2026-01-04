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

class PdfTemplate extends TCPDF{


    protected $data;

    public function __construct($data)
    {
        $this->data=$data;
        parent::__construct();
    }


    public function Footer() {

        // Position at 15 mm from bottom
        $this->SetY(-30);
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

    public function Header() {

        $img=file_get_contents(storage_path().'/image/rdb.jpg');

        // $image_file = url('assets/sammy_new/images/rdb.jpg');
        $this->Image('@'.$img, 10, 10, 20, '', 'JPG', '', 'T', false, 300, '', false, false, 0, true, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);

        $headerData='<table width="100%">
                        <tbody>
                            <tr>            
                                <td style="line-height: 1;text-align: right;font-size: 8px">Printed By : super.admin</td>
                            </tr>
                            <tr>            
                                <td style="line-height: 1;text-align: right;font-size: 8px">'.date('Y-m-d').'</td>
                            </tr>
                            <tr>            
                                <td style="line-height: 2;text-align: center;font-size: 12px">REGIONAL DEVELOPMENT BANK</td>            
                            </tr>
                            <tr>
                                <td style="line-height: 2;text-align: center;font-size: 10px">'.$this->data['title'].'</td>            
                            </tr>
                        </tbody>
                    </table>';

        $this->writeHTML($headerData);
    }
}
