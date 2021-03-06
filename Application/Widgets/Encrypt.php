<?php
////////////////////////////////////////////////////////////////////////////////
//                     ___  ____  _____ _____ ____  _                         //
//                    / ___||  _ \| ____| ____|  _ \( )_   _ _ __             //
//                    \___ \| |_) |  _| |  _| | | | |/| | | | '_ \            //
//                    ___) |  __/| |___| |___| |_| | | |_| | |_) |            //
//                   |____/|_|   |_____|_____|____/   \__,_| .__/             //
//                                                        |_|                 //
////////////////////////////////////////////////////////////////////////////////
namespace Widgets;
class Encrypt
{
    function generateRandomSalt()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 64; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];

        return $randomString;
    }

    /**
     * @param $email
     * @param $password
     * @param $salt
     * @return string
     */
    function getHash($email, $password, $salt)
    {
        $i_sha256 = hash("sha256", $email);
        $hashing = hash("sha256", strtoupper($i_sha256) . ':' . strtoupper($password) . ':' . $salt);
        return strtoupper($hashing);
    }
}
