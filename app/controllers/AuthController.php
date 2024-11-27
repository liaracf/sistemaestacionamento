<?php

namespace App\Controllers;

use Core\Controller;
use Core\Database;

class AuthController extends Controller
{

  public function entrada(){

    if($_SERVER['REQUEST_METHOD'] === "POST"){
      $nome = $_POST['nome'];
      $placa = $_POST['placa'];
      $data = date('Y-m-d H:i:s');
      
      $db = Database::connect();

      $stm = $db->prepare("INSERT INTO registro (nome, data, placa) VALUES (:nome, :data, :placa)");
      
      

      $stm->bindParam(":nome", $nome);
      $stm->bindParam(":data", $data);
      $stm->bindParam(":placa", $placa);
      
     
      
        if($stm->execute()) {
          $this->redirect('/');
        }

    }
    $this->view('/auth/entrada');
  }
  public function sair()
  {
      
      $this->view('/auth/sair');
  
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          
          $placa = $_POST['placa'] ?? null; 
          $sair = date('Y-m-d H:i:s'); 
  
          if (!empty($placa)) {
              try {
                 
                 $db = Database::connect();
  
                 
                  $stm = $db->prepare("UPDATE registro SET sair = :sair WHERE placa = :placa");
                  $stm->bindParam(":placa", $placa);
                  $stm->bindParam(":sair", $sair);
  
                  
                  if ($stm->execute()) {
                      
                      $this->redirect('/pagamento');
                  } else {
                      echo "Erro ao registrar a saída. Por favor, tente novamente.";
                  }
              } catch (PDOException $e) {
                 
                  echo "Erro no banco de dados: " . $e->getMessage();
              }
          } else {
              echo "placa n existe filhao";
          }
      }
  }
  
    public function pagamento()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $placa = $_POST['placa']; 
        $valorPorHora = 11.00;   

        try {
            $db = Database::connect();

            
            $sql = "SELECT data, sair FROM registro WHERE placa = :placa";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':placa', $placa);
            $stmt->execute();

           
            $registro = $stmt->fetch(); 

            
            if ($registro) {
                
                if (!empty($registro['data']) && !empty($registro['sair'])) {
                   
                    $data = \DateTime::createFromFormat('Y-m-d H:i:s', $registro['data']);
                    $sair = \DateTime::createFromFormat('Y-m-d H:i:s', $registro['sair']);

                   
                    if ($data && $sair) {
                       
                        $intervalo = $data->diff($sair);
                        $horas = $intervalo->days * 24 + $intervalo->h + ($intervalo->i / 60);

                        
                        $valor = ceil($horas) * $valorPorHora;

                        
                        $sqlUpdate = "UPDATE registro SET valor = :valor WHERE placa = :placa";
                        $stmtUpdate = $db->prepare($sqlUpdate);
                        $stmtUpdate->bindParam(':valor', $valor);
                        $stmtUpdate->bindParam(':placa', $placa);

                        
                        if ($stmtUpdate->execute()) {
                            echo "Obrigado por utilizar nosso estacionamento!<br>";
                            echo "SUPERMERCADO 20 IRMÃOS agradece! :)<br>";
                            echo "Valor: R$ " . number_format($valor, 2, ',', '.');
                        } else {
                            echo "Erro ao atualizar o valor no banco de dados, ó :(.";
                        }
                    } else {
                        echo "Formato de data inválido para a entrada ou saída.";
                    }
                } else {
                    echo "Datas de entrada ou saída estão vazias.";
                }
            } else {
                echo "Nenhum registro encontrado para a placa informada.";
            }
        } catch (PDOException $e) {
            echo "Erro no banco de dados: " . $e->getMessage();
        }
    }

    $this->view('auth/pagamento');
  
  }

}