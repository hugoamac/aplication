<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/anexos.inc.php"); ?>
    </head>
    <body>
        <div id="main">
            <!-- DIV HEADER -->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/topo.inc.php"); ?>
            <!-- DIV CONTAINER -->
            <div id="container">
                <!-- DIV MENU_LEFT-->
                <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/menu.inc.php"); ?>
                <!-- DIV CONTENT-->
                <div id="content">
                    <ul id="breadcrumbs">
                        <li>Inicio</li>                     
                    </ul>

                    <h1>Inicio</h1>

                    <br/>

                    <a href="#" class="Botao">Adicionar</a>

                    <form method="get" action="#" class="Filtro">
                        <h3>Pesquisar</h3>

                        <table>
                            <tr>
                                <th>Nome:</th>
                                <td><input type="text" name="grupo" value=""/></td>
                            </tr>  
                            <tr>
                                <th>Tipo:</th>
                                <td>
                                    <select name="grupo">
                                        <option>Selecione</option>
                                        <option>Selecione 1</option>
                                        <option>Selecione 2</option>
                                        <option>Selecione 3</option>
                                        <option>Selecione 4</option>
                                        <option>Selecione 5</option>
                                    </select>
                                </td>
                            </tr>   
                            <tr>
                                <th>Ativo:</th>
                                <td><input type="checkbox" name="grupo" value=""/></td>
                            </tr> 
                            <tr>
                                <td></td>
                                <td>
                                    <button type="button">Pesquisar</button>
                                </td>
                            </tr> 
                        </table>
                    </form>


                    <table class="Lista">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Ativo</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Codigo</td>
                                <td>Nome</td>
                                <td>Tipo</td>
                                <td>Ativo</td>
                                <td>
                                    <a href="#" class="Botao">Editar</a>
                                    <a href="#" class="Botao">Apagar</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Codigo</td>
                                <td>Nome</td>
                                <td>Tipo</td>
                                <td>Ativo</td>
                                <td>
                                    <a href="#" class="Botao">Editar</a>
                                    <a href="#" class="Botao">Apagar</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Codigo</td>
                                <td>Nome</td>
                                <td>Tipo</td>
                                <td>Ativo</td>
                                <td>
                                    <a href="#" class="Botao">Editar</a>
                                    <a href="#" class="Botao">Apagar</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- PAGINACAO -->
                    <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/paginacao.inc.php"); ?>

                </div>
                <div class="clear"></div>
            </div>
            <!-- DIV FOOTER-->
            <? require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/controle/footer.inc.php"); ?>

        </div>
    </body>
</html>

