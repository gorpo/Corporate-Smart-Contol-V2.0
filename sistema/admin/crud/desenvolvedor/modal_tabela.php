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
} else if(isset($input['cor'])) {
    $update_field.= "cor='".$input['cor']."'";
} else if(isset($input['tamanho'])) {
    $update_field.= "tamanho='".$input['tamanho']."'";    
} else if(isset($input['codigo_barra'])) {
    $update_field.= "codigo_barra='".$input['codigo_barra']."'";    
} else if(isset($input['valor'])) {
    $update_field.= "valor='".$input['valor']."'";    
} else if(isset($input['lote'])) {
    $update_field.= "lote='".$input['lote']."'";    
} else if(isset($input['quantidade'])) {
    $update_field.= "quantidade='".$input['quantidade']."'";    
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
</div></div>
<div class="card-body p-0 " >
    <div class="row" style="margin-left:20px; margin-right: 20px; margin-top: 10px; margin-bottom: -10px;">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default" style="margin-right: 5px;">Adicionar</button>
        <button type="button" id="deletar" class="btn btn-danger" style="margin-right: 5px;">Deletar</button>
        <input type="text" id="search" class="form-control input-group-lg reg_name" placeholder="&#xF002; Pesquisar Produto" style="font-family:Arial, FontAwesome; max-width: 300px; margin-left: auto; margin-right: 0;">
        </div>

  <div id="DataTable" >
  <div id="table_box_bootstrap"></div>
        <table id="example1" >
    <thead>
        <tr> <!--<table id="data_table"  class="table table-bordered table-striped">-->

            <?php
            $pdo = Database::conectar($dbNome='csc_'.$_SESSION['email_cliente']);
            $q = $pdo->prepare("DESCRIBE produtos");
            $q->execute();
            $table_fields = $q->fetchAll(PDO::FETCH_COLUMN);
            echo '
            <th>'.$table_fields[0].'</th>
            <th>'.$table_fields[1].'</th>
            <th>'.mb_strimwidth($table_fields[2],0,4).'</th>
            <th>'.$table_fields[3].'</th>
            <th>'.$table_fields[4].'</th>
            <th>'.mb_strimwidth($table_fields[5],0,8).'</th>
            <th>'.$table_fields[6].'</th>
            <th>'.$table_fields[7].'</th>
            <th>'.mb_strimwidth($table_fields[8],0,6).'</th>
            <th>'.$table_fields[9].'</th>
            <th>'.$table_fields[10].'</th>
            <th>'.mb_strimwidth($table_fields[11],0,5).'</th>
            <th>'.$table_fields[12].'</th>
            </tr></thead>
            <tbody class="scroll-pane">
        <tr>
            ';


            $sql = "SELECT * FROM produtos ORDER BY produto ASC";
            foreach($pdo->query($sql)as $row){
                echo '
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
       </tbody> </table>
    </div></div>




<style type="text/css">

/* FAZ A TABELA FICAR COM TAMANHO FIXO */    
/*table {
table-layout: fixed;
}
table td, table th {
  overflow: hidden;
  white-space: nowrap;
  -moz-text-overflow: ellipsis;
  -ms-text-overflow: ellipsis;
  -o-text-overflow: ellipsis;
  text-overflow: ellipsis;
}*/



/*SISTEMA DE COR QUANDO SELECIONADO PARA MARCAR O ITEM Q VAI DELETAR */
td {border: 1px #DDD solid; padding: 5px; cursor: pointer;}

.selected:nth-of-type(odd) { 
  background: #e32636; 
}

.selected {
    background-color:   #e32636;
    color: red;
}
#example1 tr {
    /*display: none;*/
}
</style>


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

var box = paginator({
    table: document.getElementById("DataTable").getElementsByTagName("table")[0],
    box_mode: "list",
});
box.className = "box";
document.getElementById("table_box_bootstrap").appendChild(box);


function paginator(config) {
    // throw errors if insufficient parameters were given
    if (typeof config != "object")
        throw "Paginator was expecting a config object!";
    if (typeof config.get_rows != "function" && !(config.table instanceof Element))
        throw "Paginator was expecting a table or get_row function!";

    // get/make an element for storing the page numbers in
    var box;
    if (!(config.box instanceof Element)) {
        config.box = document.createElement("div");
    }
    box = config.box;

    // get/make function for getting table's rows
    if (typeof config.get_rows != "function") {
        config.get_rows = function () {
            var table = config.table
            var tbody = table.getElementsByTagName("tbody")[0]||table;

            // get all the possible rows for paging
            // exclude any rows that are just headers or empty
            children = tbody.children;
            var trs = [];
            for (var i=0;i<children.length;i++) {
                if (children[i].nodeType = "tr") {
                    if (children[i].getElementsByTagName("td").length > 0) {
                        trs.push(children[i]);
                    }
                }
            }

            return trs;
        }
    }
    var get_rows = config.get_rows;
    var trs = get_rows();

    // get/set rows per page
    if (typeof config.rows_per_page == "undefined") {
        var selects = box.getElementsByTagName("select");
        if (typeof selects != "undefined" && (selects.length > 0 && typeof selects[0].selectedIndex != "undefined")) {
            config.rows_per_page = selects[0].options[selects[0].selectedIndex].value;
        } else {
            config.rows_per_page = 10;
        }
    }
    var rows_per_page = config.rows_per_page;

    // get/set current page
    if (typeof config.page == "undefined") {
        config.page = 1;
    }
    var page = config.page;

    // get page count
    var pages = (rows_per_page > 0)? Math.ceil(trs.length / rows_per_page):1;

    // check that page and page count are sensible values
    if (pages < 1) {
        pages = 1;
    }
    if (page > pages) {
        page = pages;
    }
    if (page < 1) {
        page = 1;
    }
    config.page = page;
 
    // hide rows not on current page and show the rows that are
    for (var i=0;i<trs.length;i++) {
        if (typeof trs[i]["data-display"] == "undefined") {
            trs[i]["data-display"] = trs[i].style.display||"";
        }
        if (rows_per_page > 0) {
            if (i < page*rows_per_page && i >= (page-1)*rows_per_page) {
                trs[i].style.display = trs[i]["data-display"];
            } else {
                trs[i].style.display = "none";
            }
        } else {
            trs[i].style.display = trs[i]["data-display"];
        }
    }
    // page button maker functions
    config.active_class = config.active_class||"active";
    if (typeof config.box_mode != "function" && config.box_mode != "list" && config.box_mode != "buttons") {
        config.box_mode = "button";
    }
    if (typeof config.box_mode == "function") {
        config.box_mode(config);
    } else {
        var make_button;
        if (config.box_mode == "list") {
            make_button = function (symbol, index, config, disabled, active) {
                var li = document.createElement("li");
                var a  = document.createElement("a");
                a.href = "#";
                a.innerHTML = symbol;
                a.className = "page-link"
                //abaixo move a altura dos botoes de enumeração de pagina da tabela editavel
                //a.style = "margin-top: 500px;"
                
                a.addEventListener("click", function (event) {
                    event.preventDefault();
                    this.parentNode.click();
                    return false;
                }, false);
                li.appendChild(a);

                var classes = [];
                if (disabled) {
                    classes.push("disabled");
                }
                if (active) {
                    classes.push(config.active_class);
                }
                li.className = classes.join(" ");
                li.addEventListener("click", function () {
                    if (this.className.split(" ").indexOf("disabled") == -1) {
                        config.page = index;
                        paginator(config);
                    }
                }, false);
                return li;
            }
        } else {
            make_button = function (symbol, index, config, disabled, active) {
                var button = document.createElement("button");
                button.innerHTML = symbol;
                button.addEventListener("click", function (event) {
                    event.preventDefault();
                    if (this.disabled != true) {
                        config.page = index;
                        paginator(config);
                    }
                    return false;
                }, false);
                if (disabled) {
                    button.disabled = true;
                }
                if (active) {
                    button.className = config.active_class;
                }
                return button;
            }
        }

        // make page button collection
        var page_box = document.createElement(config.box_mode == "list"?"ul":"div");
        if (config.box_mode == "list") {
            page_box.className = "pagination";
        }

        var left = make_button("&laquo;", (page>1?page-1:1), config, (page == 1), false);
        page_box.appendChild(left);

        for (var i=1;i<=pages;i++) {
            var li = make_button(i, i, config, false, (page == i));
            page_box.appendChild(li);
        }

        var right = make_button("&raquo;", (pages>page?page+1:page), config, (page == pages), false);
        page_box.appendChild(right);
        if (box.childNodes.length) {
            while (box.childNodes.length > 1) {
                box.removeChild(box.childNodes[0]);
            }
            box.replaceChild(page_box, box.childNodes[0]);
        } else {
            box.appendChild(page_box);
        }
    }
  
  var dvRecords = document.createElement("div");
  dvRecords.className = "dvrecords";
  box.appendChild(dvRecords);

    // make rows per page selector
    if (!(typeof config.page_options == "boolean" && !config.page_options)) {
        if (typeof config.page_options == "undefined") {
            config.page_options = [
                { value: 5,  text: '5'   },
                { value: 10, text: '10'  },
                { value: 20, text: '20'  },
                { value: 50, text: '50'  },
                { value: 100,text: '100' },
                { value: 0,  text: 'All' }
            ];
        }
        var options = config.page_options;
        var select = document.createElement("select");
        select.className = "records";
        for (var i=0;i<options.length;i++) {
            var o = document.createElement("option");
            o.value = options[i].value;
            o.text = options[i].text;
            select.appendChild(o);
        }
        select.value = rows_per_page;
        select.addEventListener("change", function () {
            config.rows_per_page = this.value;
            paginator(config);
        }, false);
        dvRecords.appendChild(select);
    }

    // status message
    var stat = document.createElement("span");
    stat.className = "stats";
    stat.innerHTML = "Página " + page + " de " + pages
        + ", mostrando dados " + (((page-1)*rows_per_page)+1)
        + " de " + (trs.length<page*rows_per_page||rows_per_page==0?trs.length:page*rows_per_page)
        + " do total de " + trs.length + " | Clique sobre a id para selecionar e sobre os campos para editar";
    
    dvRecords.appendChild(stat);

    // run tail function
    if (typeof config.tail_call == "function") {
        config.tail_call(config);
    }
    return box;
}


//FUNÇÃO QUE PERMITE O SORT DOS PRODUTOS CLICANDO NO TOPO DAS TABELAS
/*jQuery.fn.sortElements = (function(){
    
    var sort = [].sort;
    
    return function(comparator, getSortable) {
        
        getSortable = getSortable || function(){return this;};
        
        var placements = this.map(function(){
            
            var sortElement = getSortable.call(this),
                parentNode = sortElement.parentNode,
                
                // Since the element itself will change position, we have
                // to have some way of storing it's original position in
                // the DOM. The easiest way is to have a 'flag' node:
                nextSibling = parentNode.insertBefore(
                    document.createTextNode(''),
                    sortElement.nextSibling
                );
            
            return function() {
                
                if (parentNode === this) {
                    throw new Error(
                        "You can't sort elements if any one is a descendant of another."
                    );
                }
                
                // Insert before flag:
                parentNode.insertBefore(this, nextSibling);
                // Remove flag:
                parentNode.removeChild(nextSibling);
                
            };
            
        });
       
        return sort.call(this, comparator).each(function(i){
            placements[i].call(getSortable.call(this));
        });
        
    };
})();

    var table = $('table');
    
    $('th')
        .wrapInner('<span title="sort this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
                
        });*/
</script>





<style type="text/css">
    /*
    Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
    */

body {
  counter-reset: my-sec-counter;
  
}

#DataTable {
  position:relative;
  padding: 15px;
  box-sizing: border-box;
}

table { 
  width: 100%; 
  border-collapse: collapse; 
}

th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
  cursor: cell;
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
  box-sizing: border-box;
}


