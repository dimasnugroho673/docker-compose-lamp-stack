<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use TimItDiskominfoBintan\BintanSSOClient\Controllers\BintanSSOAuthController as BintanSSO;

/**
 * Class BintanSSOController
 * 
 * Controller untuk menangani proses autentikasi client yang menggunakan Bintan SSO.
 * 
 * @package TimItDiskominfoBintan\BintanSSOClient
 */
class BintanSSOController extends Controller
{
    private $bintanSSO;

    public function __construct()
    {
        // Instansiasi BintanSSO
        $this->bintanSSO = new BintanSSO();
    }

    public function login()
    {
        // Login ke halaman Bintan SSO
        return $this->bintanSSO->signIn();
    }

    // Jika login berhasil, maka akan masuk ke fungsi ini (callbackFromSSO)
    public function callbackFromSSO(Request $request)
    {
        // Dapatkan data user
        $result = $this->bintanSSO->getUserInfo($request);
        $data = $result['data'];

        // mulai dari sini kita bisa set session, simpan data ke db, pokoknya terserah mau ngapain...

        // [START CONTOH] - ini hanya contoh saja dengan kasus: User boleh masuk jika akun sudah terdaftar di aplikasi ini
        $user = User::where('username', $data['username'])->first();

        if (!$user) {
            throw new \Exception("Pegawai belum terdaftar, hubungi admin aplikasi ini untuk mendaftarkan akun " . $data['name']);
        }

        // Login user secara manual ke aplikasi ini
        Auth::loginUsingId($user->id);

        if (auth()->check()) {
            // Jika user sudah login
            return $this->_redirectIfauthenticated();
        }

        return $result;
        // [END CONTOH]
    }

    private function _redirectIfauthenticated()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return redirect('admin/dashboard');
                break;
            case 'opd':
                return redirect('opd/dashboard');
                break;
            case 'teknisi':
                return redirect('admin/dashboard');
                break;
            default:
                return redirect('/');
                break;
        }
    }
}
