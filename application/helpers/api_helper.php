<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function checkSession()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_member",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		$decoded = json_decode($response, true);
		if (isset($decoded['description'])) {
			if ($decoded['description'] == "USER NOT LOGIN" || $decoded['description'] == "ERROR: USER NOT LOGIN") {
				login();
			}
		}
		return json_decode($response, true);
	}
}

function login()
{	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2402",
		CURLOPT_URL => "http://".cfg('api_ip').":2402/sk_login/alpenindo",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"id\":\"".cfg('user')."\",\"password\":\"".cfg('pwd')."\",\"verification_code\":\"\",\"version_code\":10}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: REGISTER_LOGIN",
			"VersionCode: 20",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {		
		$decoded = json_decode($response, true);

		$_SESSION['session'] = $decoded['session'];
		$_SESSION['data'] = $decoded['data'];				
	}
}

function getSchool($parent)
{	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2401",
		CURLOPT_URL => "http://".cfg('api_ip').":2401/sk_registration/get_reference",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"reference\":\"School\",\"parent\":\"".$parent."\",\"key\":\"\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: REGISTER_LOGIN",
			"VersionCode: 20",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function get_group($group)
{	
	if ($group == '' || $group == null) {
		$group = "all";
	}
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2403",
		CURLOPT_URL => "http://".cfg('api_ip').":2403/sk_group/get",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"".$group."\",\"group\":\"\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function update_group($group, $file, $name, $type)
{		
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2403",
		CURLOPT_URL => "http://116.90.165.246:2403/sk_group/update_profile_pic",
		CURLOPT_VERBOSE => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"groupId\":\"".$group."\",\"profile_pic\":\"".$name."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"profile_pic\"; filename=\"".$file."\"\r\nContent-Type: ".$type."\r\n\r\n\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(			
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	// unlink($tmp);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		echo $response;
		// redirect("/meme/me/group"."?msg=".urldecode($r)."&type_msg=success");
	}
}

function getall($group, $year, $key, $page)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2406",
		CURLOPT_URL => "http://".cfg('api_ip').":2406/sk_member/alpenindo/getall",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"group\":\"".$group."\",\"group_role\":\"member\",\"year_in\":\"".$year."\",\"key\":\"".$key."\",\"page\":".$page.",\"per_page\":20}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function get_bycardno($id)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2406",
		CURLOPT_URL => "http://".cfg('api_ip').":2406/sk_member/alpenindo/get_bycardno",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"card_no\":\"".$id."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: ab7f72d6-c34d-13fb-ea67-9635642700b9",
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function reset_password($member_id, $new)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2406",
		CURLOPT_URL => "http://".cfg('api_ip').":2406/sk_member/alpenindo/rst_pwd",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"member_id\":\"".$member_id."\",\"new_pwd\":\"".$new."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: c983c51f-e6f6-eeae-26d8-3a155dbd7f99",
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		redirect("/meme/user/user_mobile"."?msg=".urldecode('Reset password user succes')."&type_msg=success");
	}
}

function delete_member($member_id, $group_id)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2406",
		CURLOPT_URL => "http://".cfg('api_ip').":2406/sk_member/alpenindo/del",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"memberId\":\"".$member_id."\",\"groupId\":\"".$group_id."\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: c983c51f-e6f6-eeae-26d8-3a155dbd7f99",
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		redirect("/meme/user/user_mobile"."?msg=".urldecode('Delete user succes')."&type_msg=success");
	}
}

function tot_member()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_member",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_card_printed()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_card_printed",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_card_not_printed()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_card_not_printed",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_print_per_province()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_print_per_province",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_per_angkatan()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_angkatan",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_per_month()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_month",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_per_3month()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_3month",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_per_sma()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_sma",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {		
		return json_decode($response, true);
	}
}

function tot_per_smp()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_smp",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {		
		return json_decode($response, true);
	}
}

function tot_per_sd()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_sd",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {		
		return json_decode($response, true);
	}
}

function tot_per_tk()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_tk",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {		
		return json_decode($response, true);
	}
}

function tot_per_staff()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_per_staff",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {		
		return json_decode($response, true);
	}
}

function tot_print_per_sma()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_print_per_sma",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_print_per_smp()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_print_per_smp",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_print_per_sd()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_print_per_sd",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_print_per_tk()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_print_per_tk",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function tot_print_per_staff()
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://".cfg('api_ip').":2495/sk_report/alpenindo/tot_print_per_staff",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code').""
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function getMondays($y, $m)
{
	return new DatePeriod(
		new DateTime("first day of $y-$m"),
		DateInterval::createFromDateString('next week'),
		new DateTime("last day of $y-$m")
	);
}

function list_week_days($year, $month) {
	$first_month_day =  new DateTime("first day of $year-$month") ;
	foreach (getMondays($year, $month) as $monday) {
		echo "<br>".$monday->format(" Y-m-d\n").'-';        
		$first = $monday->format(" Y-m-d");
		$sunday  = $monday->modify('next sunday');
		echo $sunday->format(" Y-m-d\n");
		$last = $sunday->format(" Y-m-d");
		$array[] = array('first' => $first, 'last' => $last);
	}
	foreach ($array as $key => $value) {
		echo "<br>".$value['first'];
	}    
}

function get_article()
{	
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2412",
		CURLOPT_URL => "http://".cfg('api_ip').":2412/sk_article/get",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"Article|\",\"group\":\"\",\"group_role\":\"admin\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

function rar($group)
{
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_PORT => "2495",
		CURLOPT_URL => "http://http://".cfg('api_ip').":2495/sk_report/alpenindo/rar_not_printed",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"groupId\":\"".$group."\",\"page\":0,\"per_page\":20}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		CURLOPT_HTTPHEADER => array(
			"SessionId: ".$_SESSION['session']."",
			"VersionCode: ".cfg('version_code')."",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
		),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
	} else {
		return json_decode($response, true);
	}
}

// function get_event()
// {	
// 	$curl = curl_init();

// 	curl_setopt_array($curl, array(
// 		CURLOPT_PORT => "2405",
// 		CURLOPT_URL => "http://".cfg('api_ip').":2405/sk_event/get",
// 		CURLOPT_RETURNTRANSFER => true,
// 		CURLOPT_ENCODING => "",
// 		CURLOPT_MAXREDIRS => 10,
// 		CURLOPT_TIMEOUT => 30,
// 		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 		CURLOPT_CUSTOMREQUEST => "POST",
// 		CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"data\"\r\n\r\n{\"key\":\"Event|\",\"group\":\"\",\"group_role\":\"admin\"}\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
// 		CURLOPT_HTTPHEADER => array(
// 			"SessionId: ".$_SESSION['session']."",
// 			"VersionCode: ".cfg('version_code')."",
// 			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW"
// 		),
// 	));

// 	$response = curl_exec($curl);
// 	$err = curl_error($curl);

// 	curl_close($curl);

// 	if ($err) {
// 		echo "cURL Error #:" . $err;
// 	} else {
// 		return json_decode($response, true);
// 	}
// }

//===========================================================================================//
//------------------------------------AJAX---------------------------------------------------//
//===========================================================================================//
