<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class User extends CI_Controller {

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
    public function login()
    {
        $this -> load -> view('top');
        $this->load -> view('logview');
        $this -> load -> view('bottom');
        if(empty($_POST)==false)
        {
            $this -> load -> model("Model_user",'',true);
            $users = $this -> Model_user -> get_users($_POST['username']);
            if($users)
            {

                if (password_verify($_POST["password"], $users[0]["password"]))
                {
                    $_SESSION['login']=$_POST['username'];
                    $_SESSION['id']=$users[0]['id'];
                }
                else
                {
                    $_SESSION["error"] = "Invalid password";
                }
            }

            else
            {
                $_SESSION["error"] = "Unknown user";
            }

            redirect("/home");
        }
    }

    public function logout()
    {
        session_destroy();
        redirect("/home");
    }

    public function account()
    {
        $this->load->view('accountview');
        if(empty($_POST)==false)
        {
            $name=$_POST['username'];
            $email=$_POST['email'];
            $password= password_hash($_POST["password"], PASSWORD_DEFAULT);
            $this -> load -> model("Model_user",'',true);
            $id=$this -> Model_user -> create($name, $email, $password);
            $_SESSION['login']= $name;
            $_SESSION['id']= $id;
            redirect("/home");
        }
    }

    public function ajoutProduct()
    {
        $this ->load->view('top');
        $this -> load -> view('product');
        $this ->load->view('bottom');
        if(empty($_POST['title'])==false && empty($_POST['comment'])==false)
        {
            $name = $_POST['title'];
            $description = $_POST['comment'];
            $prix = $_POST['price'];
            $radio = $_POST['radio'];

            $this->load->model("Model_user", '', true);
            $idproduct = $this->Model_user->set_product($name, $description, $prix, $radio);

            if (empty($_FILES['fichier']["tmp_name"]) == false)
            {
                for ($i = 0; $i < sizeof($_FILES['fichier']["tmp_name"]); $i++)
                {
                    move_uploaded_file($_FILES["fichier"]["tmp_name"][$i], "picture/" . uniqid() . "image.jpg");
                }
                $fileList = scandir("picture");
                $this->load->model("Model_user", '', true);
                $img = $this->Model_user->get_image();
                $tab = array();
                for ($j = 0; $j < sizeof($img); $j++)
                {
                    $tab[$j] = $img[$j]['jpeg'];
                }
                $result = array_diff($fileList, $tab);
                foreach ($result as $valu) {
                    if ($valu[0] != ".") {
                        $this->Model_user->set_image($idproduct, $valu);
                    }
                }

            }
            redirect("/home");
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */