<?php
/**
 * Created by PhpStorm.
 * User: wap17
 * Date: 04/03/15
 * Time: 11:27
 */
class Model_user extends CI_Model
{
    public function get_users($name)
    {
        $sql = "SELECT * FROM users WHERE username='$name' OR email='$name' OR id='$name'";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }
        return $res;
    }

    public function create($name, $email, $password)
    {
        $sql="INSERT INTO users(username, email, password) VALUES (?, ?, ?)";
        $data=array($name, $email, $password);

        $this -> db -> query($sql, $data);
        return $this -> db -> insert_id();
    }

    public function get_product()
    {
        $sql = "SELECT * FROM product";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }
        return $res;
    }

    public function getone_product($id)
    {
        $sql = "SELECT * FROM product WHERE id='$id' OR name LIKE '$id%' ";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }

    public function getone_productid($id)
    {
        $sql = "SELECT * FROM product WHERE id='$id'";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }


    public function get_categorie($categ)
    {
        $sql = "SELECT * FROM product WHERE categorie='$categ'";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }

    public function getprice_categorie($ctg, $min, $max)
    {
        $sql = "SELECT * FROM product WHERE categorie='$ctg' AND prix <= $max AND prix >= $min";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }
    public function get_search($nm)
    {
        $sql = "SELECT * FROM product WHERE name='$nm'";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }

    public function getprice_searchProduct($ctg, $min, $max)
    {
        $sql = "SELECT * FROM product WHERE name LIKE '$ctg%' AND prix <= $max AND prix >= $min ";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }

    public function getprice_product($min, $max)
    {
        $sql = "SELECT * FROM product WHERE prix <= $max AND prix >= $min";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }

    public function getprice_max()
    {
        $sql = "SELECT MAX(prix) AS maxi FROM product";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }

    public function set_product($name, $description, $prix, $radio)
    {
        $sql="INSERT INTO product(name,description,prix,categorie) VALUES (?, ?, ?, ?)";
        $data=array($name, $description, $prix, $radio);

        $this -> db -> query($sql, $data);
        return $this -> db -> insert_id();
    }

    public function set_image($id_product, $jpeg)
    {
        $sql="INSERT INTO image (id_product,jpeg) VALUES (?, ?)";
        $data=array($id_product, $jpeg);

        $this -> db -> query($sql, $data);
    }

    public function get_image()
    {
        $sql = "SELECT * FROM image ";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }
        return $res;
    }

    public function getone_image($id)
    {
        $sql = "SELECT * FROM image WHERE id_product=$id ";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }
        return $res;
    }

    public function update_product($id, $quantity)
    {
        $sql = "UPDATE product SET quantity=$quantity WHERE id=$id";
        $query = $this->db->query($sql);
    }

    public function insert_comment($commentaire,$nbr,$idusers,$idproduct)
    {
        $sql="INSERT INTO comm(id_users,comment,id_product,nbretoile) VALUES (?, ?, ?, ?)";
        $data=array($idusers, $commentaire, $idproduct, $nbr);

        $this -> db -> query($sql, $data);
    }
    public function get_comment($id)
    {
        $sql = "SELECT c.comment, c.nbretoile FROM comm c JOIN product p ON c.id_product=p.id WHERE p.id='$id'";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }
    public function insert_commande($cmdname,$cmdprix,$cmdmult,$id)
    {
        $sql="INSERT INTO commande(id_users,name,prix,number) VALUES (?, ?, ?,?)";
        $data=array($id,$cmdname,$cmdprix,$cmdmult);

        $this -> db -> query($sql, $data);
    }
    public function get_commande()
    {
        $sql = "SELECT c.id,c.id_users,c.name,c.prix,c.number,u.username FROM commande c JOIN users u ON c.id_users=u.id";
        $query = $this->db->query($sql);
        $res = array();
        foreach ($query->result_array() as $row)
        {
            $res[] = $row;
        }

        return $res;
    }
    public function supr_commande($id)
    {
        $sql="DELETE FROM commande WHERE id=$id";

        $query = $this->db->query($sql);

    }
}