<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
    public $nbrProduct;

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this -> nbrProduct=1;
    }

    public function index()
    {
            if(empty($_SESSION['login']) == false)
            {
                $this->load->model("Model_user", '', true);
                $product = $this->Model_user->get_product();
                if(array_key_exists('panier', $_SESSION)==false)
                {
                    $_SESSION['panier']=array();
                }

                $total=0;
                $nbrpanier=0;
                for($s=0; $s< sizeof($_SESSION['panier']); $s++)
                {
                    if(empty($_SESSION['panier'][$s][0])==false)
                    {
                        $total = $total + $_SESSION['panier'][$s][0]['prix'];
                        $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
                    }
                }

                $this -> load -> view('top');
                $this -> load -> view('homepage', array('res'=>$product,'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier));
                $this -> load -> view('bottom');
            }
            else
            {
                redirect("/user/login");
            }

    }

    public function oneProduct($id)
    {
        $this->load->model("Model_user", '', true);
        $product = $this->Model_user->getone_productid($id);
        $comment=$this->Model_user->get_comment($id);
        if($comment==false)
        {
            $comment=array();
            $moyenne=0;
        }

        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }
        if (empty($comment)==false)
        {
            $moyenne=0;

            for($c=0; $c<sizeof($comment); $c++)
            {
                $moyenne += $comment[$c]['nbretoile']*5;
            }

            $moyenne = $moyenne/(5*($c));

        }

        $total=0;
        $nbrpanier=0;
        for($s=0; $s< sizeof($_SESSION['panier']); $s++)
        {
            if(empty($_SESSION['panier'][$s][0])==false)
            {
                $total = $total + $_SESSION['panier'][$s][0]['prix'];
                $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
            }
        }
        $this -> load -> view('top');
        $this -> load -> view('oneProduct', array('res'=>$product,'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier, 'commentaire'=>$comment,'moyenne' => $moyenne));
        $this -> load -> view('bottom');
    }

    public function panierProduct($id)
    {
        $this->load->model("Model_user", '', true);
        $product = $this->Model_user->getone_product($id);
        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }
        if(array_key_exists('idpanier', $_SESSION)==false)
        {
            $_SESSION['idpanier']=array();
        }


        if(in_array($id, $_SESSION['idpanier'],true))
        {
            for($i=0;$i<sizeof($_SESSION['panier']);$i++)
            {
                if($_SESSION['panier'][$i][0]['id']==$id)
                {

                    $_SESSION['panier'][$i][0]['prix']+= $product[0]['prix'];
                    $_SESSION['panier'][$i][0]['mult']++;
                }
            }
        }

        else
        {
            array_push($_SESSION['idpanier'],$id);
            array_push($_SESSION['panier'],$product);
        }

        for($m=0;$m<sizeof($_SESSION['panier']);$m++)
        {
            if(array_key_exists('mult',$_SESSION['panier'][$m][0])==false)
            {
                $_SESSION['panier'][$m][0]['mult']=1;
            }

        }

        echo json_encode($_SESSION['panier']);
    }

    public function inputProduct($mult, $id)
    {
        $this->load->model("Model_user", '', true);
        $product = $this->Model_user->getone_product($id);

        if($mult>0 && $mult<=$product[0]['quantity'])
        {
            $var=$mult;
            /*$quantity=$product[0]['quantity']-$mult;
            $this->Model_user-> update_product($id, $quantity);*/
        }

        else
        {
            $var=1;
        }


        for($i=0;$i<sizeof($_SESSION['panier']);$i++)
        {
            if($_SESSION['panier'][$i][0]['id']==$id)
            {

                $_SESSION['panier'][$i][0]['prix'] = $product[0]['prix']*$var;
                $_SESSION['panier'][$i][0]['mult']=$var;
            }
        }
        echo json_encode($_SESSION['panier']);
    }


    public function supprSession($session)
    {
        array_splice ($_SESSION['panier'],$session,1);
        array_splice($_SESSION['idpanier'],$session,1);

        echo json_encode($_SESSION['panier']);
    }

    public function priceProduct()
    {
        $this->load->model("Model_user", '', true);
        $pricemax = $this->Model_user->getprice_max();

        $min=0;
        $max=intval($pricemax[0]['maxi']);

        if(empty($_GET['price1'])==false && empty($_GET['price2'])==false )
        {
            if($_GET['price1']<$_GET['price2'])
            {
                $min=$_GET['price1'];
                $max=$_GET['price2'];
            }
            else
            {
                $max=$_GET['price1'];
                $min=$_GET['price2'];
            }
        }
        if(empty($_GET['price1']) && empty($_GET['price2'])==false)
        {
            $min=$_GET['price2'];
            $max=$_GET['price2'];
        }
        if(empty($_GET['price2']) && empty($_GET['price1'])==false)
        {
            $min=$_GET['price1'];
            $max=$_GET['price1'];
        }

        $product = $this->Model_user->getprice_product($min, $max);
        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }

        $total=0;
        $nbrpanier=0;
        for($s=0; $s< sizeof($_SESSION['panier']); $s++)
        {
            if(empty($_SESSION['panier'][$s][0])==false)
            {
                $total = $total + $_SESSION['panier'][$s][0]['prix'];
                $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
            }
        }

        $this -> load -> view('top');
        $this -> load -> view('priceproduct', array('res'=>$product,'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier));
        $this -> load -> view('bottom');

    }

    public function searchProduct()
    {
        if (empty($_POST['browser'])==false)
        {
            $id=$_POST['browser'];
        }

        $this->load->model("Model_user", '', true);
        $product = $this->Model_user->getone_product($id);

        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }

        $total=0;
        $nbrpanier=0;
        for($s=0; $s< sizeof($_SESSION['panier']); $s++)
        {
            if(empty($_SESSION['panier'][$s][0])==false)
            {
                $total = $total + $_SESSION['panier'][$s][0]['prix'];
                $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
            }
        }


        $this -> load -> view('top');
        $this -> load -> view('searchProduct', array('res'=>$product,'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier,'namesearch'=>$id));
        $this -> load -> view('bottom');
    }

    public function ctgProduct($ctg)
    {
        $this->load->model("Model_user", '', true);
        $product = $this->Model_user->get_categorie($ctg);
        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }

        $total=0;
        $nbrpanier=0;
        for($s=0; $s< sizeof($_SESSION['panier']); $s++)
        {
            if(empty($_SESSION['panier'][$s][0])==false)
            {
                $total = $total + $_SESSION['panier'][$s][0]['prix'];
                $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
            }
        }

        $this -> load -> view('top');
        $this -> load -> view('ctgProduct', array('res'=>$product,'categorie'=>$ctg, 'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier));
        $this -> load -> view('bottom');
    }

    public function pricectgProduct($ctg)
    {

        $this->load->model("Model_user", '', true);
        $pricemax = $this->Model_user->getprice_max();

        $min=0;
        $max=intval($pricemax[0]['maxi']);

        if(empty($_GET['price1'])==false && empty($_GET['price2'])==false )
        {
            if($_GET['price1']<$_GET['price2'])
            {
                $min=$_GET['price1'];
                $max=$_GET['price2'];
            }
           else
           {
               $max=$_GET['price1'];
               $min=$_GET['price2'];
           }
        }
        if(empty($_GET['price1']) && empty($_GET['price2'])==false)
        {
            $min=$_GET['price2'];
            $max=$_GET['price2'];
        }
        if(empty($_GET['price2']) && empty($_GET['price1'])==false)
        {
            $min=$_GET['price1'];
            $max=$_GET['price1'];
        }

        $product = $this->Model_user->getprice_categorie($ctg, $min, $max);
        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }

        $total=0;
        $nbrpanier=0;
        for($s=0; $s< sizeof($_SESSION['panier']); $s++)
        {
            if(empty($_SESSION['panier'][$s][0])==false)
            {
                $total = $total + $_SESSION['panier'][$s][0]['prix'];
                $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
            }
        }

        $this -> load -> view('top');
        $this -> load -> view('homepage', array('res'=>$product,'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier));
        $this -> load -> view('bottom');

    }
    public function priceSearchProduct($ctg)
    {
        $this->load->model("Model_user", '', true);
        $pricemax = $this->Model_user->getprice_max();

        $min=0;
        $max=intval($pricemax[0]['maxi']);

        if(empty($_GET['price1'])==false && empty($_GET['price2'])==false )
        {
            if($_GET['price1']<$_GET['price2'])
            {
                $min=$_GET['price1'];
                $max=$_GET['price2'];
            }
            else
            {
                $max=$_GET['price1'];
                $min=$_GET['price2'];
            }
        }
        if(empty($_GET['price1']) && empty($_GET['price2'])==false)
        {
            $min=$_GET['price2'];
            $max=$_GET['price2'];
        }
        if(empty($_GET['price2']) && empty($_GET['price1'])==false)
        {
            $min=$_GET['price1'];
            $max=$_GET['price1'];
        }

        $product = $this->Model_user->getprice_searchProduct($ctg, $min, $max);
        if(array_key_exists('panier', $_SESSION)==false)
        {
            $_SESSION['panier']=array();
        }

        $total=0;
        $nbrpanier=0;
        for($s=0; $s< sizeof($_SESSION['panier']); $s++)
        {
            if(empty($_SESSION['panier'][$s][0])==false)
            {
                $total = $total + $_SESSION['panier'][$s][0]['prix'];
                $nbrpanier= $nbrpanier+$_SESSION['panier'][$s][0]['mult'];
            }
        }

        $this -> load -> view('top');
        $this -> load -> view('homepage', array('res'=>$product,'panier' => $_SESSION['panier'],'total'=>$total,'nbr'=> $nbrpanier));
        $this -> load -> view('bottom');

    }

    public function annulPanier()
    {
        $_SESSION['panier']=array();
        $_SESSION['idpanier']=array();
        redirect("/home");
    }

    public function numberEtoile($nbr)
    {
        $_SESSION['nbrEtoile']=$nbr;
    }

    public function commentaire($idproduct)
    {
        $nbr=$_SESSION['nbrEtoile'];
        $this->load->model("Model_user", '', true);
        $this->Model_user->insert_comment($_POST['commentaire'],$nbr,$_SESSION['id'],$idproduct);
        redirect("/home/oneProduct/".$idproduct);

    }

    public function commande()
    {
        for($cmd=0;$cmd<sizeof($_SESSION['panier']);$cmd++)
        {
            $this->load->model("Model_user", '', true);
            $this->Model_user->insert_commande($_SESSION['panier'][$cmd][0]['name'],$_SESSION['panier'][$cmd][0]['prix'],$_SESSION['panier'][$cmd][0]['mult'],$_SESSION['id']);
        }
        redirect("/mail/send");
    }

    public function affichecommande()
    {
        $this->load->model("Model_user", '', true);
        $cmd= $this->Model_user->get_commande();
        $this -> load -> view('top');
        $this -> load -> view('boncommande', array('commande'=>$cmd));
        $this -> load -> view('bottom');
    }

    public function supprCommande($id)
    {
        $this->load->model("Model_user", '', true);
        $this->Model_user->supr_commande($id);
        $cmd= $this->Model_user->get_commande();

        echo json_encode($cmd);

    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */