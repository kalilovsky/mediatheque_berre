<?php

namespace Controller;

class LoansController extends Controller
{
    protected $modelName = "LoansModel";

    public function index()
    {
        return ("Api introuvable, veuillez réessayer svp.");
    }

    public function addLoans()
    {
        if(isset($_SESSION["idUser"])){
            $args = array(
                'idUser' => FILTER_VALIDATE_INT,
                'idArticle' => FILTER_VALIDATE_INT,
            );
            $data = filter_input_array(INPUT_POST,$args);
            if($this->model->insert($data)){
                $articleLoaned = $this->model->getAll("WHERE idArticle = ".$data['idArticle'],'articles');
                $idArticle["idArticle"]=$data['idArticle'];
                if($articleLoaned[0]['stock']>0){
                    $data2['stock'] = $articleLoaned[0]["stock"] - 1;
                    $updateArticle = $this->model->update($data2,$idArticle,'articles');
                    $updateArticle["message"] = "Article emprunté correctement";
                    echo(json_encode($updateArticle));
                }else{
                    $updateArticle["message"] = "Stock de l'article insuffisant!";
                    echo(json_encode($updateArticle));
                }
            }else{
                echo (json_encode("Problème lors de l'emprunt."));
            }
        }else{
            echo(json_encode("Not Authorised."));
        }
    }

    public function getAllLoansByUser(){
        if(isset($_SESSION["idUser"])){
            $idUser = filter_input(INPUT_POST,"idUser",FILTER_VALIDATE_INT);
            echo(json_encode($this->model->getAll("INNER JOIN (SELECT articles.*, subcategories.SubcategorieName,categories.categorieName FROM articles INNER JOIN categories ON  categories.idCategorie = articles.idCategory INNER JOIN subcategories ON subcategories.idSubCategorie = articles.idSubCategorie ) AS a ON loans.idArticle = a.idArticle WHERE loans.idUser = ".$idUser)));
        
        }else{
            echo(json_encode("Not Authorised."));
        }
    }
    public function getAllLoans(){
        if(isset($_SESSION["idUser"])){
        
            $idUser = filter_input(INPUT_POST,"idUser",FILTER_VALIDATE_INT);
            echo(json_encode($this->model->customQuery("SELECT * ,DATEDIFF(CURRENT_TIMESTAMP,loansDate) as duration FROM loans INNER JOIN (SELECT articles.*, subcategories.SubcategorieName,categories.categorieName FROM articles INNER JOIN categories ON  categories.idCategorie = articles.idCategory INNER JOIN subcategories ON subcategories.idSubCategorie = articles.idSubCategorie ) AS a ON loans.idArticle = a.idArticle INNER JOIN users ON users.idUser = loans.idUser")));
        }else{
            echo(json_encode("Not Authorised."));
        }
    }
    public function getAllPendingLoans(){
        if(isset($_SESSION["idUser"])){
            $idUser = filter_input(INPUT_POST,"idUser",FILTER_VALIDATE_INT);
            $query = "SELECT * ,DATEDIFF(CURRENT_TIMESTAMP,loansDate) as duration FROM loans INNER JOIN (SELECT articles.*, subcategories.SubcategorieName,categories.categorieName FROM articles INNER JOIN categories ON  categories.idCategorie = articles.idCategory INNER JOIN subcategories ON subcategories.idSubCategorie = articles.idSubCategorie ) AS a ON loans.idArticle = a.idArticle INNER JOIN users ON users.idUser = loans.idUser WHERE loans.status ='encours'";
            if ($idUser>0){
                $query .= " AND loans.idUser =".$idUser;
            }
            echo(json_encode($this->model->customQuery($query)));
        
        }else{
            echo(json_encode("Not Authorised."));
        }
    }
    public function getAllFinishedLoans(){
        if(isset($_SESSION["idUser"])){
            $idUser = filter_input(INPUT_POST,"idUser",FILTER_VALIDATE_INT);
            $query = "SELECT * ,DATEDIFF(CURRENT_TIMESTAMP,loansDate) as duration FROM loans INNER JOIN (SELECT articles.*, subcategories.SubcategorieName,categories.categorieName FROM articles INNER JOIN categories ON  categories.idCategorie = articles.idCategory INNER JOIN subcategories ON subcategories.idSubCategorie = articles.idSubCategorie ) AS a ON loans.idArticle = a.idArticle INNER JOIN users ON users.idUser = loans.idUser WHERE loans.status ='rendu'";
            if ($idUser>0){
                $query .= " AND loans.idUser =".$idUser;
            }
            echo(json_encode($this->model->customQuery($query)));
        
        }else{
            echo(json_encode("Not Authorised."));
        }
    }

    public function getLateLoans(){
        if(isset($_SESSION["idUser"])){
            $idUser = filter_input(INPUT_POST,"idUser",FILTER_VALIDATE_INT);
            $query = "SELECT * ,DATEDIFF(CURRENT_TIMESTAMP,loansDate) as duration FROM loans INNER JOIN (SELECT articles.*, subcategories.SubcategorieName,categories.categorieName FROM articles INNER JOIN categories ON  categories.idCategorie = articles.idCategory INNER JOIN subcategories ON subcategories.idSubCategorie = articles.idSubCategorie ) AS a ON loans.idArticle = a.idArticle INNER JOIN users ON users.idUser = loans.idUser WHERE DATEDIFF(CURRENT_TIMESTAMP,loans.loansDate) >a.loanDuration AND loans.status = 'encours'";
            if ($idUser>0){
                $query .= " AND loans.idUser =".$idUser;
            }
            echo(json_encode($this->model->customQuery($query)));
        
        }else{
            echo(json_encode("Not Authorised."));
        }
    }
    
    public function getCountLoans(){
        $idUser = filter_input(INPUT_POST,"idUser",FILTER_VALIDATE_INT);
        echo(json_encode($this->model->countAll($idUser)));
    }

    public function checkLateLoansByUser(){

    }

    public function returnLoan(){
        if(isset($_SESSION["idUser"])){
        
            $args = array(
                'idLoan'=> FILTER_VALIDATE_INT,
                'idUser' => FILTER_VALIDATE_INT,
                'idArticle' => FILTER_VALIDATE_INT,
            );
            $data = filter_input_array(INPUT_POST,$args);
            if (count($this->model->getAll("WHERE idLoan=".$data['idLoan']." AND idArticle=".$data['idArticle']))===1){
                $article = $this->model->getAll("WHERE idArticle=".$data['idArticle'],"articles");
                $data1["stock"]=$article[0]["stock"] + 1;
                $idArticle["idArticle"] = $data['idArticle'];
                $idLoan["idLoan"]=$data['idLoan'];
                $data2["status"]="rendu";
                $data2["updateDateLoan"]=date('Y-m-d H:i:s');
                $updateArticle = $this->model->update($data1,$idArticle,'articles');
                $updateLoan = $this->model->update($data2,$idLoan);
                if(!is_null($updateArticle) && !is_null($updateLoan)){
                    $updateLoan["message"]="Article rendu";
                    echo json_encode($updateLoan);
                }
            }
        }else{
            echo(json_encode("Not Authorised."));
        }
    }

}
