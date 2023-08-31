<!-- Sidebar -->
<ul class="sidebar bg-body-tertiary navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('/'); ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Agora RN</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <h6 class="dropdown-header">Pedidos de Inserção:</h6>
            <a class="dropdown-item" href="<?php echo base_url('/PI/pisLancados'); ?>"><i class="fas fa-fw fa-pen"></i>Lançados</a>
            <a class="dropdown-item" href="<?php echo base_url('/PI/pisBaixados'); ?>"><i class="fas fa-fw fa-check-double"></i>Baixados</a> 
            <a class="dropdown-item" href="<?php echo base_url('/PI/pisComissoes'); ?>"><i class="fas fa-fw fa-file-invoice-dollar"></i>Comissões</a> 
        </div>
    </li>
</ul>