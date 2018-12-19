<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailUtil
 *
 * @author Arpit-iCreate
 */

class mailutil {
 
private  $mail ;
    public function __construct()
    {
        $this->mail=new PHPMailer();
    }
    public function configuresmtp()
    {

//$this->mail->IsSMTP();                          // telling the class to use SMTP
$this->mail->Host       = "smtp.gmail.com";     // SMTP server
$this->mail->SMTPDebug  = 1;                    // enables SMTP debug information (for testing)
                                                // 1 = errors and messages
                                                // 2 = messages only
$this->mail->SMTPAuth   = true;                      // enable SMTP authentication
$this->mail->Host       = "smtp.gmail.com";          // sets the SMTP server
$this->mail->Port       = 465;                       // set the SMTP port for the GMAIL server
//$this->mail->Username   = "nisha.icreate@gmail.com"; // SMTP account username
//$this->mail->Password   = "nisha9036";               // SMTP account password
$mail->Username   = "info@omwearlifestyle.com"; // SMTP account username
$mail->Password   = "Prash@131";   
$this->mail->SMTPSecure = 'ssl';
    }
    public function From($from)
    {
        $this->mail->From=$from;
    }
    public function FromName($fromname)
    {
        $this->mail->FromName=$fromname;
    }
    public function AddAddress($address,$name='')
    {
        $this->mail->addAddress($address,$name);
    }
    public function AddReplyTo($address,$name='') 
    {
        $this->mail->addReplyTo($address,$name);
    }
    public function AddCC($address,$name='') {
        $this->mail->addCC($address,$name);
    }
    public function AddBCC($address,$name=''){
        $this->mail->addBCC($address, $name);
    }
    public function AddAttachment($path, $name='', $encoding='base64', $type='', $disposition='attachment')
    {
        $this->mail->addAttachment($path, $name, $encoding, $type, $disposition);
       
    }
    public function geterror()
    {
        return  $this->mail->ErrorInfo;
    }
    public function SetBodyAsText($body)
    {
        $this->mail->Body=$body;
                
    }
    public function setSubject($subject) {
        $this->mail->Subject=$subject;
    }
    public function SetBodyFromTemplate($filename,$data=array()) 
    {
        try{
         if (!file_exists($filename))
		{
			throw new Exception("mail template file not found ".$filename);
		}
		                
		extract($data);
		ob_start();
		include($filename);
		$output = ob_get_contents();
		ob_end_clean();
		$this->mail->Body=$output;
        }catch(Exception $ex)
        {
            throw $ex;
        }
    }
    public function setHTML() {
        $this->mail->isHTML();
    }
    
    public function send() 
    {
        return $this->mail->send();
    }
}

?>
