<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $this->load->view('welcome_message');
    }

    public function send()
    {
        require "application/vendor/autoload.php";

        $this -> load -> model("Model_user",'',true);
        $users = $this -> Model_user -> get_users($_SESSION['id']);

        $subject = "Commande";
        $body="";

        for($i=0; $i< sizeof($_SESSION['panier']); $i++)
        {
            $body .= "<p>name : ".$_SESSION['panier'][$i][0]['name']."</p><p>".$_SESSION['panier'][$i][0]['mult']."</p><p>".$_SESSION['login']."</p>";//c'est du html
        }

            $body .= "<p>username : ".$users[0]['username']."</p><p>".$users[0]['email']."</p>";//c'est du html

        $message = new Swift_Message($subject);
        $message->setFrom("nialy@live.fr");/*votre@ddresse.com*/
        $message->setTo("ravaloson@moov.mg");/*destinataire@ddresse.com*/ /*setTo(array("destinataire@ddresse.com", "dest2@gmail.com", "bryan@msn.fr"));*/
        $message->setBody($body);


        $transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587);
        $transport->setUsername("nialy@live.fr");/*votre@ddresse.com*/
        $transport->setPassword("HV6T18AwNFX43SwPDKnSyQ");/*votreMotDePasse*/

        $swift = Swift_Mailer::newInstance($transport);
        $worked=$swift->send($message);

        if ($worked)
        {
            echo "ok ! :-)";
        }
        else
        {
            echo "ko :-(";
        }

        redirect("/home/annulPanier");
    }
}
