<template>
  <div>
    <!-- fixed menu and sidebar -->

    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
              ><i class="fas fa-bars"></i
            ></a>
          </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
              <i class="fas fa-expand-arrows-alt"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <router-link to="/" class="brand-link">
          <span
            style="text-transform: capitalize"
            class="brand-text font-weight-light"
            >Admin Space</span
          >
        </router-link>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img
                :src="'/images/admin_pic.jpg'"
                class="img-circle elevation-2"
                alt="admin"
              />
            </div>
            <div class="info">
              <a href="#" class="d-block">Biza Abdelwadoud</a>
            </div>
          </div>

          <!-- SidebarSearch Form -->

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false"
            >
              <li class="nav-item">
                <router-link to="/">
                  <p class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                  </p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="tags">
                  <p class="nav-link"><i class="fas fa-hashtag"></i> tags</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="categories">
                  <p class="nav-link">
                    <i class="fas fa-layer-group"></i> categories
                  </p>
                </router-link>
              </li>

               <li class="nav-item">
                <router-link to="users">
                  <p class="nav-link">
                    <i class="fas fa-users"></i> users
                  </p>
                </router-link>
              </li>

              <li class="nav-item menu-open">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Starter Pages
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link active">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Active Page</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Inactive Page</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Simple Link
                    <span class="right badge badge-danger">New</span>
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <router-link to="categories">
                  <p class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Sign-out
                  </p>
                </router-link>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <router-view></router-view>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->

        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- Default to the left -->
        <strong
          >Copyright &copy; {{ new Date().getFullYear() }}
          <a
            target="_blank"
            href="https://www.linkedin.com/in/abdelwadoud-biza-378b18126/"
            >BIZA ABDELWADOUD</a
          >.</strong
        >
      </footer>
    </div>
    <!-- ./wrapper -->
    <!-- end fixed menu and sidebar -->
  </div>
</template>



