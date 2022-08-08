<?php
class genshin_checkin
{
    public function __construct($cookie)
    {
        $this->cookie = $cookie;
        $ds = $this->get_ds('1OUn34iIy84ypu9cpXyun2VaQ2zuFeLm');
        $this->headers = [
            "DS: $ds",
            'x-rpc-app_version: 2.33.1',
            'x-rpc-client_type: 4',
            "x-rpc-device_id: 7ab3bc70b846186b9da1e816e6c6f08d"
        ];
    }

    public function main()
    {
        $game_info = json_decode($this->get_url("https://api-takumi.mihoyo.com/binding/api/getUserGameRolesByCookie?game_biz=hk4e_cn"));
        $post_data = [
            "act_id" => "e202009291139501",
            "region" => $game_info->data->list[0]->region,
            "uid" => $game_info->data->list[0]->game_uid
        ];
        $result = json_decode($this->post_url("https://api-takumi.mihoyo.com/event/bbs_sign_reward/sign", $post_data));
        if ($result->retcode == 0) {
            return ['status' => true, 'data' => $result];
        } else {
            return ['status' => false, 'data' => $result];
        }
    }

    private function get_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookie);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


    private function post_url($url, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_PROXY, '127.0.0.1:8888');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_COOKIE, $this->cookie);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    private function random_string($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    private function get_ds($salt)
    {
        $timestamp = strval(time());
        $random_string = $this->random_string(6);
        $ds_string = 'salt=' . $salt . '&t=' . $timestamp . '&r=' . $random_string;
        $ds_md5 = md5($ds_string);
        $ds = $timestamp . ',' . $random_string . ',' . $ds_md5;
        return $ds;
    }
}

// $check_in = new genshin_checkin("_MHYUUID=bd20878a-1d35-457c-b84c-9ea929ced396; _ga=GA1.2.128251121.1653128272; _gid=GA1.2.321587272.1653128272; _gat=1");
// var_dump($check_in->main());
