
 <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a id="dashboard" href="<?= BASEURL.'/panel'; ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a id="siswa" href="<?= BASEURL.'/siswa'; ?>" class="nav-link">
             <i class="nav-icon far fa-user"></i>
                <p>
                  Data Siswa
                </p>
            </a>
          </li>
          <?php if ($_SESSION['role'] == 'superadmin') {?>
          <li class="nav-item">
          <li class="nav-item">
            <a id="pelanggaran" href="<?= BASEURL.'/pelanggaran'; ?>" class="nav-link">
              <i class="nav-icon fa fa-layer-group"></i>
                <p>
                  Data Pelanggaran
                </p>
            </a>
          </li>
          <?php }if ($_SESSION['role'] != 'kepsek' ) {?>
          <li class="nav-item">
            <a id="input" href="<?= BASEURL.'/pelanggaran/input'; ?>" class="nav-link">
              <i class="nav-icon fa fa-layer-group"></i>
                <p>
                  Input Pelanggaran
                </p>
            </a>
          </li>
          <?php }if ($_SESSION['role'] == 'superadmin') {?>
          <li class="nav-item">
            <a id="kelas" href="<?= BASEURL.'/kelas'; ?>" class="nav-link">
              <i class="nav-icon fa fa-layer-group"></i>
                <p>
                  Data Kelas
                </p>
            </a>
          </li>
        <?php } ?>
          <li class="nav-item">
            <a id="password" href="<?= BASEURL.'/auth/password'; ?>" class="nav-link">
              <i class="nav-icon far fa-user"></i>
                <p>
                  Ubah Password
                </p>
            </a>
          </li>
          <?php if ($_SESSION['role'] == 'superadmin') {?>
          <li class="nav-item">
            <a id="user" href="<?= BASEURL.'/auth/user'; ?>" class="nav-link">
              <i class="nav-icon far fa-user"></i>
                <p>
                  Data User
                </p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?= BASEURL.('/auth/logout'); ?>" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>