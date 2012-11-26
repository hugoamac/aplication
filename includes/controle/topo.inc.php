<div id="header">
    <h1>
        <a href="/controle/inicio.php">Controle Administrativo</a>
    </h1>
    <ul>
        <li><img src="/images/comuns/no-pic.jpg" width="45" /> Olá <?= Auth::userData()->nome ?></li>
        <li><a href="#">Minha Conta</a></li>
        <li><a href="/controle/processa.php?sOP=logout">sair</a></li>
    </ul>
</div>