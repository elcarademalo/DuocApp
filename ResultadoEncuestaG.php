<!DOCTYPE html>
<?php $title = 'Reportes'; ?>
<?php $currentPage = 'Reportes'; ?>
<?php include('head.php'); ?>
<?php include('nav-bar.php'); ?>
<?php include('conexion.php'); ?>


<body>
<div class="container-md d-flex justify-content-center" style="background-color:white" text-center py-5>
            <button onclick="history.go(-1);" id="Enviar" style="font-size: 25px">Volver </button>
        </div>
        <br>
<div class="container">
       <div class="row">
           <div class="col-lg-12">
           <a href="exportarDatos.php">Descargar</a>
            <table id="tablaUsuarios" class="table-striped table-bordered" style="width:100%">
		    <caption>Tabla usuarios</caption>
                <thead class="text-center">
                    <th scope="col">Fecha y Hora</th>
                    <th scope="col">Año</th>
                    <th scope="col">Codigo Encuesta</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Sección</th>
                    <th scope="col">Horario</th>
                    <th scope="col">Pregunta 1 </th>
                    <th scope="col">Respuesta 1</th>
                    <th scope="col">Pregunta 2</th>
                    <th scope="col">Respuesta 2</th>
                    <th scope="col">Pregunta 3</th>
                    <th scope="col">Respuesta 3</th>
                    <th scope="col">Comentario</th>
                </thead>
                <tbody>
                    <?php
                        $sql ="SELECT en.codigo_encuesta as coen, ut.username as un,
                        tiu.descripcion_usuario as us,
                        CONCAT( en.dia_encuesta,' ', en.hora_encuesta) AS hf,
                        substr(en.dia_encuesta,1,4) as anno,
                        en.seccion as sec,
                    CASE WHEN en.hora_encuesta < '18:00:00' THEN 'Diurno'
			             WHEN en.hora_encuesta > '18:00:00' THEN 'Vespertino' END as horario, 
                        en.pregunta1 as p1, 
                    CASE WHEN re.respuesta1 = 1 THEN 'Muy Desacuerdo' 
                         WHEN re.respuesta1 = 2 THEN 'En Desacuerdo' 
                         WHEN re.respuesta1 = 3 THEN 'Neutro' 
                         WHEN re.respuesta1 = 4 THEN 'De Acuerdo'  
                         WHEN re.respuesta1 = 5 THEN 'Muy Acuerdo' 
                         WHEN re.respuesta1 = 0 THEN 'Sin Responder'  end as r1,
                        en.pregunta2 as p2,
                    CASE WHEN re.respuesta2 = 1 THEN 'Muy Desacuerdo' 
                         WHEN re.respuesta2 = 2 THEN 'En Desacuerdo' 
                         WHEN re.respuesta2 = 3 THEN 'Neutro' 
                         WHEN re.respuesta2 = 4 THEN 'De Acuerdo'  
                         WHEN re.respuesta2 = 5 THEN 'Muy Acuerdo' 
                         WHEN re.respuesta1 = 0 THEN 'Sin Responder'   end as r2,
                        en.pregunta3 as p3,
                    CASE WHEN re.respuesta3 = 1 THEN 'Muy Desacuerdo' 
                         WHEN re.respuesta3 = 2 THEN 'En Desacuerdo' 
                         WHEN re.respuesta3 = 3 THEN 'Neutro' 
                         WHEN re.respuesta3 = 4 THEN 'De Acuerdo'  
                         WHEN re.respuesta3 = 5 THEN 'Muy Acuerdo' 
                         WHEN re.respuesta1 = 0 THEN 'Sin Responder'   end as r3,
                               re.comentario as com
                    FROM encuesta en
                        INNER JOIN respuesta_encuesta re on en.codigo_encuesta = re.id_encuestafk
                        INNER JOIN usertable ut on en.id_profesorfk = ut.username
                        INNER JOIN tipo_usuario tiu ON ut.tipo_usuario = tiu.id_tipo_usuario";
                        $result = mysqli_query($con,$sql);

                        while($sabana=mysqli_fetch_array($result))
                        {

                    ?>
                    <tr>
                        <td><?php echo $sabana['hf']?></td>
                        <td><?php echo $sabana['anno']?></td>
                        <td><?php echo $sabana['coen']?></td>
                        <td><?php echo $sabana['un']?></td>
                        <td><?php echo $sabana['us']?></td>
                        <td><?php echo $sabana['sec']?></td>
                        <td><?php echo $sabana['horario']?></td>
                        <td><?php echo $sabana['p1']?></td>
                        <td><?php echo $sabana['r1']?></td>
                        <td><?php echo $sabana['p2']?></td>
                        <td><?php echo $sabana['r2']?></td>
                        <td><?php echo $sabana['p2']?></td>
                        <td><?php echo $sabana['r3']?></td>
                        <td><?php echo $sabana['com']?></td>

                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
            <?php 
            if(isset($_POST["export_data"])) {
                if(!empty($result)) {
                $filename = "Sabana.xlxs";
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=".$filename);
               
                $mostrar_columnas = false;
               
                foreach($result as $sabana) {
                if(!$mostrar_columnas) {
                echo implode("\t", array_keys($sabana)) . "\n";
                $mostrar_columnas = true;
                }
                echo implode("\t", array_values($sabana)) . "\n";
                }
               
                }else{
                echo 'No hay datos a exportar';
                }
                exit;
               }
            ?>
           </div>
       </div> 
    </div>
   
    <?php
?>
    


</body>

</html>
