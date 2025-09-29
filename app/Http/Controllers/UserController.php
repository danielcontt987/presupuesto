<?php

namespace App\Http\Controllers;

use App\Microservices\User;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Redirect::to('/admin');
            return response()->json(['status' => 200]);
        }

        return response()->json(['status' => 401], 401);
    }

    public function loginToQr(Request $request)
    {

        $qr = $request->input('qr');
        $user = ModelsUser::where('number_work', $qr)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'Usuario no encontrado'], 404);
        }

        Auth::login($user);

        Redirect::to('/admin');
        return response()->json(['status' => 200]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['status' => 200]);
    }

    public function consultUser()
    {
        return response()->json(["status" => 200, "permissions" => Auth::user()->getPermission()], 200);
    }

    public function qrGenerate()
    {
        $numero = "1111";

        $qr = \QrCode::format('svg')->size(300)->generate($numero);
        $success = Storage::disk('google')->put("qrcodes/{$numero}.svg", $qr);

        if ($success) {
            return '✅ Archivo subido correctamente a Google Drive.' . ' ' . $success;
        } else {
            return '❌ Falló la subida del archivo.';
        }
    }

    public function guardarQR($numero)
    {
        $qr = QrCode::format('png')->size(300)->generate($numero);

        Storage::disk('public')->put("qrcodes/{$numero}.png", $qr);

        return response()->download(storage_path("app/public/qrcodes/{$numero}.png"));


        // php artisan storage:link
    }

    public function registerFace(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|email',
        //     'descriptor' => 'required|array|size:128',
        // ]);



        $user = ModelsUser::where('email', $request->email)->firstOrFail();
        $user->face_descriptor = json_encode($request->descriptor);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Rostro guardado.']);
    }

    public function loginFace(Request $request)
    {
        $request->validate([
            'descriptor' => 'required|array|size:128',
        ]);

        $inputDescriptor = $request->descriptor;

        $users = ModelsUser::whereNotNull('face_descriptor')->get();

        foreach ($users as $user) {
            $stored = json_decode($user->face_descriptor, true);
            $distance = $this->euclideanDistance($inputDescriptor, $stored);
            if ($distance < 0.6) {
                Auth::login($user);
                Redirect::to('/admin');
                return response()->json(['status' => 200]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Rostro no reconocido'], 401);
    }

    private function euclideanDistance($a, $b)
    {
        return sqrt(array_sum(array_map(fn($i, $j) => pow($i - $j, 2), $a, $b)));
    }
}
