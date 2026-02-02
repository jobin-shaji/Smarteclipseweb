<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PDF;
class Helper
{

    public static function get_guard()
    {
        return Auth::getDefaultDriver();
        // if (Auth::guard('admin')->check()) {
        //     return "admin";
        // } elseif (Auth::guard('store')->check()) {
        //     return "store";
        // } elseif (Auth::guard('vendor')->check()) {
        //     return "vendor";
        // }
    }

    public static function send_mail($to_name, $to_email, $data,$subject,$template)
    {
        
        $message = 'Hi '.$to_name.' ,Please see the attached invoice for your latest order';
        $file_name = 'invoice.pdf';
        $pdf = PDF::loadView($template, $data);
       // $pdf = PDF::loadView('web.invoice', $data);

        $pdf->save(public_path($file_name));

        $file_path = public_path($file_name);
        $file_size = filesize($file_path);
        $file_content = chunk_split(base64_encode(file_get_contents($file_path)));
        // Define the email headers
        $headers = "From: support@myfamilyfitness.com\r\n";
        $headers .= "Reply-To: support@myfamilyfitness.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"boundary\"\r\n";

        // Define the message body
        $body = "--boundary\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message . "\r\n\r\n";

        // Define the attachment section
        $body .= "--boundary\r\n";
        $body .= "Content-Type: application/pdf; name=\"" . $file_name . "\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"\r\n";
        $body .= "Content-Length: " . $file_size . "\r\n\r\n";
        $body .= $file_content . "\r\n\r\n";
        if (mail($to_email, $subject, $body, $headers)) {
           return true;
        } else {
            return false;
        }
    }

   
    public static function getPaymentStatus($status)
    {
        switch ($status) {
            case 0:
                return "Pending";
                break;
            case 1:
                return "Paid";
                break;
            case 2:
                return "Cancelled";
                break;
            default:
                return "Failed";
                break;
        }
    }

    

    public static function encrypt($plainText,$key)
    {
        $key =Helper::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    public static function decrypt($encryptedText,$key)
    {
        $key =Helper::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText =Helper::hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }
    //*********** Padding Function *********************

    public static function pkcs5_pad ($plainText, $blockSize)
    {
        $pad = $blockSize - (strlen($plainText) % $blockSize);
        return $plainText . str_repeat(chr($pad), $pad);
    }

    //********** Hexadecimal to Binary function for php 4.0 version ********

    public static function hextobin($hexString) 
     { 
            $length = strlen($hexString); 
            $binString="";   
            $count=0; 
            while($count<$length) 
            {       
                $subString =substr($hexString,$count,2);           
                $packedString = pack("H*",$subString); 
                if ($count==0)
            {
                $binString=$packedString;
            } 
                
            else 
            {
                $binString.=$packedString;
            } 
                
            $count+=2; 
            } 
            return $binString; 
          } 
public static function getIndianCurrency(float $number)
{

$decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
    $digits = array('', 'hundred','thousand','lakh', 'crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
      $paise ="";$pais="";
    $paise =($decimal > 0) ? " " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' paisa' : '';
    if($paise){
      $pais=  'and'. $paise;
    }
    return ($Rupees ? ucfirst($Rupees). 'Rupees '  : '') . $pais;
}

}
