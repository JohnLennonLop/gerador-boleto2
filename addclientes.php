<?php

ob_start();
require('./sheep_core/config.php');
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head >
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Teste</title>
        <link rel="stylesheet" href="assets/css/app.min.css">
      
        <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>


<!-- Main Content -->
<div align="center" style="padding:20px; margin-top:120px;" >
 
        <div class="col-md-10"> 
      <section class="section" >


            <!-- inicio topo menu -->
            <?php
            
            require_once('topo.php');

            ?>
      
            <!-- fim topo menu -->


           <br>
         <!-- inicio formulario  topo menu -->
          <form action="filtros/criar.php" method="post" enctype="multipart/form-data">


         <div class="section-body" >
          <div class="row" >
            <div class="col-md-12">
              <div class="card">
                  
                    
                <div class="card-header">
                  <h4>Gerar Boletos</h4><br>
                 
                </div>
                <div class="card-body">
         
                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                      <input type="text" class="form-control" name="nome" placeholder="Nome Completo">
                    </div>
                    
                  </div>

                  <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="email" class="form-control" name="email" placeholder="e-mail">
                   </div>
                   
                 </div>

                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="fone" placeholder="Telefone">
                   </div>
                   
                 </div>
                 <div class="form-group row mb-4">
                   
                   <div class="col-md-12">
                     <input type="text" class="form-control" name="cpf" placeholder="CPF">
                   </div>
                   
                 </div>

                  
                  <div class="form-group row mb-4">
                   
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-lg btn-primary"  style="width:100%;" name="gerarBoleto" >Gerar</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            </form>
      <!-- fim formulario  topo menu -->
      </section>
      </div>
        
       
    </div>

  <script src="assets/js/custom.js"></script>

 
  

</body>
</html>

<?php
ob_end_flush();
?>