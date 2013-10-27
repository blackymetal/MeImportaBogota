package com.i3dapps.meimportabogota.services;

import java.util.ArrayList;
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

public class ReporteWebService extends AsyncTask<String, Void, Boolean> {
	
	private HttpClient client;
	private HttpPost post;
	private HttpGet get;
	private HttpResponse response;
	private List<NameValuePair> values;

	@Override
	protected Boolean doInBackground(String... arg0){

		String jsonR = "";
		int code = -1;
		values = new ArrayList<NameValuePair>(5);

		if (arg0[0].equals("ADD_REPORT")) {
			
			values.add(new BasicNameValuePair("reportType_id", arg0[1]));
			values.add(new BasicNameValuePair("lat", arg0[2]));
			values.add(new BasicNameValuePair("lng", arg0[3]));
			values.add(new BasicNameValuePair("image", arg0[4]));
			values.add(new BasicNameValuePair("name", arg0[5]));

			try {

				client = new DefaultHttpClient();
				post = new HttpPost("meimportabogota/web/crearRegistro");
				post.setHeader("Accept", "application/json");
				post.setEntity(new UrlEncodedFormEntity(values));
				
				response = client.execute(post);
				HttpEntity httpEnti = response.getEntity();
				
				jsonR = EntityUtils.toString(httpEnti);
				Log.i("response CREAR USUARIO  : ", jsonR);

				JSONObject jsonObject = new JSONObject(jsonR);
				code = jsonObject.getInt("code");

				if (code == 1)
					return true;
				else
					return false;

			} catch (Exception error) {
				return false;
			}
		} else if (arg0[0].equals("GET_REPORT_TYPE")){
			return false;
		} else {
			return false;
		}

	}

	@Override
	protected void onPostExecute(Boolean result){
	}

}