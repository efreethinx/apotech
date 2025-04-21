<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Create default response success
     * 
     * @param array|null $data
     * @param string $message
     * @param int $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function ok($data = null, $message = 'success', $code = 200)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * Create default response failed
     * 
     * @param string|array $message
     * @param int $code
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function oops($message = '', $code = 400)
    {
        return response()->json([
            'code'    => $code,
            'message' => $message,
            'data'    => null
        ], $code);
    }
}
