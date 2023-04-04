<?php

namespace App\Controllers;

use App\Models\AppsModel;
use App\Models\BanksoalModel;
use App\Models\DistrictsModel;
use App\Models\GtkModel;
use App\Models\JadwalModel;
use App\Models\JenjangModel;
use App\Models\LembagaModel;
use App\Models\LoginModel;
use App\Models\MapelModel;
use App\Models\PdModel;
use App\Models\PengumumanModel;
use App\Models\ProvinceModel;
use App\Models\RegenciesModel;
use App\Models\RombelModel;
use App\Models\SoalModel;
use App\Models\VillagesModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
        $this->email = \Config\Services::email();
        $this->login = new LoginModel();
        $this->pd = new PdModel();
        $this->rombel = new RombelModel();
        $this->mapel = new MapelModel();
        $this->apps = new AppsModel();
        $this->pengumuman = new PengumumanModel();
        $this->sp = new LembagaModel();
        $this->pendidikan = new JenjangModel();
        $this->provinsi = new ProvinceModel();
        $this->kabupaten = new RegenciesModel();
        $this->kecamatan = new DistrictsModel();
        $this->kelurahan = new VillagesModel();
        $this->gtk = new GtkModel();
        $this->banksoal = new BanksoalModel();
        $this->soal = new SoalModel();
        $this->jadwal = new JadwalModel();
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
    }
}
