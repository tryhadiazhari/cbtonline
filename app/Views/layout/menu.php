                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item mb-2 py-2" style="border-bottom: 1px gray solid">
                            <a href="./" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <?php
                        $this->db = \Config\Database::connect();
                        $this->menu = $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del 
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "'
                                            ORDER BY hazedu_menu.sort ASC")->getResultArray();

                        $this->submenu = $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del 
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "'
                                            ORDER BY hazedu_menu.sort ASC")->getResultArray();
                        ?>
                        <?php foreach ($this->menu as $menu) : ?>
                            <?php if ($menu['parent'] == '') : ?>
                                <li class="nav-item<?= ($menu['url'] == '#') ? ' has-treeview' : '' ?> mb-2">
                                    <a href="<?= (session()->lv == 1) ? '/admin' . $menu['url'] : $menu['url'] ?>" class="nav-link" id="<?= str_replace('/', '', $menu['url']) ?>">
                                        <i class="nav-icon fas <?= $menu['icon']; ?>"></i>
                                        <p><?= $menu['menu_name']; ?><?= ($menu['url'] == '#') ? ' <i class="fas fa-angle-left right"></i>' : '' ?></p>
                                    </a>
                                    <?php if ($menu['url'] == '#') : ?>
                                        <ul class="nav-treeview ml-2">
                                            <?php foreach ($this->submenu as $submenu) : ?>
                                                <?php if ($menu['kode_menu'] == $submenu['parent']) : ?>
                                                    <li class="nav-item">
                                                        <a href="<?= $submenu['url'] ?>" class="nav-link">
                                                            <i class="fal <?= $submenu['icon']; ?> fa-md text-right mx-2"></i>
                                                            <p><?= $submenu['menu_name'] ?></p>
                                                        </a>
                                                    </li>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endif ?>
                        <?php endforeach ?>
                    </ul>
                </nav>