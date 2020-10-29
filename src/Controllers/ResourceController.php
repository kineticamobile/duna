<?php

namespace Kineticamobile\Duna\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kineticamobile\Atrochar\Models\Menu;

class ResourceController extends Controller
{

    public function index(Request $request, $mobile)
    {
        return view("duna::index", ["mobile" => $mobile]);
    }

    public function dashboard(Request $request, $mobile)
    {
        return view("duna::dashboard", ["mobile" => $mobile]);
    }

    public function register(Request $request)
    {
        $request->validate([ 'device_name' => 'required' ]);

        return $request->user()->createToken($request->device_name)->plainTextToken;
    }

    public function icon(Request $request, $mobile)
    {
        return response()
                ->view("duna::icon", ["mobile" => $mobile])
                ->header('Content-Type', 'image/svg+xml');
    }

    public function configure_sw(Request $request, $mobile)
    {
        return $this->js("configure_sw", $mobile);
    }

    public function sql(Request $request, $mobile)
    {
        return $this->js("sql", $mobile);
    }

    public function manifest(Request $request, $mobile)
    {
        return $this->js("manifest", $mobile);
    }

    public function swConfiguration(Request $request, $mobile)
    {
        return $this->js("sw-configuration", $mobile);
    }

    public function sw(Request $request, $mobile)
    {
        return $this->js("sw", $mobile);
    }

    public function basic(Request $request, $mobile)
    {
        return $this->js("basic", $mobile);
    }

    public function idbKeyval(Request $request, $mobile)
    {
        return $this->js("idb-keyval", $mobile);
    }

    public function axios(Request $request, $mobile)
    {
        return $this->js("axios", $mobile);
    }

    private function js($view, $mobile)
    {
        return response()
                ->view("duna::$view", ["mobile" => $mobile])
                ->header('Content-Type', 'application/javascript');
    }


}
