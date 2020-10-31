<?php

namespace Kineticamobile\Duna\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kineticamobile\Atrochar\Models\Menu;
use Kineticamobile\Duna\Duna;

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

    public function bg(Request $request, $mobile)
    {
        return $this->filejpg("bg");
    }

    public function altBg(Request $request, $mobile)
    {
        return $this->filejpg("alt-bg");
    }

    public function profileMobile(Request $request, $mobile)
    {
        return $this->filejpg("profile-mobile");
    }

    public function profileDesktop(Request $request, $mobile)
    {
        return $this->filejpg("profile-desktop");
    }

    public function iconMobile(Request $request, $mobile)
    {
        return $this->filepng("icon-mobile");
    }

    public function icon(Request $request, $mobile)
    {
        return $this->filesvg("icon");
    }

    public function tailwind(Request $request, $mobile)
    {
        return $this->filecss("tailwind");
    }

    public function configure_sw(Request $request, $mobile)
    {
        return $this->js("configure_sw", $mobile);
    }

    public function sql(Request $request, $mobile)
    {
        return $this->filejs("sql", $mobile);
    }

    public function manifest(Request $request, $mobile)
    {
        return $this->json("manifest", $mobile);
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
        return $this->filejs("idb-keyval");
    }

    public function axios(Request $request, $mobile)
    {
        return $this->filejs("axios");
    }

    private function js($view, $mobile)
    {
        return response()
                ->view("duna::$view", ["mobile" => $mobile])
                ->header('Content-Type', 'application/javascript');
    }

    private function filejs($filename)
    {
        return response()->file(Duna    ::folder() . "assets/$filename.js", ['Content-Type' => 'application/javascript']);
    }

    private function filesvg($filename)
    {
        return response()->file(Duna    ::folder() . "assets/$filename.svg", ['Content-Type' => 'image/svg+xml']);
    }

    private function filejpg($filename)
    {
        return response()->file(Duna    ::folder() . "assets/$filename.jpg", ['Content-Type' => 'image/jpeg']);
    }

    private function filepng($filename)
    {
        return response()->file(Duna    ::folder() . "assets/$filename.png", ['Content-Type' => 'image/png']);
    }

    private function filecss($filename)
    {
        return response()->file(Duna    ::folder() . "assets/$filename.css", ['Content-Type' => 'text/css']);
    }

    private function json($view, $mobile)
    {
        return response()
                ->view("duna::$view", ["mobile" => $mobile])
                ->header('Content-Type', 'application/json');
    }


}