/* aqui é o cinza sim cinza nao da tabela */
tr:nth-of-type(odd) { 
  background: #eee; 
}

    @media
      only screen 
    and (max-width: 760px), (min-device-width: 768px) 
    and (max-device-width: 1024px)  {

      table {
        margin-top: 106px;
      }
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

    tr {
      margin: 0 0 1rem 0;
      overflow: auto;
      border-bottom: 1px solid #ccc;
    }
      
      
      
      tbody tr:before {
        counter-increment: my-sec-counter;
        content: "";
        background-color:#333;
        display: block;
        height: 1px;
      }

      
    tr:nth-child(odd) {
      background: #ccc;
    }
    
        td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
      margin-right: 0%;
      display: block;
      border-right: 1px solid #ccc;
      border-left: 1px solid #ccc;
      box-sizing:border-box;
        }

        td:before {
            /* Top/left values mimic padding */
      font-weight: bold;
            width: 50%;
      float:left;
      box-sizing:border-box;
      padding-left: 5px;
        }

        /*
        Label the data
    You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
        */
     
    .box ul.pagination {
      position: relative !important;
      bottom: auto !important;
      right: auto !important;
      display: block !important;
      width: 100%;
    } 
      
    .box {
      text-align: center;
      position: fixed;
      width: 100%;
      background-color: #fff;
      top: 0px;
      left:0px;
      padding: 15px;
      box-sizing: border-box;
      border-bottom: 1px solid #ccc;
    }
      
    .box ul.pagination {
      display: block;
      margin: 0px;
    }
      
     .box .dvrecords {
      display: block;
       margin-bottom: 10px;
    }
    .pagination>li {
        display: inline-block;
    }
    }


.top-filters {
  font-size: 0px;
}

.search-field {
  text-align: right;
  margin-bottom: 5px;
}

.dd-number-of-recoeds {
  font-size: 12px;
}

.search-field,
.dd-number-of-recoeds {
  display: inline-block;
  width: 50%;
}

.box ul.pagination {
  position: absolute;
  bottom: -50px;
  right: 15px;
}

.box .dvrecords {
  padding: 5px 0;
}

.box .dvrecords .records{
  margin-right: 5px;
}
</style>