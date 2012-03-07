<?php

class RoomCode extends ActiveRecord\Model
{
    static $table_name = "room_codes";

    public static function generate_code($room_name)
    {
        $words = explode(' ', $room_name);
        $result = '';

        $i = 0;
        while ($i < count($words))
        {
            if (strlen($words[$i]) < 3) {
                for ($j = $i; $j < count($words) - 1; $j++)
                    $words[$j] = $words[$j + 1];
                unset($words[count($words) - 1]);
                continue;
            }
            $i++;
        }


        switch (count($words)) {

            case 0:
                return null;

            case 1:
                $i = 0;
                $j = 1;
                $z = 2;

                while (true) {
                    $code = strtoupper($room_name[$i] . $room_name[$j] . $room_name[$z]);
                    if (!RoomCode::find_by_code($code))
                        return $code;

                    if ($z >= strlen($room_name)) {
                        $j++;
                        $z = $j + 1;
                    }

                    if ($j >= strlen($room_name)) {
                        $i++;
                        $j = $i + 1;
                        $z = $j + 1;
                    }

                }

                break;

            case 2:
                $word1 = $words[0];
                $word2 = $words[1];

                $i = $j = $t = 0;

                while (true) {
                    $code = strtoupper($word1[$i] . $word2[$j] . ($t % 2 == 0 ? $word1[++$i] : $word2[++$j]));
                    if (!RoomCode::find_by_code($code))
                        return $code;
                    $t++;
                }

                break;

            default:

                for ($j = 0; $j < 5; $j++)
                    for ($i = 2; $i < count($words); $i++)
                    {
                        if (strlen($words[$i]) < $j)
                            continue;

                        $code = strtoupper($words[0][0] . $words[1][0] . $words[$i][$j]);

                        if (!RoomCode::find_by_code($code))
                            return $code;
                    }

                return "";

                break;
        }

        return $result;
    }

}
