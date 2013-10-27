package com.i3dapps.meimportabogota.services;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Timestamp;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONObject;

import android.os.AsyncTask;
import android.util.Log;

public class ReporteWebService extends AsyncTask<String, Void, String> {
	
	private HttpClient client;
	private HttpPost post;
	private HttpGet get;
	private HttpResponse response;
	private List<NameValuePair> values;

	@Override
	protected String doInBackground(String... arg0){

		String jsonR = "";
		String code = "false";
		values = new ArrayList<NameValuePair>(7);

		if (arg0[0].equals("add_report")) {
			
			String action = arg0[0];
			String private_key = "meimportabogota20131026";
			Date fecha = new Date();
			Timestamp timestamp = new Timestamp(fecha.getTime());	
			timestamp.getTime();
			String sign = private_key+"~"+action+"~"+timestamp;
			MessageDigest mdEnc;
			String signMD5="no funciono";
			
			try {
				mdEnc = MessageDigest.getInstance("MD5");
				mdEnc.update(sign.getBytes(), 0, sign.length());
				signMD5 = new BigInteger(1, mdEnc.digest()).toString(16);
			} catch (NoSuchAlgorithmException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} 
			
			
			values.add(new BasicNameValuePair("reporttype_id", arg0[1]));
			values.add(new BasicNameValuePair("lat", arg0[2]));
			values.add(new BasicNameValuePair("lng", arg0[3]));
			values.add(new BasicNameValuePair("image", arg0[4]));
			values.add(new BasicNameValuePair("name", arg0[5]));
			values.add(new BasicNameValuePair("sign", signMD5));
			values.add(new BasicNameValuePair("timestamp", String.valueOf(timestamp.getTime())));

			try {

				client = new DefaultHttpClient();
				post = new HttpPost("http://127.0.0.1/MeiImportaBogota/web/api/execute/add_report");
				post.setHeader("Accept", "application/json");
				post.setEntity(new UrlEncodedFormEntity(values));
				
				response = client.execute(post);
				HttpEntity httpEnti = response.getEntity();
				
				jsonR = EntityUtils.toString(httpEnti);
				Log.i("response CREAR USUARIO  : ", jsonR);

				JSONObject jsonObject = new JSONObject(jsonR);
				code = jsonObject.getString("response");

				if (code.equals("true"))
					return "true";
				else
					return "false";

			} catch (Exception error) {
				return "false";
			}
		} else if (arg0[0].equals("GET_REPORT_TYPE")){
			return "false";
		} else {
			return "false";
		}

	}


}
