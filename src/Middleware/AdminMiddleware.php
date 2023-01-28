<?php

namespace App\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Entity\Admin;
use PHPUnit\Framework\MockObject\Rule\AnyParameters;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AdminMiddleware {

    private string $key = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

    public function generateJWT(Admin $admin): string {
        $iat = strtotime(date("Y-m-d H:i:s"));
        $exp = strtotime(date("Y-m-d H:i:s")) + 86400 * XXXXXXXXXXXXXXX;
        $payload = [
            ...
        ];
        return JWT::encode($payload, $this->key, 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
    }

    public function getAdminIdFromJWT(Request $request): int {
        try {
            $jwt = $request->headers->get("Authorization");
            if(empty($jwt))return 0;
            $jwt = XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
            $decoded = JWT::decode($jwt, new Key($this->key, 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'));
            //return $decoded;
            $decoded = json_decode(json_encode($decoded), true);
            if(array_key_exists("sub", $decoded))return (int)$decoded["sub"];
            return 0;
        } catch(SignatureInvalidException $signatureInvalidException){
            //print('Caught signatureInvalidException: '.  $signatureInvalidException->getMessage(). "\n");
            return 0;
        } catch(ExpiredException $expiredException){
            //print('Caught expiredException: '.  $expiredException->getMessage(). "\n");
            return 0;
        } catch(Exception $exception){
            //print('Caught exception: '.  $exception->getMessage(). "\n");
            return 0;
        }
        return 0;
    }
}