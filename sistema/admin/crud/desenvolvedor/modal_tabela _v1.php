<?php  


  //FUNÇÃO EXCLUSIVA DA TABELA------------>
  //ATUALIZA OS PRODUTOS EDITADOS NA TABELA
$input = filter_input_array(INPUT_POST);
if (isset($input['action'])) { 
    if($input['action'] == 'edit'){
  $update_field='';
  if(isset($input['produto'])) {
    $update_field.= "produto='".$input['produto']."'";
} else if(isset($input['tipo_produto'])) {
    $update_field.= "tipo_produto='".$input['tipo_produto']."'";
} else if(isset($input['genero'])) {
    $update_field.= "genero='".$input['genero']."'";
} else if(isset($input['imagem'])) {
    $update_field.= "imagem='".$input['imagem']."'";
} else if(isset($input['referencia'])) {
    $update_field.= "referencia='".$input['referencia']."'";
} 
if($update_field && $input['id']) {
    $sql_query = "UPDATE produtos SET $update_field WHERE id='" . $input['id'] . "'"; 
    mysqli_query($conexao, $sql_query) or die("database error:". mysqli_error($conexao));   
}
}}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- ==================================================== Tabela editavel php mysql======================================================== -->
<div class="card "> <!-- collapsed-card -->
<div class="card-header">
<h3 class="card-title">Todos Produtos em Estoque</h3>
<div class="card-tools">
    <button type="button" class="btn btn-tool collapsed-box" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
</div></div>
<div class="card-body p-0 " >
    <div class="row" style="margin-left:20px; margin-right: 20px; margin-top: 10px; margin-bottom: -10px;">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="margin-right: 5px;">Adicionar</button>
        <button type="button" id="deletar" class="btn btn-danger" style="margin-right: 5px;">Deletar</button>
        <input type="text" id="search" class="form-control input-group-lg reg_name" placeholder="&#xF002; Pesquisar Produto" style="font-family:Arial, FontAwesome; max-width: 300px; margin-left: auto; margin-right: 0;">
    </div>

    <div class="card-body">
        <table id="example1" class="table table-bordered "> <!--<table id="data_table"  class="table table-bordered table-striped">-->

            <?php
            $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
            $q = $pdo->prepare("DESCRIBE produtos");
            $q->execute();
            $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
            echo '
            <tr>
            <th style="color: black;" onclick="sortTable(0)">'.$table_fields[0].'</th>
            <th style="color: black;" onclick="sortTable(1)">'.$table_fields[1].'</th>
            <th style="color: black;" onclick="sortTable(2)">'.mb_strimwidth($table_fields[2],0,4).'</th>
            <th style="color: black;" onclick="sortTable(3)">'.$table_fields[3].'</th>
            <th style="color: black;" onclick="sortTable(4)">'.$table_fields[4].'</th>
            <th style="color: black;" onclick="sortTable(5)">'.mb_strimwidth($table_fields[5],0,8).'</th>
            <th style="color: black;" onclick="sortTable(6)">'.$table_fields[6].'</th>
            <th style="color: black;" onclick="sortTable(7)">'.$table_fields[7].'</th>
            <th style="color: black;" onclick="sortTable(8)">'.mb_strimwidth($table_fields[8],0,6).'</th>
            <th style="color: black;" onclick="sortTable(9)">'.$table_fields[9].'</th>
            <th style="color: black;" onclick="sortTable(10)">'.$table_fields[10].'</th>
            <th style="color: black;" onclick="sortTable(11)">'.mb_strimwidth($table_fields[11],0,5).'</th>
            <th style="color: black;" onclick="sortTable(12)">'.$table_fields[12].'</th>
            </tr>
            ';


            $sql = "SELECT * FROM produtos ORDER BY produto ASC";
            foreach($pdo->query($sql)as $row){
                echo '

                <tr>
                <td style="color: black;">'.$row['id'].'</td>
                <td style="color: black;">'.$row['produto'].'</td>
                <td style="color: black;">'.$row['tipo_produto'].'</td>
                <td style="color: black;">'.$row['genero'].'</td>
                <td style="color: black;">'.$row['imagem'].'</td>
                <td style="color: black;">'.$row['referencia'].'</td>
                <td style="color: black;">'.$row['cor'].'</td>
                <td style="color: black;">'.$row['tamanho'].'</td>
                <td style="color: black;">'.$row['codigo_barra'].'</td>
                <td style="color: black;">'.$row['valor'].'</td>
                <td style="color: black;">'.$row['lote'].'</td>
                <td style="color: black;">'.$row['quantidade'].'</td>
                <td style="color: black;">'.$row['data'].'</td>
                </tr>
                ';
            };
            database::desconectar();
            ?>
        </table>
    </div>



