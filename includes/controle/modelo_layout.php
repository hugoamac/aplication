<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/autoload.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Controle Administrativo</title>
        <link href="/css/controle/controle.css" rel="stylesheet" type="text/css"/>
        <!--JQUERY-->
        <script src="/library/jquey.js" type="text/javascript"></script>
        <!-- JQUERY UI-->
        <link href="/library/jquery_ui/css/smoothness/jquey_ui.css" rel="stylesheet" type="text/css"/>
        <script src="/library/jquery_ui/js/jquey_ui.js" type="text/javascript"></script>
        <!-- JQUERY VALIDATE-->
        <script src="/library/jquery_validate/jquery_validate.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="main">
            <!-- DIV HEADER -->
            <div id="header">
                <h1>
                    <a href="#">Controle Administrativo</a>
                </h1>
                <ul>
                    <li><img src="/images/comuns/no-pic.jpg" width="45" /> Olá <?= Auth::userData()->nome ?></li>
                    <li><a href="#">Minha Conta</a></li>
                    <li><a href="/controle/processa.php?sOP=logout">sair</a></li>
                </ul>
            </div>
            <!-- DIV CONTAINER -->
            <div id="container">
                <!-- DIV MENU_LEFT-->
                <div id="menu_left">
                    <ul class="navMenu">
                        <li>Site</li>
                        <li><a href="#">Banner</a></li>
                        <li><a href="#">Galeria</a></li>
                        <li><a href="#">Notícias</a></li>
                        <li><a href="#">Newsletter</a></li>
                    </ul>

                    <ul class="navMenu">
                        <li>Controle de Acesso</li>
                        <li><a href="#">Grupos</a></li>
                        <li><a href="#">Usuários</a></li>
                        <li><a href="#">Recursos</a></li>
                        <li><a href="#">Log do Sistema</a></li>
                    </ul>
                </div>
                <!-- DIV CONTENT-->
                <div id="content">
                    <ul id="breadcrumbs">
                        <li>Controle de Acesso</li>
                        <li><a href="#">Grupos</a></li>
                        <li><a href="#">Cadastrar Grupo</a></li>
                    </ul>

                    <h1>Grupos</h1>

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

                    <ul id="Paginacao">
                        <li><a href="#">Anterior</a></li>
                        <li><a href="#" class="PaginacaoActive">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">Próximo</a></li>
                    </ul>


                </div>
                <div class="clear"></div>
            </div>
            <!-- DIV FOOTER-->
            <div id="footer">footer</div>

        </div>
    </body>
</html>

