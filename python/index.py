import os
import sys
import time
import json
import random
import hashlib
import requests  # pip install requests


def get_ds():
    salt = '1OUn34iIy84ypu9cpXyun2VaQ2zuFeLm'
    timestamp = str(int(time.time()))
    random_string_list = '0123456789abcdefghijklmnopqrstuvwxyz'
    random_string = ''.join(random.sample(random_string_list, 6))
    ds_string = 'salt=' + salt + '&t=' + timestamp + '&r=' + random_string
    ds_md5 = hashlib.md5(ds_string.encode(encoding='UTF-8')).hexdigest()
    ds = timestamp + ',' + random_string + ',' + ds_md5
    return ds


def get_game_info(cookies):
    req = requests.get(
        "https://api-takumi.mihoyo.com/binding/api/getUserGameRolesByCookie?game_biz=hk4e_cn", cookies=cookies)
    result = json.loads(req.text)
    return result


def cookie_str2dict(cookie_string):
    cookie = cookie_string.replace(" ", "").split(";")
    cookies = {}
    for i in cookie:
        cookies[i.split("=")[0]] = i.split("=")[1]
    return cookies


def bbs_sign_reward(cookies, ds, game_info):
    url = "https://api-takumi.mihoyo.com/event/bbs_sign_reward/sign"
    headers = {
        'DS': ds,
        'x-rpc-app_version': '2.33.1',
        'x-rpc-client_type': '4',
        "x-rpc-device_id": hashlib.md5((str(time.time())+"MIHOYO").encode(encoding='UTF-8')).hexdigest()
    }
    post_data = {
        "act_id": "e202009291139501",
        "region": game_info['data']['list'][0]['region'],
        "uid": game_info['data']['list'][0]['game_uid']
    }
    req = requests.post(url=url, data=json.dumps(
        post_data), headers=headers, cookies=cookies)
    result = json.loads(req.text)
    return result


def check_in(cookie_string):
    cookies = cookie_str2dict(cookie_string)
    game_info = get_game_info(cookies)
    if (game_info['retcode'] != 0):
        print("Failed to get game info")
        print(game_info)
    else:
        print("Successfully obtained game information")
        # print(game_info)
        check_in_res = bbs_sign_reward(cookies, get_ds(), game_info)
        if(check_in_res['retcode'] == 0):
            print("Sign in successfully")
        else:
            print("Failed to sign in")
            print(check_in_res)

# python index.py "_MHYUUID=bd20878a-1d35-457c-b84c-9ea929ced396; _ga=GA1.2.128251121.1653128272; _gid=GA1.2.321587272.1653128272; _gat=1"
check_in(sys.argv[1])