<script type="text/javascript">
// usando no th faz com que a table seja clicada no indice para mudar os valores onclick="sortTable(0)"
function sortTable(n) {
var table,
rows,
switching,
i,
x,
y,
shouldSwitch,
dir,
switchcount = 0;
table = document.getElementById("example1");
switching = true;
dir = "asc";
while (switching) {
switching = false;
rows = table.getElementsByTagName("TR");
for (i = 1; i < rows.length - 1; i++) {
shouldSwitch = false;
x = rows[i].getElementsByTagName("TD")[n];
y = rows[i + 1].getElementsByTagName("TD")[n];
if (dir == "asc") {
if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
  shouldSwitch = true;
  break;
}
} else if (dir == "desc") {
if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
  shouldSwitch = true;
  break;
}
}
}
if (shouldSwitch) {
rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
switching = true;
switchcount++;
} else {
if (switchcount == 0 && dir == "asc") {
dir = "desc";
switching = true;
}
}
}
}

</script>






<script type="text/javascript">
//SISTEMA DE PESQUISA DAS TABELAS
var $rows = $('#example1 tr');
$('#search').keyup(function() {
var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

$rows.show().filter(function() {
    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    return !~text.indexOf(val);
}).hide();
});
</script>







<script type="text/javascript">
    //FUNÇÃO QUE PERMITE EDIÇÃO DAS TABELAS ESTILO LIVE EDIT
    $(document).ready(function(){
        $('#example1').Tabledit({
            deleteButton: false,
            editButton: false,      
            columns: {
                identifier: [0, 'id'],                    
                editable: [[1, 'produto'], [2, 'tipo_produto'], [3, 'genero'], [4, 'imagem'], [5, 'referencia'], [6, 'cor'], [7, 'tamanho'], [8, 'codigo_barra'], [9, 'valor'], [10, 'lote'], [11, 'quantidade'], [12, 'data']]
            },
            hideIdentifier: false,
            url: 'index.php'    
        });
    });
</script>



<script type="text/javascript">
    //FUNÇÃO PARA CLICAR E EXTRAIR O VALOR DA ID DE UMA LINHA DA TABELA
    //SE CLICAR NA TABELA JA EXECUTA A FUNÇÃO --- DESCOMENTAR AS LINHAS PARA ELA FUNCIONAR
    $("#example1  tr").click(function(){
        $(this).addClass('selected').siblings().removeClass('selected');    
    //var value=$(this).find('td:first').html();
    //alert(value);    
});


    //NECESSARIO CLICAR NA TABELA DEPOIS NO BOTAO PARA EXECUTAR A FUNÇAO
    $('#deletar').on('click', function(e){
        var valor=$("#example1 tr.selected td:first").html();
    //alert(valor);
    var resultado=valor.split(">", 2);
    var resultado_final =resultado[1].split("<",1);
    var confirmar = confirm("Quer deletar a linha "+resultado_final+"?");
    if (confirmar == true) {
    //alert("O item  será excluído da lista!");  
    window.location = "index.php?deletar="+ resultado_final;  
}
else{
    alert("Você desistiu de excluir o item  da lista!");
}
});



    //sistema de paginação 
    $(document).ready(function(){
        $('#example1').after('<div  class="card-footer clearfix"><ul id="nav"class="pagination pagination-sm m-0 float-right"></ul></div>');
        var rowsShown = 10;
        var rowsTotal = $('#example1 tbody tr').length;
        var numPages = rowsTotal/rowsShown;
        for(i = 0;i < numPages;i++) {
            var pageNum = i + 1;
            $('#nav').append('<a href="#" class="page-link" rel="'+i+'">'+pageNum+'</a> ');
        }
        $('#example1 tbody tr').hide();
        $('#example1 tbody tr').slice(0, rowsShown).show();
        $('#nav a:first').addClass('active');
        $('#nav a').bind('click', function(){

            $('#nav a').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('#example1 tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
            css('display','table-row').animate({opacity:1}, 300);
        });
    });
</script>





<style type="text/css">
td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}
.selected {
    background-color:   #F5F5F5;
    color: #FFF;
}
#example1 tr {
    display: none;
}
</style>
