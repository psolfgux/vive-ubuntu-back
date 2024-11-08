<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PlayerController extends Controller
{
    // Registro de jugador
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:players',
            'password' => 'required|string|min:6',
        ]);

        $hash = bcrypt($request->password);

        $player = Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hash
        ]);

        return response()->json([
            'player' => $player
        ], 201);
    }

    // Login de jugador
    /*public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid credentials',
                'email' => $request->email,
                'pass'  => $request->password,
                'hash' => bcrypt($request->password)
            ], 401);
        }

        return $this->respondWithToken($token);
    }*/

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');
    $player = Player::where('email', $credentials['email'])->first();

    if ($player && Hash::check($credentials['password'], $player->password)) {
        $token = auth('player')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'estado' => 'ok',
            'id' => $player->id,
            'name' => $player->name,
            'email' => $player->email,
            'token' => $token
        ], 200);
    } else {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}


public function loginWithGoogle(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'email' => 'required|email',
        'name' => 'required|string',
    ]);

    // Buscar si el jugador ya existe por su email
    $player = Player::where('email', $request->email)->first();

    if ($player) {
        // Si el jugador existe, generar un token JWT
        try {
            $token = JWTAuth::fromUser($player);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    } else {
        // Si el jugador no existe, crear uno nuevo
        $player = Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456') // Contraseña predeterminada
        ]);

        // Generar un token para el nuevo usuario
        try {
            $token = JWTAuth::fromUser($player);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Retornar respuesta en formato JSON
    return response()->json([
        'estado' => 'ok',
        'id' => $player->id,
        'name' => $player->name,
        'email' => $player->email,
        'token' => $token
    ], 200);
}



    // Refrescar token JWT
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    // Ver todos los jugadores (solo admins)
    public function index()
    {
        $players = Player::all();
        return response()->json($players);
    }

    // Ver un jugador específico
    public function show($id)
    {
        $player = Player::find($id);
        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }
        return response()->json($player);
    }

    // Actualizar un jugador
    public function update(Request $request, $id)
    {
        $player = Player::find($id);
        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        $player->update($request->all());

        return response()->json(['message' => 'Player updated', 'player' => $player]);
    }

    // Eliminar un jugador
    public function destroy($id)
    {
        $player = Player::find($id);
        if (!$player) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        $player->delete();
        return response()->json(['message' => 'Player deleted']);
    }

    // Logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }

    // Función para responder con el token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
