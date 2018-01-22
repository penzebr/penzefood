<?php 
        if(empty($_SESSION['avatar'])){ 
          $avatar = 'images'.'/'.'user.png';
        }else{ 
         $avatar = $_SESSION['avatar'];
          } 
 
?>

  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- <div class="user-panel">
        <div class="pull-left image user-image">
          
         <?php  //echo "<img src='$avatar' class='img-circle' style='max-width:45px; max-height:42.391px;' alt='User Image'>" ?>
        </div>
        <div class="pull-left info">
          <p><?php //echo $_SESSION['nome'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Pesquisar...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
         <li class="header">Menu principal</li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-fw fa-cutlery"></i> <span>PenzeFood</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.php"><i class="fa fa-circle-o"></i>Dashboard</a></li>
          </ul>
        </li>

        <?php 

        if($_SESSION['codpermissao'] > 0)
        {
         echo '<li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Painel Administrativo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="cadastrarusu.php"><i class="fa fa-circle-o"></i>Cadastrar Usuários</a></li>
    
          </ul>
        </li>';}
        ?>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
